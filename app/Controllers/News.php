<?php
namespace Controllers;

use Core\View;
use Helpers\Database;
use Helpers\Pagination;
use Helpers\Security;
use Helpers\Url;
use Models\NewsModel;

class News extends MyController
{
    public  $blog_table;

    public function __construct()
    {
        parent::__construct();
        $this->language->load('app');
        $this->blog_table = NewsModel::$tableName;
    }

    public function meta($keyword, $author, $description)
    {
        echo '<meta name="author" content="Golf in Azerbaijan">
        <meta name="keywords" content="'.$keyword.'">
        <meta name="description" content="'.$description.'">
        <meta name="copyright" content="'.$author.'" />';
    }

    public function lists(){
        $getMenu = Database::get()->selectOne("SELECT * FROM `menus` WHERE `slug`='news'");
        $defaultLanguage = $this->defaultLang;
        $countRows = Database::get()->count("SELECT count(id) FROM {$this->blog_table} WHERE `status` = 1");
        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);

        $blogs = Database::get()->select("SELECT * FROM `{$this->blog_table}` WHERE `status`=1 ORDER BY `create_time` DESC ".$limitSql);

        $data['pagination'] = $pagination;
        $data['lists'] = $blogs;
        $data['page'] = 'other';
        $data['title'] = $getMenu['title_'.$defaultLanguage];
        $data['keywords'] = $getMenu['title_'.$defaultLanguage];
        $data['description'] = $getMenu['title_'.$defaultLanguage];
        View::render('news/list',$data);
    }


    public function view($slug){
        $defaultLanguage = $this->defaultLang;
        $slug = Security::safe($slug);
        $get = Database::get()->selectOne("SELECT * FROM `{$this->blog_table}` WHERE slug=:slug AND status=1",[":slug"=>$slug]);

        $news_recent = Database::get()->select("SELECT `id`,`title_$defaultLanguage`,`slug`,`create_time` FROM `{$this->blog_table}` WHERE `status`=1 AND `id`!=:id ORDER BY `create_time` DESC LIMIT 0,6",[":id"=>$get['id']]);

        if($get==NULL){
            Url::redirect('404.html');
            exit;
        }

        $data['events'] = Database::get()->select("SELECT `title_{$defaultLanguage}`,`slug`,`create_time` FROM `events` WHERE `status`=1 ORDER BY `create_time` DESC");
        $data['news'] = Database::get()->select("SELECT `title_{$defaultLanguage}`,`slug`,`create_time` FROM `news` WHERE `status`=1 ORDER BY `create_time` DESC");
        $data['result'] = $get;
        $data['page'] = 'other';
        $data['news_recent'] = $news_recent;
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
        $data['title'] = $get['title_'.$this->defaultLang];
        $data['keywords'] = $keywords;
        $data['description'] = $description;
        View::render('news/view',$data);
    }


    public function search(){
        $defaultLanguage = $this->defaultLang;
        $q = Security::safe($_GET['q']);

        $countRows = Database::get()->count("SELECT count(id) FROM {$this->blog_table} WHERE `status` = 1 AND MATCH(title_en, title_ru, text_en, text_ru) AGAINST('{$q}' IN BOOLEAN MODE)");
        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);

        $data['results'] = Database::get()->select("SELECT * FROM `{$this->blog_table}` WHERE `status`=1 AND MATCH(title_en, title_ru, text_en, text_ru) AGAINST('{$q}' IN BOOLEAN MODE) ORDER BY `create_time` DESC ".$limitSql);

        $data['events'] = Database::get()->select("SELECT `title_{$defaultLanguage}`,`slug`,`create_time` FROM `events` WHERE `status`=1 ORDER BY `create_time` DESC");
        $data['news'] = Database::get()->select("SELECT `title_{$defaultLanguage}`,`slug`,`create_time` FROM `news` WHERE `status`=1 ORDER BY `create_time` DESC");

        $data['page'] = 'other';
        $data['searchT'] = $q;
        $data['title'] = 'Search: '.$q;
        $data['keywords'] = 'Search: '.$q;
        $data['description'] = 'Search: '.$q;
        View::render('pages/search',$data);
    }

}
