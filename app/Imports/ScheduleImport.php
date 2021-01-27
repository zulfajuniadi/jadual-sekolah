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
        $check = preg_match('/(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?/', $time);
        $this->test = $check;

        if($check == 0){
            if($time >=0 && $time < 1.0 && is_int($time)){
                $time = $time * 86400;
                date('H:i', $time);
                return $time;
            }
            return 0;
        }
        return $time;
    }

    public function checkDay($day){
        if(!(is_int($day)) || ($day > 7) || (empty($day))){
            return 0;
        }
        return $day;
    }

    public function model(array $row)
    {
        return new Schedule([
            'user_id'           => $this->user_id,
            'child_id'          => $this->child_id,
            'day'               => self::checkday($row['Nombor Hari']), 
            'start_time'        => self::toTime($row['Mula Pada']),
            'end_time'          => self::toTime($row['Akhir Pada']),
            'name'              => $row['Nama Kelas'] ? $row['Nama Kelas'] : '-',
            'class_url'         => $row['Link Kelas'] ? $row['Link Kelas'] : '-'
        ]);
    }
}
