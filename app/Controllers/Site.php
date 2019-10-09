<?php
namespace Controllers;

use Core\View;
use Helpers\Cookie;
use Helpers\Csrf;
use Helpers\Database;
use Helpers\Date;
use Helpers\Pagination;
use Helpers\Security;
use Helpers\Session;
use Helpers\SimpleValidator;
use Helpers\Url;
use Models\ContactModel as TableModel;
use Models\SubscribersModel;

/**
 * Sample controller showing a construct and 2 methods and their typical usage.
 */
class Site extends MyController
{

    public  $subscriber_table,
            $gallery_table;
    /**
     * Call the parent construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->language->load('app');
        $this->subscriber_table = SubscribersModel::$tableName;
    }

    public function meta($keyword, $author, $description)
    {
        echo '<meta name="author" content="Golf in Azerbaijan">
        <meta name="keywords" content="'.$keyword.'">
        <meta name="description" content="'.$description.'">
        <meta name="copyright" content="'.$author.'" />';
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
        $data['golfClubs'] = Database::get()->select("SELECT * FROM `clubs` WHERE `status`=1 ORDER BY `create_time` DESC");

        $data['golfTours'] = Database::get()->select("SELECT * FROM `tours` WHERE `status`=1 ORDER BY `create_time` DESC");

        $data['news'] = Database::get()->select("SELECT * FROM `news` WHERE `status`=1 ORDER BY `create_time` DESC LIMIT 3");

        $data['events'] = Database::get()->select("SELECT * FROM `events` WHERE `status`=1 ORDER BY `id` DESC");

        $getArray = false;

        $data['page'] = 'index';
        $data["model"] = $getArray;
        $data['title'] = 'Golf in Azerbaijan';
        $data['keywords'] = 'Golf in Azerbaijan';
        $data['description'] = 'Golf in Azerbaijan';
        View::render('site/index', $data);
    }

    public function page($id, $slug)
    {
        $defaultLanguage = $this->defaultLang;
        $menu = parent::getMenu();
        $data['foot_menu'] = $this->getDownMenu();
        $data['contacts'] = $this->getContacts();

        $get_page = Database::get()->selectOne("SELECT title_{$defaultLanguage}, text_{$defaultLanguage}, `tags`, `meta_description`, `url` FROM `menus` WHERE `id` = :id AND `url` = :url AND `status` = 1 AND `menu_type`= 'static' ", [':id' => $id, ':url' => $slug]);
        if(!is_array($get_page) || count($get_page) == 0) {
            Url::redirect('not_found');
        }

        $data['language'] = $defaultLanguage;
        $data['title'] = $get_page['title_'.$defaultLanguage];
        $data['keywords'] = $get_page['tags'];
        $data['description'] = $get_page['meta_description'];
        $data['menus'] = $menu;
        $data['get_page'] = $get_page;
        $data['foot_about'] = parent::getAbout();
        $data['lang'] = $this->language;

        if($get_page['url'] == 'aboutus') {
            View::render('site/about', $data);
        } else {
            View::render('site/page', $data);
        }

    }

    public function contact()
    {
        $defaultLanguage = $this->defaultLang;
        $menu = parent::getMenu();
        $contacts = parent::getContacts();
        $data['foot_menu'] = $this->getDownMenu();

        $model = false;
        if(isset($_POST['submit']) && Csrf::isTokenValid()) {
            $postArray = $this->getPost();
            $model = $postArray;
            
            $validator = SimpleValidator::validate($postArray, TableModel::$rules, TableModel::naming());
            if($validator->isSuccess()) {
                $to = $contacts['email'];

                $txt = '
            <html>
            <head>
            <title>Email from '.SITE_URL.'</title>
            </head>
            <body style="background: #ffffff">
                <h4>'.$model['subject'].'</h4>
                <h4>'.$model['fullname'].'</h4>
                <h5>'.$model['message'].'</h5>
                <h5>'.$model['email'].'</h5>
            </body>
            </html>
            ';

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= "From: ".$model['email']." " . "\r\n";

                $send = mail($to, $model['subject'], $txt, $headers);


                if ($send == true) {
                    Session::setFlash('success', $this->language->get('email_ok'));
                } else {
                    $msg = $this->language->get('email_not_ok');
                    Session::setFlash('error',$msg);
                }
            } else {
                $msg = '';
                foreach ($validator->getErrors() as $error){
                    $msg.=$error."<BR />";
                }
                Session::setFlash('error',$msg);
            }
        }


        $data['page'] = 'other';
        $data['title'] = 'Bizimlə əlaqə';
        $data['description'] = 'Bizimlə əlaqə';
        $data['keywords'] = 'Bizimlə əlaqə';
        $data['model'] = $model;
        $data['lang'] = $this->language;

        View::render('site/contact', $data);
    }

    protected function getPost()
    {
        extract($_POST);

        $array = [];
        $array['email'] = Security::safe($email);
        $array['message'] = Security::safe($message);
        $array['fullname'] = Security::safe($fullname);
        $array['subject'] = Security::safe($subject);

        return $array;
    }

    public function gallery()
    {
        $countRows = Database::get()->count("SELECT count(id) FROM {$this->gallery_table} WHERE `status` = 1 AND `table_name` = 'albums' ");
        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);

        $get_photos = Database::get()->select("SELECT `id`, `title_az`, `image`, `thumb`, `row_id` FROM {$this->gallery_table} WHERE `table_name` = 'albums' AND `status` = 1 ".$limitSql);

        $data['contacts'] = parent::getContacts();
        $data['photos'] = $get_photos;
        $data['pagination'] = $pagination;
        $data['foot_menu'] = $this->getDownMenu();
        $data['menus'] = parent::getMenu();
        $data['language'] = $this->defaultLang;
        $data['title'] = 'Gallery';
        $data['description'] = 'Gallery';
        $data['keywords'] = 'Gallery';
        $data['foot_about'] = parent::getAbout();
        $data['lang'] = $this->language;

        View::render('site/gallery', $data);
    }

    public function addSubscriber(){
        $data = [];
        if(isset($_POST)){
            $postArray['email'] = $_POST['subscriber'];
            $rules = TableModel::$rule_sub;
            $rules['email'][] = 'exists('.$this->subscriber_table.',email, 0)';
            $validator = SimpleValidator::validate($postArray, $rules, TableModel::naming());
            if($validator->isSuccess()) {
                Database::get()->insert($this->subscriber_table,['email'=>$postArray['email'],'sub_date'=>date("Y-m-d")]);
                $data['success'] = true;
                $data['message'] = $this->language->get('You_have_successfully_subscribed_to_our_newsletter');
            }else{
                $msg = '';
                foreach ($validator->getErrors() as $error){
                    $msg.=$error;
                }
                $data['success'] = false;
                $data['message'] = $msg;
            }
        }else{
            $data['success'] = false;
            $data['message'] = 'Abunə olunarkən bir səhv baş verdi. Zəhmət olmasa bir daha cəhd edin';
        }
        echo json_encode($data);
    }

    public function aboutUs(){
        $defaultLanguage = $this->defaultLang;
        $get = Database::get()->selectOne("SELECT `title_{$defaultLanguage}`,`text_{$defaultLanguage}`,`desc_{$defaultLanguage}`,`key_{$defaultLanguage}` FROM `about` LIMIT 1");

        $data['golfTours'] = Database::get()->select("SELECT * FROM `tours` WHERE `status`=1 ORDER BY `create_time` DESC");
        $data['page'] = 'other';
        $data['result'] = $get;
        $data['title'] = $get['title_'.$defaultLanguage];
        $data['description'] = $get['desc_'.$defaultLanguage];
        $data['keywords'] = $get['key_'.$defaultLanguage];

        View::render('site/about', $data);
    }

    public function ourRestaurant(){
        $defaultLanguage = $this->defaultLang;
        $get = Database::get()->selectOne("SELECT `title_{$defaultLanguage}`,`text_{$defaultLanguage}`,`desc_{$defaultLanguage}`,`key_{$defaultLanguage}` FROM `restaurant` LIMIT 1");

        $data['result'] = $get;
        $data['title'] = $get['title_'.$defaultLanguage];
        $data['description'] = $get['desc_'.$defaultLanguage];
        $data['keywords'] = $get['key_'.$defaultLanguage];

        View::render('site/ourRestaurant', $data);
    }

    public function loadPage()
    {

        $data['language'] = $this->defaultLang;
        $countRows = Database::get()->count("SELECT count(id) FROM {$this->gallery_table} WHERE `status` = 1 AND `table_name` = 'albums' ");
        $pagination = new Pagination();
        if(isset($_GET['page'])) {
            $page = intval($_GET['page']);
        } else {
            $page = 1;
        }
        $limit = $pagination->getDefaultLimit();
        $limitSql = ($page)*$limit.','.($page+1)*$limit;
        $photos = Database::get()->select("SELECT `id`, `title_az`, `image`, `thumb`, `row_id`  FROM {$this->gallery_table} WHERE `status` = 1 AND `table_name` = 'albums' ORDER BY `id` DESC LIMIT " . $limitSql);

        $rowCount = count($photos);
        if($rowCount > 0) {
            foreach ($photos as $photo) {
                echo '<div class="col-lg-4 col-md-4 col-sm-4 photo_div">
							<div>
								<div class="pr_photo">
									<a class="fancybox" rel="group" href="'.\Helpers\Url::filePath()."/".$photo["image"].'">
										<div class="img_hover">
											<div class="photo_title">'.$photo['title_az'].'</div>
										</div>
									</a>
									<i class="fa fa-search-plus fa-3x"></i>
									<img src="'.\Helpers\Url::filePath().$photo['thumb'].'" alt="Image" class="img-responsive center-block">
								</div>
							</div>

						</div>';
            }
        } else {
            echo $rowCount;
        }
    }

    public function setlanguage($name)
    {
        if(Cookie::has($name) == false) {
            Cookie::set('lang', $name);
            Url::previous(DIR);
        } else {
            Url::previous(DIR);
        }
    }


    public function not_found()
    {
        $data['title'] = $this->language->get('not_found_title');
        $data['description'] = $this->language->get('not_found_title');
        $data['keywords'] = $this->language->get('not_found_title');

        View::render('site/not_found', $data);
    }

}
