<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Scopes\MyChildScope;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if($day = $request->get('class')) {
            return Child::orderBy('name')->select('id', 'name')->get()->map(function($model) use ($day) {
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
            return Child::orderBy('name')->withoutGlobalScope(MyChildScope::class)->select('id', 'name')->get()->map(function($model) use ($day) {
                $model->schedules = $model->schedules()->withoutGlobalScope(MyChildScope::class)
                    ->where('day', $day)
                    ->orderBy('start_time')
                    ->select('id', 'name', 'start_time', 'end_time', 'class_url')
                    ->get();
                return $model;
            });
        }

        return view('welcome');
    }
}
