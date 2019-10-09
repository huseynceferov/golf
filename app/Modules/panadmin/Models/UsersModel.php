<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class UsersModel extends Model
{


    public static $tableName = 'users';

    public static $fields = [
        [
            "field_name" => "name",
            "field_type" => "VARCHAR (255)"

        ],[
            "field_name" => "email",
            "field_type" => "VARCHAR (255)"

        ]/*,[
            "field_name" => "text",
            "field_type" => "LONGTEXT"

        ]*/
    ];

    public static function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required'],
            /*'short_text_'.LANGUAGE_CODE => ['required'],
            'text_'.LANGUAGE_CODE => ['required'],*/
        ];
    }

    public static function naming()
    {
        return [
            'name' => "Adı",
            'email' => "Email",
            /*'short_text_'.LANGUAGE_CODE => "Qısa mətn (".LANGUAGE_CODE.")",
            'text_'.LANGUAGE_CODE => "Mətn (".LANGUAGE_CODE.")",*/

        ];
    }

    public function __construct(){
        parent::__construct();
    }

    public static function getUser($id){
        $get_user = Database::get()->selectOne("SELECT * FROM ".self::$tableName." WHERE `id`=:id",[":id"=>$id]);
        return $get_user;
    }

}