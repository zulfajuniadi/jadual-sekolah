<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Child;
use App\Models\Schedule;
use App\Models\Scopes\MyChildScope;
use App\Models\User;
use Carbon\Carbon;
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
                        $schedule->day,
                        date('N'),
                        $schedule->start_time,
                        abs(date('H') - substr($schedule->start_time, 0, 2))
                    ];
                }
            } else {
                return 'attendance not found';
            }
            return 'ok';
        }

        return view('welcome');
    }
}
