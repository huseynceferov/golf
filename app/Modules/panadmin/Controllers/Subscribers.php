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
use Helpers\SimpleImage;
use Helpers\SimpleValidator;
use Models\LanguagesModel;
use Core\View;
use Helpers\Url;
use Modules\panadmin\Models\AlbumsModel;
use Modules\panadmin\Models\EventsModel as TableModel;

class Subscribers extends MyController
{


    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=false;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'DESC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = false; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field

    public static $issetImage = false;
    public static $requiredImage = false;
    public static $imageFolder = 'subscribers';

    public static $issetAlbum = false;

    public $operation;

    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" =>  "subscribers",
            "cTitle" => "Abunələr",
            "cStatusMode" => self::$statusMode,
            "cPositionEnable" => self::$positionEnable,
            "cCrudMode" => self::$crudMode,

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
        $countRows = Database::get()->count("SELECT count(id) FROM ".$this->dataParams["cName"]);

        $defaultLang = LanguagesModel::getDefaultLanguage();

        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);
        $orderBy = $this->operation->getOrderBy();
        $values = ["title_".$defaultLang=> '',  "status"=>'', "page"=>"index"];
        $rows = Database::get()->select("SELECT * FROM ".$this->dataParams["cName"]." ORDER BY ".$orderBy.$limitSql);
        View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
            'pagination' => $pagination,
            'values' => $values,
        ]);
    }

    public function search(){
        $getArray = $this->getSearchParams();

        $sql = $getArray["SQL"];
        $data = $getArray["Data"];
        $values = $getArray["Values"];

        $countRows = Database::get()->count("SELECT count(id) FROM ".$this->dataParams["cName"]." ".$sql,$data);

        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);
        $orderBy = $this->operation->getOrderBy();
        $rows = Database::get()->select("SELECT * FROM ".$this->dataParams["cName"]." {$sql} ORDER BY ".$orderBy.$limitSql,$data);
        View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
            'pagination' => $pagination,
            'values' => $values,
        ]);
    }

    public function create()
    {
        $model = false;
        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('create');

            $model = $postArray;

            $rules = TableModel::rules();
            $validator = SimpleValidator::validate($postArray,$rules,TableModel::naming());

            if($validator->isSuccess()){
                $insert = Database::get()->insert($this->dataParams["cName"],$postArray);
                if($insert){
                    if(self::$issetImage)
                        $this->getImageUpload($insert, true);

                    Session::setFlash('success','Məlumatlar yadda saxlanıldı');
                    return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]);
                }else{
                    Session::setFlash('error','Xəta baş verdi(DB)');
                }
            }else{
                $msg = '';
                foreach ($validator->getErrors() as $error){
                    $msg.=$error."<BR />";
                }
                Session::setFlash('error',$msg);
            }

        }


        $categories = Database::get()->select("SELECT `id`, `title_{$this->defaultLanguage()}` FROM ".Dishes_catModel::$tableName." WHERE `status` = 1 ORDER BY `id`");
        View::renderModule($this->dataParams["cName"].'/create',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
            'categories' => $categories,
        ]);

    }

    public function update($id)
    {
        $model = $this->operation->findModel($id);
        $defaultLang = LanguagesModel::getDefaultLanguage();

        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('update');
            $model = $postArray;

            $rules = TableModel::rules();
            $validator = SimpleValidator::validate($postArray,$rules,TableModel::naming());

            if($validator->isSuccess()){

                $update =  Database::get()->update($this->dataParams["cName"],$postArray,["id" => $id]);

                if($update or self::$issetImage){
                    if(self::$issetImage)
                        $this->getImageUpload($id);

                    Session::setFlash('success','Məlumatlar yadda saxlanıldı');
                    return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]);
                }else{
                    Session::setFlash('error','Heç bir məlumat dəyişdirilməyib (DB)');
                }
            }else{
                $msg = '';
                foreach ($validator->getErrors() as $error){
                    $msg.=$error."<BR />";
                }
                Session::setFlash('error',$msg);
            }

        }

        $categories = Recursive::sub(Database::get(),0,'categories',['title_'.$this->defaultLanguage(),'id','parent_id'],[],$this->defaultLanguage());
        View::renderModule($this->dataParams["cName"].'/update',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    protected function getPost($action = 'create')
    {
        $languages = LanguagesModel::getLanguages();
        $defaultLang = LanguagesModel::getDefaultLanguage();

        extract($_POST);
        $array = [];
        foreach($languages as $lang){
            $title = "title_".$lang["name"];
            $array[$title] = Security::safe($$title);
        }

        $array["status"] = Security::safe($status);
        $title = "title_".$defaultLang;
        $array["slug"] = Url::str2Url($$title);

        return $array;
    }

    protected function getSearchParams(){
        $array = [];
        if(isset($_GET["submit"])){
            $defaultLang = $this->defaultLanguage();
            $search_array = " WHERE ";
            $search_execute = [];
            $values = ["title_".$defaultLang=> '', "status"=>'', "page"=>"search"];
            if (!empty($_GET['title_'.$defaultLang])){
                $search_array.="`title_{$defaultLang}` LIKE :title_{$defaultLang} AND ";
                $search_execute[':title_'.$defaultLang]= '%'.$_GET['title_'.$defaultLang].'%';
                $values['title_'.$defaultLang] = $_GET['title_'.$defaultLang];
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
