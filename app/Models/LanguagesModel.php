<?php
namespace Models;
use Helpers\Cookie;
use Core\Model;
use PDO;
use Helpers\Database;

class LanguagesModel extends Model{

    public static $tableName = 'languages';

    public function __construct(){
        parent::__construct();
    }


    public static function getLanguages()
    {
        $languages  = Database::get()->select('SELECT * FROM '.self::$tableName.' WHERE `status` = 1 ORDER BY `default` DESC, `position` DESC');
        return $languages;
    }

    public static function getDefaultLanguage()
    {
        //$language = Database::get()->selectOne('SELECT `name` FROM '.self::$tableName);
        $language  = Database::get()->selectOne('SELECT `name` FROM '.self::$tableName.' WHERE `default` = 1');

        return $language["name"];
    }

    public static function defaultLanguage()
    {
        if(Cookie::has('lang')) {
            $language = Cookie::get('lang');
        } else {
            $get_language = Database::get()->selectOne('SELECT `name` FROM '.self::$tableName.' WHERE `default` = 1');
            $language = $get_language['name'];
        }
        return $language;
    }

    public static function getLanguageName($code)
    {
        $get_language = Database::get()->selectOne('SELECT `fullname` FROM '.self::$tableName.' WHERE `name` = :name', [':name' => $code]);
        if(is_array($get_language)) {
            return $get_language['fullname'];
        } else {
            return 'Not found';
        }
    }

}

?>