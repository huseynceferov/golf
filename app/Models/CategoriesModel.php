<?php
namespace Models;
use Core\Model;
use Helpers\Pagination;
use PDO;
use Helpers\Database;

class CategoriesModel extends Model{

    public static  $tableName = 'categories';
    public static  $statusActive = 1;
    public static  $statusPassive = 0;

    public function __construct(){
        parent::__construct();
    }

    public static function getCategories()
    {
        $data = [0 => " - "];
        $defaultLang = LanguagesModel::getDefaultLanguage();
        $rows = Database::get()->select('SELECT `id`,`title_'.$defaultLang.'` FROM '.self::$tableName);
        foreach($rows as $row){
            $data[$row["id"]] = $row["title_".$defaultLang];
        }
        return $data;
    }

    public static function getSubCategories()
    {
        $data = [0 => " - "];
        $defaultLang = LanguagesModel::getDefaultLanguage();
        $rows = Database::get()->select('SELECT `id`,`title_'.$defaultLang.'` FROM '.self::$tableName);
        foreach($rows as $row){
            $data[$row["id"]] = $row["title_".$defaultLang];
        }
        return $data;
    }

    public static function getCategoryName($id){
        $defaultLang = LanguagesModel::defaultLanguage();
        if(!isset($id) || intval($id)==0){
            $message = 'Kateqoriya seçilməyib';
            return $message;
        }else{
            $row = Database::get()->selectOne('SELECT `title_'.$defaultLang.'` FROM '.self::$tableName.' WHERE id=:id',[':id' => $id]);
            $category_name = $row['title_'.$defaultLang];
            if(!$row){
                $message = 'Kateqoriya tapılmadı';
                return $message;
            }else{
                return $category_name;
            }
        }
    }

    public static function getCategoryId($name){
        $get_Cat = Database::get()->selectOne("SELECT `id` FROM ".self::$tableName." WHERE `title_az`=:name ",[":name"=>$name]);
        return $get_Cat['id'];
    }

    public static function checkCat($name){
        $check_cat = Database::get()->count("SELECT COUNT(id) FROM ".self::$tableName." WHERE `title_az`=:name",[":name"=>$name]);
        return $check_cat;
    }

}

?>