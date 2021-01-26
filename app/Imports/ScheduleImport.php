<?php

namespace App\Imports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

HeadingRowFormatter::default('none');

class ScheduleImport implements ToModel, WithHeadingRow
{
    function __construct($user_id, $child_id) {
        $this->user_id = $user_id;
        $this->child_id = $child_id;
    }

    public function model(array $row)
    {
        return new Schedule([
            'user_id'           => $this->user_id,
            'child_id'          => $this->child_id,
            'day'               => $row['Nombor Hari'], 
            'start_time'        => $row['Mula Pada'], 
            'end_time'          => $row['Akhir Pada'], 
            'name'              => $row['Nama Kelas'],
            'class_url'         => $row['Link Kelas']
        ]);
    }
}
