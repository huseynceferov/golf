<?php

namespace Models;

use Core\Language;
use Core\Model;


class ContactModel extends Model{

    // Rules
    public static $rules = [
        'email' => ['required', 'min_length(10)', 'max_length(50)', 'email'],
        'message' => ['required'],
        'fullname' => ['required', 'min_length(3)'],
        'subject' => ['required', 'min_length(3)', 'max_length(50)']
    ];

    public static $rule_sub = [
        'email' => ['required', 'min_length(2)', 'max_length(50)', 'email'],
    ];

    public static function naming()
    {
       return include SMVC.'app/language/'.LanguagesModel::defaultLanguage().'/naming.php';
    }

    public function __construct()
    {
        parent::__construct();
    }


}

?>