<?php
namespace Models;
use Core\Model;
use Helpers\Session;
use Helpers\Database;

class ToursModel extends Model{

    public static $tableName = 'tours';

    public function __construct(){
        parent::__construct();
    }

}