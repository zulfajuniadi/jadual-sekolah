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

        $time_regex = "/[0-9.-][0-9.-][:][0-9.-][0-9.-][:][0-9.-][0-9.-]/"; //08:00:00
        $time_regex2 = "/[0-9.-][0-9.-][:][0-9.-][0-9.-]/";                 //08:00

        //If $time not converted to float value
        if(preg_match($time_regex, $time, $match) || preg_match($time_regex2, $time, $match)){
            return $time;
        }

        //If $time is converted to float value
        if($time <= 1 && $time >= 0){
            $hours = floor($time * 24); 
            $minute_fraction = ($time * 24) - $hours;
            $minutes = $minute_fraction * 60; 
            $time = $hours.":".$minutes;
            return $time;
        }

        return 0;
    }

    public function model(array $row)
    {
        return new Schedule([
            'user_id'           => $this->user_id,
            'child_id'          => $this->child_id,
            'day'               => $row['Nombor Hari'], 
            'start_time'        => self::toTime($row['Mula Pada']),
            'end_time'          => self::toTime($row['Akhir Pada']),
            'name'              => $row['Nama Kelas'],
            'class_url'         => $row['Link Kelas']
        ]);
    }
}
