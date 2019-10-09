<?php
namespace Models;
use Core\Model;
use Helpers\Session;
use Helpers\Database;

class ClubsModel extends Model{

    public static $tableName = 'clubs';

    public function __construct(){
        parent::__construct();
    }

}