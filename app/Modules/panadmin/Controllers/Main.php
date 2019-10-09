<?php
namespace Modules\panadmin\Controllers;

use Helpers\Database;
use Helpers\Session;
use Core\View;
use Core\Router;
use Helpers\Url;
use Modules\panadmin\Models\MenusModel;

class Main extends MyController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [];
 		View::renderModule('main/index', $data);
    }

    public function logout()
    {
        Session::destroy('',true);
        return Url::redirect("panadmin/auth");

    }

    public function notify(){
        $data = array();

        $sound_active = Database::get()->count("SELECT COUNT(`id`) FROM `orders` WHERE `notify_status`=0");
        $count_view = Database::get()->count("SELECT COUNT(`id`) FROM `orders` WHERE `notify_status`=0 OR `notify_status`=1");

        if($sound_active>0){
            $data['sound'] = true;
            Database::get()->update('orders',["notify_status"=>1],["notify_status"=>0]);
        }else{
            $data['sound'] = false;
        }

        if($count_view>0){
            $data['count_view'] = true;
            $data['count_message'] = $count_view;
        }else{
            $data['count_view'] = false;
        }

        $data['success'] = true;
        echo json_encode($data);
    }

}