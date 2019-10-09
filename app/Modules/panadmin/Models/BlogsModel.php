<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Models\LanguagesModel;

class BlogsModel extends Model{


    public static $tableName = 'blogs';

    public static $fields = [
        [
            "field_name" => "title",
            "field_type" => "VARCHAR (255)"

        ],[
            "field_name" => "short_text",
            "field_type" => "VARCHAR (255)"

        ],[
            "field_name" => "text",
            "field_type" => "LONGTEXT"

        ]
    ];

    // Rules

    public static function rules()
    {
        return [
            'title_'.LANGUAGE_CODE => ['required'],
            'short_text_'.LANGUAGE_CODE => ['required'],
            'text_'.LANGUAGE_CODE => ['required']
        ];
    }
    
    public static function naming()
    {
        return [
            'title_'.LANGUAGE_CODE => "Basliq (".LANGUAGE_CODE.")",
            'short_text_'.LANGUAGE_CODE => "Qısa mətn (".LANGUAGE_CODE.")",
            'text_'.LANGUAGE_CODE => "Mətn (".LANGUAGE_CODE.")",
            'image' => 'Şəkil',

        ];
    }

    public function __construct(){
        parent::__construct();
    }
    
}

?>