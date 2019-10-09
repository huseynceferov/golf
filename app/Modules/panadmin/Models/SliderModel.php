<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;

class SliderModel extends Model{

    public function __construct(){
        parent::__construct();
    }
    public static $tableName = 'slider';

    public static $fields = [
        [
            "field_name" => "title",
            "field_type" => "VARCHAR (255)"

        ],[
            "field_name" => "subtitle",
            "field_type" => "VARCHAR (255)"

        ]

    ];
    

    public static function rules()
    {
        return [
            'title_'.LANGUAGE_CODE => ['required', 'max_length(100)'],
            'subtitle_'.LANGUAGE_CODE => ['max_length(500)'],
        ];
    }

    public static function naming()
    {
        return [
            'title_'.LANGUAGE_CODE => "Başlıq (".LANGUAGE_CODE.")",
            'subtitle_'.LANGUAGE_CODE => "Qısa mətn (".LANGUAGE_CODE.")",
            'image' => "Şəkil",
        ];
    }

    public static function getPhotos($table,$row_id)
    {
        $photos = [];
        $photos = Database::get()->select("SELECT * FROM `photos` WHERE `table_name`=:table and `row_id`=:row_id ORDER BY `position` DESC",
            [
                ":table" => $table,
                ":row_id" => $row_id
            ]);
        return $photos ;
    }


}

?>