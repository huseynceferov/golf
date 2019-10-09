<?php
namespace Models;
use Core\Model;
use Helpers\Session;
use Helpers\Database;

class EventModel extends Model{

    public static $tableName = 'events';

    public function __construct(){
        parent::__construct();
    }

}