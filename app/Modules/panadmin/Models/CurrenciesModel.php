<?php

namespace Modules\panadmin\Models;

use Core\Model;

class CurrenciesModel extends Model{


    public static $tableName = 'currencies';
    

    public static function rules()
    {
        return [
            'name' => ['required', 'alpha'],
            'fullname' => ['required'],
            'rate' => ['required'],
        ];
    }

    public static function naming()
    {
        return [
            'fullname' => "Kursun adı",
            'name' => "Kursun kodu",
            'rate' => "Kursun dəyəri",
        ];
    }
    public function __construct(){
        parent::__construct();
    }



}

?>