<?php
namespace Modules\panadmin\Controllers;

use Core\Controller;
use Core\View;
use Core\Router;
use Helpers\Url;
use Helpers\Security;
use Helpers\Csrf;
use Helpers\Database;
use Helpers\Session;

class Auth extends Controller
{
    public function __construct()
    { 
        parent::__construct();
        $this->checkAuth();
    }

    public function checkAuth(){
        $getSessionId=intval(Session::get("auth_session_id"));
        $getSessionPass=Security::safe(Session::get("auth_session_pass"));
        $getAuthInfo=Database::get()->selectOne("SELECT password FROM `admins` WHERE id=:id",["id" => $getSessionId]);

        if(isset($getAuthInfo["password"]) && $getSessionPass==Security::session_password($getAuthInfo["password"])){
            return Url::redirect("panadmin/main/index"); exit;
        }
    }

    public function index()
    {
         if($_POST && Csrf::isTokenValid() ){
            $login=Security::safe($_POST["login_admin"]);
            $password_hash=Security::password_hash(Security::safe($_POST["password"]));
            $auth=Database::get()->selectOne("select * from `admins` where login=:login and password=:password", [':login'=>$login,':password'=>$password_hash] );
            if(intval($auth["id"])>0){
                Session::set("auth_session_id",intval($auth["id"]));
                Session::set("auth_session_pass",Security::session_password($password_hash) );
                Session::set("auth_session_role",intval($auth["role"]) );

                 return Url::redirect("panadmin/main");
            }
            else Session::setFlash("error","Login və ya şifrə yanlışdır.");
        }
        View::renderModule('auth/index','',"panadmin","admin_login");
    }
}