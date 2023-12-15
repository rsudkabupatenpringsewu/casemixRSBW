<?php
// app/Services/CacheService.php

namespace App\Services;
// DayListService.php

class DayListService
{
    public static function getDayList()
    {
        return array(
            'Sunday' => 'MINGGU',
            'Monday' => 'SENIN',
            'Tuesday' => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday' => 'KAMIS',
            'Friday' => 'JUMAT',
            'Saturday' => 'SABTU'
        );
    }
}
