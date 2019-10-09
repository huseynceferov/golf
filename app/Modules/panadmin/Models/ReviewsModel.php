<?php

namespace Modules\panadmin\Models;

use Core\Model;

class ReviewsModel extends Model{

    public static $tableName = 'reviews';

    public static $fields = [
        [
            "field_name" => "text",
            "field_type" => "TEXT"

        ]
    ];

    // Rules

    public static function rules()
    {
        return [
            'text' => ['required']
        ];
    }

    public static function naming()
    {
        return [
            'text' => "Mətn ",

        ];
    }


    public function __construct(){
        parent::__construct();
    }

}

?>