<?php
namespace Models;
use Core\Model;
use Helpers\Session;
use Helpers\Database;

class PostModel extends Model{

    public static $tableName = 'blogs';

    public function __construct(){
        parent::__construct();
    }


    public static function getPopnews($date_between,$limit='21')
    {
        $today_time = time();
        $pop_news = Database::get()->select('SELECT `id`,`title_az`,`thumb`,`news_time`,`create_time`,`slug` FROM '.self::$tableName.' WHERE `status` = 1 AND `create_time`<:start_time AND `create_time`>:end_time ORDER BY `create_time` DESC LIMIT '.$limit.' ',["start_time"=>$today_time,"end_time"=>$date_between]);
        return $pop_news;
    }

}