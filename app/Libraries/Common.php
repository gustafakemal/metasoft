<?php

namespace App\Libraries;
use CodeIgniter\I18n\Time;

class Common
{
    public function dateFormat($date)
    {
        if($date == null or $date == '') {
            return null;
        }

        $time = Time::parse($date);

        return $this->StrPad($time->day) . '/' .
            $this->StrPad($time->month) . '/' .
            $time->year . ' ' .
            $this->strPad($time->hour) . ':' . $this->strPad($time->minute);
    }

    private function strPad($str)
    {
        return str_pad($str, 2, "0", STR_PAD_LEFT);
    }

    public function decimalToInt($number)
    {
        return (int)$number;
    }
}