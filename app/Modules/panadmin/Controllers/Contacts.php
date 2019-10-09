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
use Modules\panadmin\Models\ContactsModel as TableModel;

class Contacts extends MyController
{


    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=false;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'DESC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = false; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field

    public static $issetImage = true;
    public static $issetImage2 = true;
    public static $issetImage3 = false;
    public static $requiredImage = false;
    public static $imageFolder = 'logo';

    public static $issetAlbum = false;

    public $operation;

    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" =>  "contacts",
            "cTitle" => "Əlaqə məlumatları",
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
        $exist = Database::get()->selectOne("SELECT `id` FROM `contacts` LIMIT 1");
        if(is_array($exist) && array_key_exists('id', $exist) && $exist['id'] > 0) {
            Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"]."/update/".$exist["id"]);
        }
        $model = false;
        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $postArray = $this->getPost('create');

            $model = $postArray;

            $rules = TableModel::rules();
            $rules['image'][] = 'required_file';
            $rules['image'][] = 'image_mime_types(png-jpeg-gif-jpg)';
            $validator = SimpleValidator::validate(array_merge($postArray, $_FILES),$rules,TableModel::naming());

//            if(self::$requiredImage and Security::filterFileMimeTypes($_FILES['image']['type']) == false) {
//                Session::setFlash('error', 'Sekil problemi');
//                return Url::redirect(MODULE_ADMIN."/".$this->dataParams["cName"].'/create');
//            }

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
            $working_days = "working_days_".$lang["name"];
            $array[$working_days] = Security::safe($$working_days);

            $weekend_days = "weekend_days_".$lang["name"];
            $array[$weekend_days] = Security::safe($$weekend_days);

            $address = "address_".$lang["name"];
            $array[$address] = Security::safe($$address);

            $diff = "diff_".$lang["name"];
            $array[$diff] = Security::safe($$diff);

        }

        $array["map_lat"] = Security::safe($_POST["map_lat"]);
        $array["map_long"] = Security::safe($_POST["map_long"]);

        if(!empty($_POST['home_tel'])) {
            $array["home_tel"] = Security::safe($_POST['home_tel']);
        }

        if(!empty($_POST['mobile_tel'])) {
            $array["mobile_tel"] = Security::safe($_POST['mobile_tel']);
        }

        if(!empty($_POST['other_tel'])) {
            $array["other_tel"] = Security::safe($_POST['other_tel']);
        }

        if(!empty($_POST['fax'])) {
            $array["fax"] = Security::safe($_POST['fax']);
        }

        if(!empty($_POST['email'])) {
            $array["email"] = Security::safe($_POST['email']);
        }

        if(!empty($_POST['facebook'])) {
            $array["facebook"] = Security::safe($_POST['facebook']);
        }

        if(!empty($_POST['twitter'])) {
            $array["twitter"] = Security::safe($_POST['twitter']);
        }

        if(!empty($_POST['google_plus'])) {
            $array["google_plus"] = Security::safe($_POST['google_plus']);
        }

        if(!empty($_POST['instagram'])) {
            $array["instagram"] = Security::safe($_POST['instagram']);
        }

        if(!empty($_POST['linkedin'])) {
            $array["linkedin"] = Security::safe($_POST['linkedin']);
        }

        if(!empty($_POST['youtube'])) {
            $array["youtube"] = Security::safe($_POST['youtube']);
        }

        if(!empty($_POST['whatsapp'])) {
            $array["whatsapp"] = Security::safe($_POST['whatsapp']);
        }

        if(!empty($_POST['vkontakte'])) {
            $array["vkontakte"] = Security::safe($_POST['vkontakte']);
        }

        if(!empty($_POST['vimeo'])) {
            $array["vimeo"] = Security::safe($_POST['vimeo']);
        }

        if(!empty($_POST['pinterest'])) {
            $array["pinterest"] = Security::safe($_POST['pinterest']);
        }


        return $array;
    }

    protected function getImageUpload($id,$createStatus=false)
    {
        if(!empty($_FILES['image']['tmp_name']) and Security::filterFileMimeTypes($_FILES['image']['type'])) {

            $logo_dir = Url::uploadPath().self::$imageFolder;

            if(!is_dir($logo_dir)) {
                mkdir($logo_dir, 0777);
                chmod($logo_dir, 0777);
            }
            $file_arr = explode('.', $_FILES['image']['name']);
            $ext = end($file_arr);
            $destination_original = $logo_dir."/logo.png";

            $img = new SimpleImage();
            $img->load($_FILES["image"]["tmp_name"])->save($destination_original);
            //$img->load($_FILES["image"]["tmp_name"])->resize(320, 239)->save($destination);

            $sql_img = self::$imageFolder.'/logo.png';
            //$sql_thumb_img = self::$imageFolder.'/'.$id.'/thumbs/' . $id."_0.".$ext;
            Database::get()->update($this->dataParams["cName"], ['logo' => $sql_img], ['id' => $id]);
        }
    }

    protected function getLogoUpload($id,$createStatus=false)
    {
        if(!empty($_FILES['image2']['tmp_name']) and Security::filterFileMimeTypes($_FILES['image2']['type'])) {

            $logo_dir = Url::uploadPath().self::$imageFolder;

            if(!is_dir($logo_dir)) {
                mkdir($logo_dir, 0777);
                chmod($logo_dir, 0777);
            }
            $file_arr = explode('.', $_FILES['image2']['name']);
            $ext = end($file_arr);
            $destination_original = $logo_dir."/logo2.png";

            if(file_exists($destination_original)) {
                unlink($destination_original);
            }
            $img = new SimpleImage();
            $img->load($_FILES["image2"]["tmp_name"])->save($destination_original);

            $sql_img = self::$imageFolder.'/logo2.png';
            Database::get()->update($this->dataParams["cName"], ['logo2' => $sql_img], ['id' => $id]);
        }
    }



    protected function getBgUpload($id,$createStatus=false)
    {
        if(!empty($_FILES['bg_img_az']['tmp_name']) && Security::filterFileMimeTypes($_FILES['bg_img_az']['type']) && !empty($_FILES['bg_img_en']['tmp_name']) && Security::filterFileMimeTypes($_FILES['bg_img_en']['type']) && !empty($_FILES['bg_img_ru']['tmp_name']) && Security::filterFileMimeTypes($_FILES['bg_img_ru']['type'])) {

            $logo_dir = Url::uploadPath().self::$imageFolder;

            if(!is_dir($logo_dir)) {
                mkdir($logo_dir, 0777);
                chmod($logo_dir, 0777);
            }
            /*$file_arr_az = explode('.', $_FILES['bg_img_az']['name']);
            $file_arr_en = explode('.', $_FILES['bg_img_en']['name']);
            $file_arr_ru = explode('.', $_FILES['bg_img_ru']['name']);
            $ext_az = end($file_arr_az);
            $ext_en = end($file_arr_en);
            $ext_ru = end($file_arr_ru);*/

            $destination_original_az = $logo_dir."/bg_img_az.png";
            $destination_original_en = $logo_dir."/bg_img_ru.png";
            $destination_original_ru = $logo_dir."/bg_img_en.png";

            if(file_exists($destination_original_az)) {
                unlink($destination_original_az);
            }
            if(file_exists($destination_original_en)) {
                unlink($destination_original_en);
            }
            if(file_exists($destination_original_ru)) {
                unlink($destination_original_ru);
            }
            $img = new SimpleImage();
            $img->load($_FILES["bg_img_az"]["tmp_name"])->save($destination_original_az);
            $img->load($_FILES["bg_img_en"]["tmp_name"])->save($destination_original_en);
            $img->load($_FILES["bg_img_ru"]["tmp_name"])->save($destination_original_ru);

            $sql_img_az = self::$imageFolder.'/bg_img_az.png';
            $sql_img_en = self::$imageFolder.'/bg_img_en.png';
            $sql_img_ru = self::$imageFolder.'/bg_img_ru.png';
            Database::get()->update($this->dataParams["cName"], ['bg_img_az' => $sql_img_az,'bg_img_en' => $sql_img_en,'bg_img_ru' => $sql_img_ru], ['id' => $id]);
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