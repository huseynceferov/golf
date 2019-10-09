<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class AlbumsModel extends Model{

    public function __construct(){
        parent::__construct();
    }
    public static $tableName = 'albums';

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
            'image' => 'Şəkil',
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