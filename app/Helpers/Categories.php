<?php
namespace Modules\admin\Controllers;

use Helpers\Csrf;
use Helpers\Database;
use Helpers\Operation;
use Helpers\Pagination;
use Helpers\Recursive;
use Helpers\Security;
use Helpers\Session;
use Helpers\SimpleValidator;
use Models\CategoriesModel as TableModel;
use Models\LanguagesModel;
use Core\View;
use Helpers\Url;

class Categories extends MyController
{

    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=true;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'ASC'; // Siralama ucun order
    public static $positionCondition = true;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // emeliyyatlar bolmesinin gorsenib gorsenmemesi (operations) fields

    public $operation;


    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" => "categories",
            "cModelName" => "CategoriesModel",
            "cTitle" => "Kateqoriyalar",
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
    }

    public function index()
    {
        $db = Database::get();
        $defaultLang = $this->defaultLanguage();
        $rows = Recursive::sub($db,0,'categories',['title_'.$defaultLang,'parent_id','status','id'],[],$defaultLang);
         View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
        ]);
    }

    public function create()
    {
        $model = false;
        $defaultLang = $this->defaultLanguage();
        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('create');
            $model = $postArray;
            $validator = SimpleValidator::validate($postArray,TableModel::$rules,TableModel::$naming);

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
                foreach($validator->getErrors() as $error){
                    $msg .= $error;
                }
                Session::setFlash('error',$msg);

            }

        }

        View::renderModule($this->dataParams["cName"].'/create',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
            'defaultLang' => $defaultLang
        ]);

    }

    public function contact()
    {
        View::renderModule($this->dataParams["cName"].'/contact',[
        ]);
    }

    public function update($id)
    {
        $model = $this->operation->findModel($id);
        $defaultLang = $this->defaultLanguage();

        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('update');
            $model = $postArray;
            $validator = SimpleValidator::validate($postArray,TableModel::$rules,TableModel::$naming);
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
                    $msg .= $error;
                }
                Session::setFlash('error',$msg);

            }
        }
        View::renderModule($this->dataParams["cName"].'/update',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
            'defaultLang' => $defaultLang
        ]);
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
        $array["parent_id"] = Security::safe($parent_id);
        var_dump($parent_id);
        $array["status"] = Security::safe($status);

        $title = "title_".$defaultLang;
        $array["slug"] = Url::str2Url($$title);

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


    public function test()
    {

        $db = Database::get();

        $categories = Recursive::sub($db,0,'categories',[]);
        //var_dump($categories); exit;
        $defaultLang = $this->defaultLanguage();
        $countRows = Database::get()->count("SELECT count(id) FROM ".$this->dataParams["cName"]);

        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);
        $orderBy = $this->operation->getOrderBy();
        $rows = Database::get()->select("SELECT `id`,`position`,`parent_id`,`title_".$defaultLang."`,`status` FROM ".$this->dataParams["cName"]." ORDER BY ".$orderBy.$limitSql);
        //$categories = Recursive::sub($db,'categories',0,'az');

        View::renderModule($this->dataParams["cName"].'/index',[
            'dataParams' => $this->getDataParams(),
            'rows' => $categories,
            'categories' => $categories,
            'pagination' => $pagination,
        ]);

    }




}