<?php
namespace Models;
use Core\Model;

class GalleryModel extends Model{

    public static $tableName = 'photos';

    public function __construct(){
        parent::__construct();
    }
}

?>