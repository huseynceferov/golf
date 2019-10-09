<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Models\LanguagesModel;

class TipsModel extends Model{


    public static $tableName = 'tips';

    public static $fields = [
        [
            "field_name" => "title",
            "field_type" => "VARCHAR (255)"

        ]
    ];

    // Rules

    public static function rules()
    {
        return [
            'title_'.LANGUAGE_CODE => ['required'],
        ];
    }

    public static function naming()
    {
        return [
            'title_'.LANGUAGE_CODE => "Basliq (".LANGUAGE_CODE.")",
            'image' => 'Şəkil',

        ];
    }

    public function __construct(){
        parent::__construct();
    }

}

?>