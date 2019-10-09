<?php
namespace Models;
use Core\Model;
use Helpers\Cookie;
use Helpers\Session;
use PDO;
use Helpers\Database;

class CurrenciesModel extends Model{

    public static $tableName = 'currencies';

    public function __construct(){
        parent::__construct();
    }


    public static function getCurrencies()
    {
        $currencies  = Database::get()->select('SELECT `name`,`fullname`,`rate` FROM '.self::$tableName.' WHERE `status` = 1 ORDER BY `position` DESC');
        return $currencies;
    }

    public static function getDefaultCurrency()
    {
        $currency = Database::get()->selectOne('SELECT `name`,`fullname`,`rate` FROM '.self::$tableName .' WHERE `default` = 1');
        return $currency;
    }

    public static function defaultCurrency()
    {
        if(array_key_exists(SESSION_PREFIX.'currency', $_SESSION)) {
            $currency = Session::get('currency');
        } else {
            $currency = Database::get()->selectOne('SELECT `name`,`fullname`,`rate` FROM '.self::$tableName .' WHERE `default` = 1');
        }

        return $currency;
    }

}

?>