<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Modules\HR\Entities\Absence;
use Modules\HR\Entities\FingerprintAttendance;
use Modules\HR\Entities\Holiday;
use Modules\HR\Entities\Vacation;
use Modules\HR\Entities\WorkingDay;

function getAbsentUsers($date, $user_id)
{
    $data_value = FingerprintAttendance::where('date', $date)->where('user_id', $user_id)->first();
    $userAbsent = Absence::where('user_id', $user_id)->where('date', $date)->first();
        

    if(!$data_value && $date < date('Y-m-d')){
        if(!$userAbsent && !weekEnds($date))
        {
            $result = new Absence();
            $result->date = $date;
            $result->user_id = $user_id;
            $result->timestamps = false;
            $result->save();
        }// Recorded user in db
        return 1;
    } // not having fingerprint
    else {
        return 0;
    }
}

function getHolidays($date)
{
    // return weekEnds($date) ? 0 : Holiday::where('start_date','<=' , $date)->where('end_date', '>=', $date)->get();
    $result = Holiday::where('start_date','<=' , $date)->where('end_date', '>=', $date)->first();
    return ($result) ? 1 : 0; 
}

function getVacations($date, $user_id)
{
    $result = Vacation::where('user_id', $user_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();
    return ($result) ? 1 : 0; 

    // weekEnds($date) ?? $result;
    // return $result;
}

function weekEnds($day)
{
    $dayFormat = date('D', strtotime($day));
    return WorkingDay::where('day', $dayFormat)->where('working_status', 0)->first();
}

function getDateRange($date)
{
    $currentMonth = date("Y-m-d", strtotime($date . '-25')) ;
    $carbonDate =  Carbon::createFromFormat('Y-m-d', $currentMonth)->subMonth()->format('Y-m');
    $previousMonth = date("Y-m-d", strtotime($carbonDate . '-25')) ;

    $period = CarbonPeriod::create($previousMonth, $currentMonth);
    dd($period);
    // Iterate over the period
    foreach ($period as $date) {
        echo $date->format('Y-m-d');
    }
    
    // Convert the period to an array of dates
    $dates = $period->toArray();
}

// function getDatesFromRange($start, $end, $format = 'Y-m-d') {
//     $array = array();
//     $interval = new DateInterval('P1D');

//     $realEnd = new DateTime($end);
//     $realEnd->add($interval);

//     $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

//     foreach($period as $date) {
//         $array[] = $date->format($format);
//     }

//     return $array;
// }


