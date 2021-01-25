<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Child;
use App\Models\Schedule;
use App\Models\Scopes\MyChildScope;
use App\Models\User;
use Carbon\Carbon;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if($day = $request->get('class')) {
            return Child::orderBy('name')->select('id', 'name', 'points')->get()->map(function($model) use ($day) {
                $model->schedules = $model->schedules()
                    ->where('day', $day)
                    ->orderBy('start_time')
                    ->select('id', 'name', 'start_time', 'end_time', 'class_url')
                    ->get();
                
                foreach($model->schedules()->where('day', $day)->orderBy('start_time')->get() as $schedule) {
                    if($schedule->day == date('N')) {
                        $attendance = Attendance::updateOrCreate([
                            'user_id' => $schedule->user_id,
                            'child_id' => $schedule->child_id,
                            'schedule_id' => $schedule->id,
                            'class_date' => date('Y-m-d'),
                        ], []);
                        foreach($model->schedules as $schedule) {
                            if($schedule->id == $attendance->schedule_id && $attendance->attended_at != null) {
                                $schedule->attended = true;
                            }
                        }
                    }
                }
    
                return $model;
            });
        }
        return view('dashboard');
    }

    public function view(Request $request, $slug)
    {
        $user = User::wherePublicSlug($slug)->firstOrFail();
        if($day = $request->get('class')) {
            return Child::whereUserId($user->id)->orderBy('name')->withoutGlobalScope(MyChildScope::class)->select('id', 'name', 'points')->get()->map(function($model) use ($day) {
                $model->schedules = $model->schedules()->withoutGlobalScope(MyChildScope::class)
                    ->where('day', $day)
                    ->orderBy('start_time')
                    ->select('id', 'name', 'start_time', 'end_time', 'class_url')
                    ->get();
                
                foreach($model->schedules()->where('day', $day)->orderBy('start_time')->withoutGlobalScope(MyChildScope::class)->get() as $schedule) {
                    if($schedule->day == date('N')) {
                        $attendance = Attendance::withoutGlobalScope(MyChildScope::class)->updateOrCreate([
                            'user_id' => $schedule->user_id,
                            'child_id' => $schedule->child_id,
                            'schedule_id' => $schedule->id,
                            'class_date' => date('Y-m-d'),
                        ], []);
                        foreach($model->schedules as $schedule) {
                            if($schedule->id == $attendance->schedule_id && $attendance->attended_at != null) {
                                $schedule->attended = true;
                            }
                        }
                    }
                }

                return $model;
            });
        }
        if($request->get('attend')) {
            $scheduleId = $request->get('attend');
            $attendance = Attendance::withoutGlobalScope(MyChildScope::class)->where([
                'schedule_id' => $scheduleId,
                'class_date' => date('Y-m-d'),
            ])->first();
            if($attendance) {
                $schedule = Schedule::withoutGlobalScope(MyChildScope::class)->find($scheduleId);

                if($schedule && 
                    $schedule->day == date('N') && 
                    $attendance->attended_at == null &&
                    abs(date('H') - substr($schedule->start_time, 0, 2)) < 2
                ) {
                    Child::withoutGlobalScope(MyChildScope::class)->find($attendance->child_id)->increment('points');
                    $attendance->attended_at = Carbon::now();
                    $attendance->save();
                } else {
                    return [
                        'message' => 'noop',
                        'sc_day' => $schedule->day,
                        'td_day' => date('N'),
                        'start' => $schedule->start_time,
                        'diff' => abs(date('H') - substr($schedule->start_time, 0, 2))
                    ];
                }
            } else {
                return 'attendance not found';
            }
            return 'ok';
        }

        return view('welcome');
    }

    public function calendar($slug)
    {
        $user = User::wherePublicSlug($slug)->firstOrFail();
        $vCalendar = new Calendar(url()->current());
        $vCalendar->setName('JadualKu Calendar - ' . $user->name);
        $vCalendar->setTimezone(config('app.timezone'));
        $dayMaps = [
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
            '7' => 'Sunday',
        ];
        $occurenceMaps = [
            '1' => 'MO',
            '2' => 'TU',
            '3' => 'WE',
            '4' => 'TH',
            '5' => 'FR',
            '6' => 'SA',
            '7' => 'SU',
        ];
        foreach($user->schedules()->withoutGlobalScope(MyChildScope::class)->get() as $schedule) {
            $child = Child::withoutGlobalScope(MyChildScope::class)->find($schedule->child_id);
            $startTime = date('Y-m-d ', strtotime('last ' . $dayMaps[$schedule->day])) . $schedule->start_time;
            $endTime = date('Y-m-d ', strtotime('last ' . $dayMaps[$schedule->day])) . $schedule->end_time;
            $vEvent = new Event();
            $vEvent
                ->setUniqueId($user->public_slug . $schedule->id)
                ->setDtStart(new \DateTime($startTime))
                ->setDtEnd(new \DateTime($endTime))
                ->setSummary($schedule->name . ' - ' . $child->name)
                ->addRecurrenceRule((new RecurrenceRule())->setByDay($occurenceMaps[$schedule->day])->setUntil(new \DateTime((date('Y') + 1) . '-01-01 00:00:00')))
                ;
            if($schedule->class_url) {
                $vEvent->addUrlAttachment($schedule->class_url);
            }
            $vCalendar->addComponent($vEvent);
        }
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="Kalendar JadualKu ' . $user->name . '.ics"');
        return $vCalendar->render();
    }
}
