<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ScheduleExport implements FromView, ShouldAutoSize
{
    function __construct($user_id, $child_id) {
        $this->user_id = $user_id;
        $this->child_id = $child_id;
    }

    public function view(): View
    {
        $schedules = Schedule::
            where('user_id', $this->user_id)
            ->where('child_id', $this->child_id)
            ->get();

        return view('jadual')->with('schedules', $schedules);
    }
}
