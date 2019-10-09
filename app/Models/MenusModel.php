<?php

namespace Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class MenusModel extends Model{


    public static $tableName = 'menus';
    

    public function __construct(){
        parent::__construct();
    }

    public static function getMenus()
    {
        $data = [0 => " - "];
        $defaultLang = LanguagesModel::getDefaultLanguage();
        $rows = Database::get()->select('SELECT `id`,`title_'.$defaultLang.'` FROM '.self::$tableName);
        foreach($rows as $row){
            $data[$row["id"]] = $row["title_".$defaultLang];
        }
        return $data;
    }


    public static function getMenuName($id){
        $defaultLang = LanguagesModel::getDefaultLanguage();
        if(!isset($id) || intval($id)==0){
            $message = 'Menu seçilməyib';
            return $message;
        }else{
            $row = Database::get()->selectOne('SELECT `title_'.$defaultLang.'` FROM '.self::$tableName.' WHERE id=:id',[':id' => $id]);
            $category_name = $row['title_'.$defaultLang];
            if(!$row){
                $message = 'Menu not found';
                return $message;
            }else{
                return $category_name;
            }
        }
    }

    public static function menuControllerName($controller_name)
    {
        $defaultLang = LanguagesModel::defaultLanguage();
        if(!isset($controller_name) || empty($controller_name)){
            $message = 'Menu seçilməyib';
            return $message;
        }else{
            $row = Database::get()->selectOne('SELECT `title_'.$defaultLang.'` FROM '.self::$tableName.' WHERE url=:url',[':url' => $controller_name]);
            $category_name = $row['title_'.$defaultLang];
            if(!$row){
                $message = 'Menu not found';
                return $message;
            }else{
                return $category_name;
            }
        }
    }

}

?>