<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class CategoriesModel extends Model{

    public function __construct(){
        parent::__construct();
    }
    public static $tableName = 'categories';

    public static $fields = [
        [
            "field_name" => "text",
            "field_type" => "TEXT"

        ],[
            "field_name" => "title",
            "field_type" => "VARCHAR (255)"

        ]

    ];

    public static function rules()
    {
        return [
            'title_'.LANGUAGE_CODE => ['required',],
        ];
    }

    public static function naming()
    {
        return [
            'title_'.LANGUAGE_CODE => "Basliq (".LANGUAGE_CODE.")",
        ];
    }


    public static function getCategoryName($id){
        $defaultLang = LanguagesModel::getDefaultLanguage();
        if(!isset($id) || intval($id)==0){
            $message = 'Kateqoriya seçilməyib';
            return $message;
        }else{
            $row = Database::get()->selectOne('SELECT `title_'.$defaultLang.'` FROM '.self::$tableName.' WHERE id=:id',[':id' => $id]);
            $category_name = $row['title_'.$defaultLang];
            if(!$row){
                $message = 'Kateqoriya tapılmadı';
                return $message;
            }else{
                return $category_name;
            }
        }
    }
    

}

?>