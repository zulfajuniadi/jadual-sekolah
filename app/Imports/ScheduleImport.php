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

    public function toTime($time){

        if($time <= 1 && $time >= 0){
            $hours = floor($time * 24); 
            $minute_fraction = ($time * 24) - $hours;
            $minutes = $minute_fraction * 60; 
            $toTime = $hours.":".$minutes;
            return $toTime;
        }
        
        return 0;
    }

    public function model(array $row)
    {
        $start_time     =  self::toTime($row['Mula Pada']);
        $end_time       =  self::toTime($row['Akhir Pada']);

        return new Schedule([
            'user_id'           => $this->user_id,
            'child_id'          => $this->child_id,
            'day'               => $row['Nombor Hari'], 
            'start_time'        => $start_time,
            'end_time'          => $end_time,
            'name'              => $row['Nama Kelas'],
            'class_url'         => $row['Link Kelas']
        ]);
    }
}
