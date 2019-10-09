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
use Modules\panadmin\Models\ClubsModel as TableModel;

class Tips extends MyController
{


    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=false;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'DESC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field

    public static $issetImage = true;
    public static $requiredImage = true;
    public static $imageFolder = 'tips';

    public static $issetAlbum = false;

    public $operation;

    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" =>  "tips",
            "cTitle" => "Tips",
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
        $values = ["id"=> '', "title_".$defaultLang=> '', "category_id"=> '', "status"=>'', "page"=>"index"];
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
            $postArray["create_time"] = time();

            $model = $postArray;

            $rules = TableModel::rules();
            $rules['image'][] = 'required_file';
            $rules['image'][] = 'image_mime_types(png-jpeg-gif-jpg)';
            $validator = SimpleValidator::validate(array_merge($postArray, $_FILES),$rules,TableModel::naming());

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

        View::renderModule($this->dataParams["cName"].'/create',[
            'dataParams' => $this->getDataParams(),
            'model' => $model,
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

                    Session::setFlash('success','Data is saved');
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

    protected function getImageUpload($id,$createStatus=false)
    {
        if(!empty($_FILES['image']['tmp_name']) and Security::filterFileMimeTypes($_FILES['image']['type'])) {

            $new_dir = Url::uploadPath().self::$imageFolder.'/'.$id;
            $new_thumb_dir = Url::uploadPath().self::$imageFolder.'/'.$id.'/thumbs';
            $new_middle_dir = Url::uploadPath().self::$imageFolder.'/'.$id.'/middle';

            if(!is_dir($new_dir)) {
                mkdir($new_dir,0777, true);
                chmod($new_dir, 0777);
            }
            if(!is_dir($new_thumb_dir)) {
                mkdir($new_thumb_dir,0777, true);
                chmod($new_thumb_dir, 0777);
            }
            if(!is_dir($new_middle_dir)) {
                mkdir($new_middle_dir,0777, true);
                chmod($new_middle_dir, 0777);
            }

            $file_arr = explode('.', $_FILES['image']['name']);
            $ext = end($file_arr);
            $destination_original = $new_dir."/" . $id."_0.".$ext;
            $destination = $new_thumb_dir."/" . $id."_0.".$ext;
            $destination_middle = $new_middle_dir."/" . $id."_0.".$ext;


            $img = new SimpleImage();
            $img->load($_FILES["image"]["tmp_name"])->save($destination_original);
            $img->load($_FILES["image"]["tmp_name"])->fit_to_width(650)->save($destination);
            $img->load($_FILES["image"]["tmp_name"])->resize(596, 455)->save($destination_middle);

            $sql_img = self::$imageFolder.'/'.$id.'/middle/' . $id."_0.".$ext;
            $sql_thumb_img = self::$imageFolder.'/'.$id.'/thumbs/' . $id."_0.".$ext;
            Database::get()->update($this->dataParams["cName"], ['image' => $sql_img, 'thumb' => $sql_thumb_img], ['id' => $id]);
        }
    }

    protected function getPost($action = 'create')
    {
        $languages = LanguagesModel::getLanguages();
        $defaultLang = LanguagesModel::getDefaultLanguage();

        extract($_POST);
        $array = [];
        foreach($languages as $lang){
            $text = "text_".$lang["name"];
            $array[$text] = Security::safe($$text);

            $short_text = "short_text_".$lang["name"];
            $array[$short_text] = Security::safe($$short_text);

            $title = "title_".$lang["name"];
            $array[$title] = Security::safe($$title);

            $location = "location_".$lang["name"];
            $array[$location] = Security::safe($$location);
        }


        $array["status"] = Security::safe($status);
        $title = "title_az";
        $array["slug"] = Url::str2Url($$title);

        return $array;
    }

    protected function getSearchParams(){
        $array = [];
        if(isset($_GET["submit"])){
            $defaultLang = $this->defaultLanguage();
            $search_array = " WHERE ";
            $search_execute = [];
            $values = ["id"=> '', "title_".$defaultLang=> '', "category_id"=> '', "status"=>'', "page"=>"search"];
            if (isset($_GET['id']) && intval($_GET['id'])>0){
                $search_array.="`id`=:id AND ";
                $search_execute[':id']= $_GET['id'];
                $values["id"] = $_GET['id'];
            }
            if (!empty($_GET['title_'.$defaultLang])){
                $search_array.="`title_{$defaultLang}`=:title_{$defaultLang} AND ";
                $search_execute[':title_'.$defaultLang]= '%'.$_GET['title_'.$defaultLang].'%';
                $values['title_'.$defaultLang] = $_GET['title_'.$defaultLang];
            }
            if (isset($_GET['category_id']) && intval($_GET['category_id'])>0) {
                $search_array .= "`category_id`=:category_id AND ";
                $search_execute[':category_id'] = $_GET['category_id'];
                $values["category_id"] = $_GET['category_id'];
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