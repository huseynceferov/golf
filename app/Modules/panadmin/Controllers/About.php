<?php
namespace Modules\panadmin\Controllers;

use Helpers\Csrf;
use Helpers\Data;
use Helpers\Database;
use Helpers\Operation;
use Helpers\Recursive;
use Helpers\Security;
use Helpers\Session;
use Helpers\SimpleImage;
use Helpers\SimpleValidator;
use Models\LanguagesModel;
use Core\View;
use Helpers\Url;
use Modules\panadmin\Models\AboutModel as TableModel;

class About extends MyController
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
    public static $imageFolder = 'restaurant';

    public static $issetAlbum = false;

    public $operation;

    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" =>  "about",
            "cTitle" => "Haqqımızda",
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


    public function create()
    {
        $exist = Database::get()->selectOne("SELECT `id` FROM `about` LIMIT 1");
        if(is_array($exist) && array_key_exists('id', $exist) && $exist['id'] > 0) {
            Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]."/update/".$exist["id"]);
        }
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
                    return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]."/create");
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
                    if(self::$issetImage) $this->getImageUpload($id);
                    if(self::$issetImage2) $this->getLogoUpload($id);
                    if(self::$issetImage3) $this->getBgUpload($id);

                    Session::setFlash('success','Məlumatlar yadda saxlanıldı');
                    Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]."/update/".$id);
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
            'model' => $model
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

            $text = "text_".$lang["name"];
            $array[$text] = Security::safe($$text);

            $desc = "desc_".$lang["name"];
            $array[$desc] = Security::safe($$desc);

            $key = "key_".$lang["name"];
            $array[$key] = Security::safe($$key);

        }


        return $array;
    }


    protected function getImageUpload($id,$createStatus=true)
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
            $img->load($_FILES["image"]["tmp_name"])->fit_to_width(150)->save($destination);
            $img->load($_FILES["image"]["tmp_name"])->fit_to_width(450)->save($destination_middle);

            $sql_img = self::$imageFolder.'/'.$id.'/' . $id."_0.".$ext;
            $sql_thumb_img = self::$imageFolder.'/'.$id.'/thumbs/' . $id."_0.".$ext;
            $sql_middle_img = self::$imageFolder.'/'.$id.'/middle/' . $id."_0.".$ext;
            Database::get()->update($this->dataParams["cName"], ['image' => $sql_img,'thumb'=>$sql_thumb_img,'middle'=>$sql_middle_img], ['id' => $id]);
        }
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