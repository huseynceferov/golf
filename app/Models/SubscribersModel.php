<?php
namespace Models;

use Core\Model;

class SubscribersModel extends Model
{
    public static $tableName = 'subscribers';

    public function __construct(){
        parent::__construct();
    }
}