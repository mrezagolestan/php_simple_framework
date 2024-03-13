<?php

namespace App\Repositories;

use Carbon\Carbon;

class DayRepository extends Repository
{
    public function getAll(): array|false
    {
        $dates = [];

        $today = Carbon::now();
        for ($i = 1; $i <= 7; $i++) {
            $dates[] = $this->calculateDayArray($today);
            $today->addDay();
        }
        return $dates;
    }

    public static function getDayNameByIndex($day){
        $dayOfWeek = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        return $dayOfWeek[$day];
    }

    private function calculateDayArray($today)
    {
        return ['date' => $today->format("Y-m-d"), 'day' => $today->dayOfWeek];
    }
}