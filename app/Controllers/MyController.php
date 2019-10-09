<?php
/**
 * Created by PhpStorm.
 * User: javidkarimov
 * Date: 29.11.16
 * Time: 9:39
 */

namespace Controllers;


use Core\Controller;
use Helpers\Database;
use Helpers\Recursive;
use Helpers\Security;
use Helpers\Session;
use Models\LanguagesModel;

class MyController extends Controller
{

    public $defaultLang;

    public function __construct()
    {
        parent::__construct();
        $this->language->load('app');
        $this->defaultLang = LanguagesModel::defaultLanguage();
    }

    public function checkAuth(){
        $getSessionId = intval(Session::get('user_session_id'));
        $getSessionPass = Session::get('user_session_pass');
        $getAuthInfo = Database::get()->selectOne("SELECT * FROM `users` WHERE id=:id",["id" => $getSessionId]);
        if($getSessionPass != Security::session_password($getAuthInfo["pass"])){
            return false;
        } else {
            return $getAuthInfo;
        }
    }

    public static function getMenu()
    {
        $menu = Recursive::menu(Database::get(), 'menus', 0, LanguagesModel::defaultLanguage(), 'up');
        return $menu;
    }

    public static function getAllMenu()
    {
        $menu = Database::get()->select("SELECT * FROM `menus` WHERE `status`=1 AND `parent_id`=0");
        return $menu;
    }

    public static function getCategories(){
        $def_lng = LanguagesModel::defaultLanguage();
        $get = Database::get()->select("SELECT `id`,`title_{$def_lng}`,`slug` FROM `categories` WHERE `status`=1 ORDER BY `position` DESC");
        return $get;
    }

    public static function getCategoriesFirst(){
        $def_lng = LanguagesModel::defaultLanguage();
        $get = Database::get()->select("SELECT `id`,`title_{$def_lng}`,`slug` FROM `categories` WHERE `status`=1 ORDER BY `position` DESC LIMIT 0,6");
        return $get;
    }

    public static function getCategoriesSecond(){
        $def_lng = LanguagesModel::defaultLanguage();
        $get = Database::get()->select("SELECT `id`,`title_{$def_lng}`,`slug` FROM `categories` WHERE `status`=1 ORDER BY `position` DESC LIMIT 6,6");
        return $get;
    }

    public function getMenu2()
    {
        $menu = Recursive::menu(Database::get(), 'menus', 0, LanguagesModel::defaultLanguage(), 'up', $static_url = 'page', $mainUlClass='dropdown-menu', $mainLiClass = 'dropdown custom-drop', $otherLiClass='dropdown-submenu', $main_a_class = '');
        return $menu;
    }

    public function getDownMenu()
    {
        $menu = Database::get()->select("SELECT id, title_{$this->defaultLang}, `menu_type`, `url` FROM `menus` WHERE `status` = 1 AND `down` = 1 ORDER BY `position` DESC ");
        return $menu;
    }

    public static function getContacts()
    {
        $contacts = Database::get()->selectOne("SELECT * FROM `contacts` ORDER  BY `id` DESC LIMIT 1");
        return $contacts;
    }

    public static function getAbout($lang)
    {

        $about_sql = Database::get()->selectOne("SELECT text_{$lang} FROM `menus` WHERE `url` = 'aboutus' ORDER  BY `id` DESC LIMIT 1");
        if(is_array($about_sql) && array_key_exists('text_'.$lang, $about_sql)) {
            return $about_sql['text_'.$lang];
        } else {
            return 'Not written';
        }
    }

    public static function increaseView($tableName, $id, $increase = 1)
    {
        Database::get()->raw("UPDATE {$tableName} SET `view_count` = `view_count` + {$increase} WHERE `id` = '".$id."'");
    }

}