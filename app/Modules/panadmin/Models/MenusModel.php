<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class MenusModel extends Model{


    public static $tableName = 'menus';

    public static $fields = [
        [
            "field_name" => "text",
            "field_type" => "TEXT"

        ],[
            "field_name" => "title",
            "field_type" => "VARCHAR (255)"

        ]
    ];

    // Rules
    
    public static function rules()
    {
        return [
            'title_'.LANGUAGE_CODE => ['required'],
            'menu_type' => ['required']
        ];
    }

    public static function naming()
    {
        return [
            'title_'.LANGUAGE_CODE => "Basliq (".LANGUAGE_CODE.")",
            'menu_type' => 'Menu tipi',

        ];
    }
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
                $message = 'Menu tapılmadı';
                return $message;
            }else{
                return $category_name;
            }
        }
    }

}

?>