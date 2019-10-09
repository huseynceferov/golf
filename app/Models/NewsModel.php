<?php
namespace Models;
use Core\Model;
use Helpers\Session;
use Helpers\Database;

class NewsModel extends Model{

    public static $tableName = 'news';

    public function __construct(){
        parent::__construct();
    }

}