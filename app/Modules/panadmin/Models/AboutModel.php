<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class AboutModel extends Model{


    public static $tableName = 'about';

    public static $fields = [
        [
            "field_name" => "title",
            "field_type" => "VARCHAR (255)"

        ],[
            "field_name" => "text",
            "field_type" => "TEXT"

        ]
    ];

    // Rules

    public static function rules()
    {
        return [
            'title_'.LANGUAGE_CODE => ['required'],
            'text_'.LANGUAGE_CODE => ['required'],
        ];
    }

    public static function naming()
    {
        return [
            'title_'.LANGUAGE_CODE => "Basliq (".LANGUAGE_CODE.")",
            'text_'.LANGUAGE_CODE => "Mətn (".LANGUAGE_CODE.")",

        ];
    }

    public function __construct(){
        parent::__construct();
    }

    public static function getRestaurant($id){
        $get_restaurant = Database::get()->selectOne("SELECT * FROM ".self::$tableName." WHERE `id`=:id",[":id"=>$id]);
        return $get_restaurant;
    }


    public static function getRestaurants()
    {
        $data = [0 => " - "];
        $defaultLang = LanguagesModel::getDefaultLanguage();
        $rows = Database::get()->select('SELECT `id`,`title_'.$defaultLang.'` FROM '.self::$tableName);
        foreach($rows as $row){
            $data[$row["id"]] = $row["title_".$defaultLang];
        }
        return $data;
    }

}

?>