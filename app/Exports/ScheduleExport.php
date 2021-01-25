<?php

namespace App\Exports;

use App\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{
    public function view(): View
    {
        return view('jadual', []);
    }
}
