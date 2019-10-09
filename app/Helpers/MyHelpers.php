<?php
namespace Helpers;
class MyHelpers
{
    public static function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, self::search($subarray, $key, $value));
            }
        }

        return $results;
    }

    public static function convertToHoursMins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public static function partString($text,$limit=50){
        if(mb_strlen($text,'UTF-8')>$limit)$text = mb_substr($text, 0,$limit,'UTF-8').'...';
        return $text;
    }

    public static function minmax($str,$min,$max){
        if(strlen($str)>$max) return true; if(strlen($str)<$min) return true; else return false;
    }

    public static function replaceSpace($string)
    {
        $string = preg_replace("/\s+/", "", $string);
        $string = trim($string);
        return $string;
    }

    public static function array_group_by($arr, $key)
    {
        if (!is_array($arr)) {
            trigger_error('array_group_by(): The first argument should be an array', E_USER_ERROR);
        }
        if (!is_string($key) && !is_int($key) && !is_float($key)) {
            trigger_error('array_group_by(): The key should be a string or an integer', E_USER_ERROR);
        }
        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }
        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }
        return $grouped;
    }

    public static function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            if($invert == FALSE) {
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            }
            else {
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
            }
        }
        elseif($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    public static function is_decimal( $val )
    {
        return is_numeric( $val ) || floor( $val ) != $val;
    }

    public static function getFilteredParam($param){
        $filterList = array(
            'cardType'    => "/^[v|m]$/",
            'amount'      => '/^[0-9.]*$/',
            'item'        => '/^[a-zA-Z0-9]*$/',
            'lang'        => '/^(lv|en|ru)$/',
            'payment_key' => '/^[a-zA-Z0-9\-]*$/'
        );

        $filter = $filterList[$param];

        if (is_null($filter) || !is_string($filter)) {
            echo "Filter for this parameter not found: ".$param;
            exit();
        }

        $new_param = filter_input(INPUT_POST, $param, FILTER_SANITIZE_STRING);



        if (!preg_match($filter, $new_param)){
            echo "Wrong parameter characters: ".$new_param;
            exit();
        }

        return $new_param;
    }

    public static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
