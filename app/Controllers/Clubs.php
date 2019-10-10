<?php
namespace Controllers;

use Core\View;
use Helpers\Database;
use Helpers\Date;
use Helpers\Pagination;
use Helpers\Security;
use Helpers\Url;
use Models\ClubsModel;

class Clubs extends MyController
{
    public  $table;

    public function __construct()
    {
        parent::__construct();
        $this->language->load('app');
        $this->table = ClubsModel::$tableName;
    }

    public function meta($keyword, $author, $description)
    {
        echo '<meta name="author" content="Golf in Azerbaijan">
        <meta name="keywords" content="'.$keyword.'">
        <meta name="description" content="'.$description.'">
        <meta name="copyright" content="'.$author.'" />';
    }

    public function lists(){
        $getMenu = Database::get()->selectOne("SELECT * FROM `menus` WHERE `slug`='qolf-klublari'");
        $defaultLanguage = $this->defaultLang;
        $countRows = Database::get()->count("SELECT count(id) FROM {$this->table} WHERE `status` = 1");
        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);

        $sql = Database::get()->select("SELECT * FROM `{$this->table}` WHERE `status`=1 ORDER BY `create_time` DESC ".$limitSql);

        $data['page'] = 'other';
        $data['pagination'] = $pagination;
        $data['lists'] = $sql;
        $data['title'] = $getMenu['title_'.$defaultLanguage];
        $data['keywords'] = $getMenu['title_'.$defaultLanguage];
        $data['description'] = $getMenu['title_'.$defaultLanguage];
        View::render('clubs/list',$data);
    }


    public function view($slug){
        $defaultLanguage = $this->defaultLang;
        $slug = Security::safe($slug);
        $get = Database::get()->selectOne("SELECT * FROM `{$this->table}` WHERE slug=:slug AND status=1",[":slug"=>$slug]);

        if($get==NULL){
            Url::redirect('404.html');
            exit;
        }

        $data['events'] = Database::get()->select("SELECT `title_{$defaultLanguage}`,`slug`,`create_time` FROM `events` WHERE `status`=1 ORDER BY `create_time` DESC");
        $data['news'] = Database::get()->select("SELECT `title_{$defaultLanguage}`,`slug`,`create_time` FROM `news` WHERE `status`=1 ORDER BY `create_time` DESC");

        if(empty($get['tags_'.$this->defaultLang])){
            $keywords = $get['title_'.$this->defaultLang];
        }else{
            $keywords = $get['tags_'.$this->defaultLang];
        }

        if(empty($get['meta_description_'.$this->defaultLang])){
            $description = $get['title_'.$this->defaultLang];
        }else{
            $description = $get['meta_description_'.$this->defaultLang];
        }
        $data['page'] = 'other';
        $data['result'] = $get;
        $data['title'] = $get['title_'.$this->defaultLang];
        $data['keywords'] = $keywords;
        $data['description'] = $description;
        View::render('clubs/view',$data);
    }

}
