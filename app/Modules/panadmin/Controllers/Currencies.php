<?php
namespace Modules\panadmin\Controllers;

use Core\View;
use Helpers\Csrf;
use Helpers\Database;
use Helpers\Operation;
use Helpers\Pagination;
use Helpers\Security;
use Helpers\Session;
use Helpers\SimpleValidator;
use Helpers\Url;
use Modules\panadmin\Models\CurrenciesModel as TableModel;

class Currencies extends MyController
{


    public static $safeMode = true;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["default"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=true;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'ASC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field

    public $operation;

    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" => "currencies",
            "cTitle" => "Kurslar",
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

        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);
        $orderBy = $this->operation->getOrderBy();
        $rows = Database::get()->select("SELECT * FROM ".$this->dataParams["cName"]." ORDER BY ".$orderBy.$limitSql);

 		View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
            'pagination' => $pagination,
        ]);
    }

    public function create()
    {

        $model = false;
        if(isset($_POST['submit']) && Csrf::isTokenValid()){
            $postArray = $this->getPost('create');

            $model = $postArray;
            $rules = TableModel::rules();
            $validator = SimpleValidator::validate($postArray, $rules, TableModel::naming() );
            if($validator->isSuccess()){
                $insert = Database::get()->insert($this->dataParams["cName"],$postArray);
                if($insert){
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

        View::renderModule($this->dataParams["cName"].'/create',[
            'dataParams' => $this->getDataParams(),
            'model' => $model
        ]);

    }

    public function update($id)
    {
        if(isset($_POST['submit']) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('update');
            $model = $postArray;

            $rules = TableModel::rules();

            $validator = SimpleValidator::validate($postArray, $rules, TableModel::naming() );
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

        $model = $this->operation->findModel($id);
        View::renderModule($this->dataParams["cName"].'/update',[
            'dataParams' => $this->getDataParams(),
            'model' => $model
        ]);
    }

    public function setDefaultCurrency($id)
    {
        $model = $this->operation->findModel($id);
        Database::get()->raw('UPDATE `'.$this->dataParams["cName"].'` SET `default`=1,`status`=1 WHERE id='.$id);
        Database::get()->raw('UPDATE `'.$this->dataParams["cName"].'` SET `default`=0 WHERE id!='.$id);
        Session::setFlash('success','Əsas kurs dəyişdirildi');
        return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]);
    }

    protected function getPost($action = 'create')
    {
        extract($_POST);
        $array = [];
        $array["fullname"] = Security::safe($fullname);
        $array["rate"] = $rate;
        $array["name"] = mb_strtolower(Security::safe($name));
        $array["status"] = 1;

        return $array;
    }

    public function delete($id)
    {
        $model = $this->operation->findModel($id);
        $this->operation->deleteModel([$id]);
        return Url::previous(MODULE_ADMIN."/".$this->dataParams["cName"]);
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