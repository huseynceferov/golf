<?php
namespace Modules\panadmin\Controllers;

use Helpers\Csrf;
use Helpers\Database;
use Helpers\File;
use Helpers\Operation;
use Helpers\Pagination;
use Helpers\Recursive;
use Helpers\Security;
use Helpers\Session;
use Helpers\SimpleValidator;
use Modules\panadmin\Models\AlbumsModel;
use Modules\panadmin\Models\MenusModel as TableModel;
use Models\LanguagesModel;
use Core\View;
use Helpers\Url;

class Menus extends MyController
{

    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=true;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'ASC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // emeliyyatlar bolmesinin gorsenib gorsenmemesi (operations) fields

    public static $issetImage = false;
    public static $requiredImage = false;
    public static $imageFolder = 'menus';

    public static $issetAlbum = false;

    //set place of menu true or false: up and down
    public static $posUp = true;
    public static $posDown = true;

    // set menu types
    public static $menuType = ["site" => "Existing page", "static" => "Static page", "url" => "Another site"];

    // static page url
    public static $staticUrl = 'page';

    public $operation;


    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" => "menus",
            "cModelName" => "MenusModel",
            "cTitle" => "Menular",
            "cStatusMode" => self::$statusMode,
            "cPositionEnable" => self::$positionEnable,
            "cCrudMode" => self::$crudMode,
            "posUp" => self::$posUp,
            "posDown" => self::$posDown,
            "menuType" => self::$menuType,
            "staticUrl" => self::$staticUrl

        ];
        return $this->dataParams;
    }

    public function __construct()
    {
        $this->getDataParams();
        $this->operation = new Operation();
        $this->operation->tableName = $this->dataParams["cName"];
        parent::__construct();

        if(parent::accessControl(['create', 'update', 'delete'], $this->dataParams["cName"]) == true) {
            return Url::redirect(MODULE_ADMIN);

        }
    }

    public function index()
    {
        
        $db = Database::get();
        $defaultLang = $this->defaultLanguage();
        $values = ["id"=> '', "title_".$defaultLang=> '', "parent_id"=> '', "status"=>'', "page"=>"index"];
        $rows = Recursive::sub($db,0,'menus',['title_'.$defaultLang,'parent_id','status','id', 'up', 'down', 'url', 'menu_type'],[],$defaultLang);
         View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
            'values' => $values,
        ]);
    }

    public function search(){
        $getArray = $this->getSearchParams();

        $sql = $getArray["SQL"];
        $data = $getArray["Data"];
        $values = $getArray["Values"];

        $orderBy = $this->operation->getOrderBy();
        $rows = Database::get()->select("SELECT * FROM ".$this->dataParams["cName"]." ".$sql,$data);
        View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
            'values' => $values,
        ]);
    }

    public function create()
    {
        $model = false;
        $defaultLang = $this->defaultLanguage();
        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('create');
            $model = $postArray;

            $rules = TableModel::rules();
            $validator = SimpleValidator::validate($postArray,$rules,TableModel::naming());

            if($validator->isSuccess()){
                $insert = Database::get()->insert($this->dataParams["cName"],$postArray);
                if($insert){

                    if(self::$positionEnable)
                        $position = $this->operation->getPositionForNew($insert,'up',true);

                    Session::setFlash('success','Məlumatlar yadda saxlanıldı');
                    return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]);
                }else{
                    Session::setFlash('error','Xəta baş verdi(DB)');
                }
            }else{
                $msg = '';
                foreach($validator->getErrors() as $error){
                    $msg .= $error.'<br>';
                }
                Session::setFlash('error',$msg);

            }

        }

        $menus = Recursive::sub(Database::get(),0,'menus',['title_'.$defaultLang,'parent_id','status','id'],[],$defaultLang);

        View::renderModule($this->dataParams["cName"].'/create',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
            'defaultLang' => $defaultLang,
            'menus' => $menus
        ]);

    }

    public function update($id)
    {
        $model = $this->operation->findModel($id);
        $defaultLang = $this->defaultLanguage();

        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('update');
            $model = $postArray;
            $rules = TableModel::rules();

            $validator = SimpleValidator::validate($postArray,$rules,TableModel::naming());
            if($validator->isSuccess()){
                $update =  Database::get()->update($this->dataParams["cName"],$postArray,["id" => $id]);
                if($update){
                    Session::setFlash('success','Məlumatlar yadda saxlanıldı');
                    return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]);
                }else{
                    Session::setFlash('error','Heç bir məlumat dəyişdirilməyib (DB)');
                }
            }else{
                $msg = '';
                foreach($validator->getErrors() as $error){
                    $msg .= $error.'<br>';
                }
                Session::setFlash('error',$msg);

            }
        }

        $menus = Recursive::sub(Database::get(),0,'menus',['title_'.$defaultLang,'parent_id','status','id'],[],$defaultLang);

        View::renderModule($this->dataParams["cName"].'/update',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
            'defaultLang' => $defaultLang,
            'menus' => $menus
        ]);
    }

    public function view($id)
    {
        $model = $this->operation->findModel($id);
        $photos = [];
        if(self::$issetAlbum){
            $photos = AlbumsModel::getPhotos($this->dataParams["cName"],$id);
        }
        View::renderModule($this->dataParams["cName"].'/view', [
            'dataParams' => $this->getDataParams(),
            'result' => $model,
            'defaultLang' => $this->defaultLanguage(),
            'photos' => $photos,
            'issetAlbum' => self::$issetAlbum
        ]);
    }

    public function test()
    {
        $get_menus = Recursive::menu(Database::get(), $this->dataParams["cName"], 0, LanguagesModel::getDefaultLanguage());
        print_r($get_menus);
    }

    protected function getPost($action = 'create')
    {
        $languages = LanguagesModel::getLanguages();
        $defaultLang = $this->defaultLanguage();
        extract($_POST);
        $array = [];
        foreach($languages as $lang){
            $text = "text_".$lang["name"];
            $array[$text] = Security::safe($$text);

            $title = "title_".$lang["name"];
            $array[$title] = Security::safe($$title);
        }


        if($url) {
            $array["url"] = Security::safe($url);
        }

        $array["parent_id"] = Security::safe($parent_id);
        $array["status"] = Security::safe($status);
        $array["tags"] = Security::safe($tags);
        $array["meta_description"] = Security::safe($meta_description);

        $title = "title_".$defaultLang;
        $array["slug"] = Url::str2Url($$title);

        if(isset($up) && intval($up) > 0) {
            $array["up"] = $up;
        } else {
            $array["up"] = 0;
        }
        if(isset($down) && intval($down) > 0) {
            $array["down"] = $down;
        } else {
            $array["down"] = 0;
        }

        if(isset($menu_type)) {
            $array["menu_type"] = $menu_type;
        }

        return $array;
    }

    protected function getSearchParams(){
        $array = [];
        if(isset($_GET["submit"])){
            $defaultLang = $this->defaultLanguage();
            $search_array = " WHERE ";
            $search_execute = [];
            $values = ["id"=> '', "title_".$defaultLang=> '', "parent_id"=> '', "status"=>'', "page"=>"search"];
            if (isset($_GET['id']) && intval($_GET['id'])>0){
                $search_array.="`id`=:id AND ";
                $search_execute[':id']= $_GET['id'];
                $values["id"] = $_GET['id'];
            }
            if (!empty($_GET['title_'.$defaultLang])){
                $search_array.="`title_{$defaultLang}`=:title_{$defaultLang} AND ";
                $search_execute[':title_'.$defaultLang]= $_GET['title_'.$defaultLang];
                $values['title_'.$defaultLang] = $_GET['title_'.$defaultLang];
            }
            if (isset($_GET['parent_id']) && intval($_GET['parent_id'])>0) {
                $search_array .= "`parent_id`=:parent_id AND ";
                $search_execute[':parent_id'] = $_GET['parent_id'];
                $values["parent_id"] = $_GET['parent_id'];
            }
            if (isset($_GET['status'])){
                $search_array.="status=:status";
                $search_execute[':status']=$_GET['status'];
                $values["status"] = $_GET['status'];
            }
            else{
                $search_array.="status=:status";
                $search_execute[':status']= 0;
                $values["status"] = '0';
            }
            $values["page"]="search";
            $array = array("SQL"=>$search_array,"Data"=>$search_execute,"Values"=>$values);
        }
        return $array;
    }

    public function delete($id)
    {
        $model = $this->operation->findModel($id);
        $this->operation->deleteModel([$id]);

        if(self::$issetImage) $this->deleteImage($id);
        if(self::$issetAlbum) Photos::deletePhotos($this->dataParams['cName'],$id);

        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }


    public function deleteImage($id)
    {
        if(is_dir(Url::uploadPath().self::$imageFolder.'/'.$id)) {
            File::rmDir(Url::uploadPath().self::$imageFolder.'/'.$id);
        }

        return true;
    }

    public function up($id)
    {
        $this->operation->move($id,'up');
        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

    public function down($id)
    {
        $this->operation->move($id,'down');
        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

    public function status($id)
    {
        $model = $this->operation->findModel($id);
        $status = $model["status"]==1?0:1;
        $this->operation->statusModel([$id],$status);
        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

    public function operation()
    {
        if(isset($_POST["row_check"])){
            if(isset($_POST["delete"])){
                $row_check = $_POST["row_check"];
                foreach ($row_check as $ids) {
                    if (self::$issetImage) {
                        $this->deleteImage($ids);
                    }
                    if (self::$issetAlbum) {
                        Photos::deletePhotos($this->dataParams['cName'], $ids);
                    }
                }
                $this->operation->deleteModel($row_check);
            }elseif(isset($_POST["active"])){
                $row_check = $_POST["row_check"];
                $this->operation->statusModel($row_check,1);
            }elseif(isset($_POST["deactive"])){
                $row_check = $_POST["row_check"];
                $this->operation->statusModel($row_check,0);
            }
        }else{
            Session::setFlash('error','Seçim edilməyib');

        }


        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);

    }

}