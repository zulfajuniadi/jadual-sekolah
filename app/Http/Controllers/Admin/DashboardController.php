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
                
                foreach($model->schedules()->where('day', $day)->withoutGlobalScope(MyChildScope::class)->get() as $schedule) {
                    Attendance::withoutGlobalScope(MyChildScope::class)->updateOrCreate([
                        'user_id' => $schedule->user_id,
                        'child_id' => $schedule->child_id,
                        'schedule_id' => $schedule->id,
                        'class_date' => date('Y-m-d'),
                    ], []);
                }

                return $model;
            });
        }
        if($request->get('attend')) {
            $scheduleId = $request->get('attend');
            $current = Attendance::withoutGlobalScope(MyChildScope::class)->where([
                'schedule_id' => $scheduleId,
                'class_date' => date('Y-m-d'),
            ])->first();
            if($current) {
                $schedule = Schedule::withoutGlobalScope(MyChildScope::class)->find($scheduleId);

                if($schedule && $schedule->day == date('N') && $current->attended_at == null) {
                    Child::withoutGlobalScope(MyChildScope::class)->find($current->child_id)->increment('points');
                }
                Attendance::withoutGlobalScope(MyChildScope::class)->updateOrCreate([
                    'schedule_id' => $scheduleId,
                    'class_date' => date('Y-m-d'),
                ], [
                    'attended_at' => Carbon::now(),
                ]);
            }
            return 'ok';
        }

        return view('welcome');
    }
}
