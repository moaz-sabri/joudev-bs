<?php

namespace App\Utilities\helper;

trait TimeDate
{

    #region [Redirect]
    public static function DATE_REFORMAT($date)
    {
        return date_format(date_create($date), DATE_FORMAT);
    }
    #endregion

    #region [Redirect]
    public static function CURRENT_DATE()
    {
        return date(DATE_FORMAT);
    }
    #endregion

    #region
    public static function OVER_DATED(string $time)
    {
        // Three days to limil
        $day = 60 * 60 * 72;
        return strtotime($time) + $day <  time() ? true : false;
    }
    #endregion

    #region
    private function DECLARE_TOW_DATES(string $time)
    {

        // Declare two dates
        $start_date = strtotime(self::DATE_REFORMAT($time));
        $end_date = strtotime(self::CURRENT_DATE());

        // Get the difference and divide into
        // total no. seconds / 60
        return ($end_date - $start_date) / 60;
    }
    #endregion

    #regio staticn
    public static function TIME_LAST_ACTIVE(string $time)
    {
        // Creates DateTime objects
        $datetime1 = date_create(self::DATE_REFORMAT($time));
        $datetime2 = date_create(self::CURRENT_DATE());

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);

        // Printing result in years & months format
        $date = 'now';
        if ($interval->i > 1) :
            $date = $interval->i . ' Mins';
        endif;

        if ($interval->h > 1) :
            $date .= ':' . $interval->h . ' Hours';
        endif;

        if ($interval->d > 1) :
            $date .= ' ' . $interval->d . ' Days';
        endif;

        if ($interval->m > 1) :
            $date .= '/' . $interval->m . ' Months';
        endif;

        if ($interval->y > 1) :
            $date .= '/' . $interval->y . ' Years';
        endif;

        return $date;
    }
    #endregion

}
