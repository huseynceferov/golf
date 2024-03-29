<?php
/**
 * Date Helper
 *
 * @author David Carr - dave@daveismyname.com
 * @version 1.0
 * @date May 18 2015
 * @date updated Sept 19, 2015
 */

namespace Helpers;
use Core\Language;

/**
 * collection of methods for working with dates.
 */
class Date
{
    /**
     * get the difference between 2 dates
     *
     * @param  date $from start date
     * @param  date $to   end date
     * @param  string $type the type of difference to return
     * @return string or array, if type is set then a string is returned otherwise an array is returned
     */
    public static function difference($from, $to, $type = null)
    {
        $d1 = new \DateTime($from);
        $d2 = new \DateTime($to);
        $diff = $d2->diff($d1);
        if ($type == null) {
            //return array
            return $diff;
        } else {
            return $diff->$type;
        }
    }

    /**
     * Business Days
     *
     * Get number of working days between 2 dates
     *
     * Taken from http://mugurel.sumanariu.ro/php-2/php-how-to-calculate-number-of-work-days-between-2-dates/
     *
     * @param  date     $startDate date in the format of Y-m-d
     * @param  date     $endDate date in the format of Y-m-d
     * @param  booleen  $weekendDays returns the number of weekends
     * @return integer  returns the total number of days
     */
    public static function businessDays($startDate, $endDate, $weekendDays = false)
    {
        $begin = strtotime($startDate);
        $end = strtotime($endDate);

        if ($begin > $end) {
            //startDate is in the future
            return 0;
        } else {
            $numDays = 0;
            $weekends = 0;

            while ($begin <= $end) {
                $numDays++; // no of days in the given interval
                $whatDay = date('N', $begin);

                if ($whatDay > 5) { // 6 and 7 are weekend days
                    $weekends++;
                }
                $begin+=86400; // +1 day
            };

            if ($weekendDays == true) {
                return $weekends;
            }

            $working_days = $numDays - $weekends;
            return $working_days;
        }
    }

    /**
    * get an array of dates between 2 dates (not including weekends)
    *
    * @param  date    $startDate start date
    * @param  date    $endDate end date
    * @param  integer $nonWork day of week(int) where weekend begins - 5 = fri -> sun, 6 = sat -> sun, 7 = sunday
    * @return array   list of dates between $startDate and $endDate
    */
    public static function businessDates($startDate, $endDate, $nonWork = 6)
    {
        $begin    = new \DateTime($startDate);
        $end      = new \DateTime($endDate);
        $holiday  = array();
        $interval = new \DateInterval('P1D');
        $dateRange= new \DatePeriod($begin, $interval, $end);
        foreach ($dateRange as $date) {
            if ($date->format("N") < $nonWork and !in_array($date->format("Y-m-d"), $holiday)) {
                $dates[] = $date->format("Y-m-d");
            }
        }
        return $dates;
    }
    
    /**
     * Takes a month/year as input and returns the number of days
     * for the given month/year. Takes leap years into consideration.
     * @param int $month
     * @param int $year
     * @return int
     */
    public static function daysInMonth($month = 0, $year = '') {
        if ($month < 1 OR $month > 12) {
            return 0;
        } elseif (!is_numeric($year) OR strlen($year) !== 4) {
            $year = date('Y');
        }
        if (defined('CAL_GREGORIAN')) {
            return cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        if ($year >= 1970) {
            return (int) date('t', mktime(12, 0, 0, $month, 1, $year));
        }
        if ($month == 2) {
            if ($year % 400 === 0 OR ( $year % 4 === 0 && $year % 100 !== 0)) {
                return 29;
            }
        }
        $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        return $days_in_month[$month - 1];
    }


    public static function tarixLang($time,$date_view='d F Y , H:i',$lang='az'){
        date_default_timezone_set('Asia/Baku');
        $cixis = date($date_view, $time-3600);
        $aylarIng = array(
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        );
        $gunlerIng = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

        if($lang=='en'){
            $aylar = array(
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            );
            $gunler =  array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        }elseif($lang=='ru'){
            $aylar = array(
                "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
                "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
            );
            $gunler = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье");
        }else{
            $aylar = array(
                "Yanvar", "Fevral", "Mart", "Aprel", "May", "İyun",
                "İyul", "Avqust", "Sentyabr", "Oktyabr", "Noyabr", "Dekabr"
            );
            $gunler = array("Bazar ertəsi", "Çərşənbə axşamı", "Çərşənbə", "Cümə axşamı", "Cümə", "Şənbə", "Bazar");
        }

        $cixis = str_replace($aylarIng, $aylar, $cixis);
        $cixis = str_replace($gunlerIng, $gunler, $cixis);
        return $cixis;
    }
}
