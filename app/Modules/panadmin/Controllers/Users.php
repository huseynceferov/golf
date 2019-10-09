<?php
namespace Modules\panadmin\Controllers;

use Helpers\Csrf;
use Helpers\Database;
use Helpers\File;
use Helpers\Operation;
use Helpers\Pagination;
use Helpers\Security;
use Helpers\Session;
use Helpers\SimpleImage;
use Helpers\SimpleValidator;
use Models\LanguagesModel;
use Core\View;
use Helpers\Url;
use Modules\panadmin\Models\UsersModel as TableModel;


class Users extends MyController
{
    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable = false;     // Siralama aktiv, deaktiv
    public static $positionOrderBy = 'ASC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field

    public static $issetImage = false;
    public static $requiredImage = false;
    public static $imageFolder = 'orders';

    public static $issetAlbum = false;

    public $operation;

    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" => "users",
            "cTitle" => "İstifadəçilər",
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

        if (parent::accessControl(['create', 'update', 'delete'], $this->dataParams["cName"]) == true) {
            return Url::redirect(MODULE_ADMIN);

        }
    }

    public function index()
    {
        $countRows = Database::get()->count("SELECT count(id) FROM " . $this->dataParams["cName"]);

        $defaultLang = LanguagesModel::getDefaultLanguage();

        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);
        $orderBy = $this->operation->getOrderBy();
        $values = ["name" => '', 'phone'=> '', 'email'=>'', "status" => '', "page" => "index"];
        $rows = Database::get()->select("SELECT * FROM " . $this->dataParams["cName"] . " ORDER BY " . $orderBy . $limitSql);
        View::renderModule($this->dataParams["cName"] . '/index', [
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

    protected function getSearchParams(){
        $array = [];
        if(isset($_GET["submit"])){
            $defaultLang = $this->defaultLanguage();
            $search_array = " WHERE ";
            $search_execute = [];
            $values = ["name"=> '', 'phone'=> '', 'email'=> '', "status"=>'', "page"=>"search"];
            if (!empty($_GET['name'])){
                $search_array.="`name` LIKE :name AND ";
                $search_execute[':name']= '%'.$_GET['name'].'%';
                $values['name'] = $_GET['name'];
            }

            if(isset($_GET['phone']) AND !empty($_GET['phone'])){
                $search_array .= "`phone`=:phone AND ";
                $search_execute[':phone'] = $_GET['phone'];
                $values["phone"] = $_GET['phone'];
            }

            if(isset($_GET['email']) AND !empty($_GET['email'])){
                $search_array .= "`email`=:email AND ";
                $search_execute[':email'] = $_GET['email'];
                $values["email"] = $_GET['email'];
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

    public function approved($id)
    {
        Database::get()->update($this->dataParams["cName"],["approve"=>1],["id"=>$id]);

        Session::setFlash('success',"İstifadəçi təsdiqləndi");

        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

    public function pending($id)
    {
        Database::get()->update($this->dataParams["cName"],["approve"=>0],["id"=>$id]);

        Session::setFlash('success',"İstifadəçi təsdiqdən çıxarıldı");

        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

    public function status($id)
    {
        $model = $this->operation->findModel($id);
        $status = $model["status"]==1?0:1;
        $this->operation->statusModel([$id],$status);
        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
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

                if($update){
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
        View::renderModule($this->dataParams["cName"].'/update',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
        ]);
    }

    protected function getPost($action = 'create')
    {

        extract($_POST);
        $array = [];

        $array["name"] = Security::safe($name);
        $array["email"] = Security::safe($email);
        $array["bonus"] = Security::safe($bonus);
        $array["status"] = Security::safe($status);

        return $array;
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

    public function delete($id)
    {
        $model = $this->operation->findModel($id);
        $this->operation->deleteModel([$id]);
        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

}