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
use Modules\panadmin\Models\AlbumsModel as TableModel;
use Models\LanguagesModel;
use Core\View;
use Helpers\Url;
use Modules\panadmin\Models\AlbumsModel;

class Photos extends MyController
{

    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable=true;     // Siralama aktiv, deaktiv
    public static $positionOrderBy  = 'DESC'; // Siralama ucun order
    public static $positionCondition = true;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['row_id','table_name']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // emeliyyatlar bolmesinin gorsenib gorsenmemesi (operations) fields

    public static $issetImage = true;
    public static $requiredImage = true;
    public static $imageFolder = 'photos';
    public static $issetAlbum = false;

    public static $tableNamePhotos = 'photos';

    public $operation;


    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" => "photos",
            "cModelName" => "PhotosModel",
            "cTitle" => "Fotolar",
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


    public function status($id)
    {
        $model = $this->operation->findModel($id);
        $status = $model["status"]==1?0:1;
        $this->operation->statusModel([$id],$status);
        Url::redirect("admin/".$model["table_name"]."/view/".$model["row_id"]."#gallery-block");
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


    /*
     * for gallery photos
     * */

    public function upload()
    {
        if(isset($_POST["submit"]) && Csrf::isTokenValid() ){
            $table_name = Security::safe($_POST["table_name"]);
            $photo_title = Security::safe($_POST['title_az']);
            if(!is_dir(Url::uploadPath().$table_name)) {
                File::makeDir(Url::uploadPath().$table_name);
            }
            $row_id = intval($_POST["row_id"]);
            if($row_id>0 and $table_name!=""){
                if(!empty($_FILES['image']['tmp_name']) and Security::filterFileMimeTypes($_FILES['image']['type'])) {
                    $image_path = 'photos/'.$table_name.'/'.date("Y-m").'/images/';
                    $thumb_path = 'photos/'.$table_name.'/'.date("Y-m").'/thumbs/';

                    $new_dir = Url::uploadPath().$image_path;
                    $new_thumb_dir = Url::uploadPath().$thumb_path;

                    if(File::makeDir($new_dir) and File::makeDir($new_thumb_dir)){
                        $file_arr = explode('.', $_FILES['image']['name']);
                        $ext = end($file_arr);
                        $file_name = $row_id."_".time().rand(10,99);

                        $destination_original = $new_dir. $file_name.".".$ext;
                        $destination_thumb = $new_thumb_dir.$file_name.".".$ext;

                        $img = new SimpleImage();
                        $img->load($_FILES["image"]["tmp_name"])->resize(571, 376)->save($destination_original);
                        $img->load($_FILES["image"]["tmp_name"])->resize(62, 62)->save($destination_thumb);

                        $image_sql = $image_path.$file_name.".".$ext;
                        $thumb_sql = $thumb_path.$file_name.".".$ext;

                        $insert = Database::get()->insert('photos', ['title_az' => $photo_title, 'image' => $image_sql, 'thumb' => $thumb_sql,'table_name' => $table_name,'row_id'=>$row_id,'status' => 1]);
                        $position = $this->operation->getPositionForNew($insert,'up',true);

                        Session::setFlash('success','Şəkil əlavə olundu');

                    }else{
                        Session::setFlash('error','Qovluq yaranmadi');
                    }

                }else{
                    Session::setFlash('error','Xəta baş verdi');
                }
                Url::redirect("admin/".$table_name."/view/".$row_id."#gallery-block");

            }else{
                Session::setFlash('error','Xəta baş verdi');
            }

        }else{
            Session::setFlash('error','Xəta baş verdi');
        }

        Url::redirect("admin/main");
    }

    public function position($id,$direction)
    {
        if(!in_array($direction,["up","down"])){
            Url::redirect("admin/main");
        }

        $row = $this->findImage($id);
        if($row){
            $this->operation->move($id,$direction);
            Url::redirect("admin/".$row["table_name"]."/view/".$row["row_id"]."#gallery-block");
        }else{
            Url::redirect("admin/main");
        }
    }


    public function imagedelete($id)
    {
        $row = $this->findImage($id);
        if($row){
            unlink(Url::uploadPath().$row["image"]);
            unlink(Url::uploadPath().$row["thumb"]);
            Database::get()->delete($this->dataParams["cName"],["id" => $row["id"]]);
            Url::redirect("admin/".$row["table_name"]."/view/".$row["row_id"]."#gallery-block");
        }else{
            Url::redirect("admin/main");
        }
    }

    public static function deletePhotos($tableName, $id)
    {
        $get_photos = AlbumsModel::getPhotos($tableName, $id);
        foreach($get_photos as $photo) {
            unlink(Url::uploadPath().$photo['image']);
            unlink(Url::uploadPath().$photo['thumb']);
            Database::get()->delete(self::$tableNamePhotos, ['id' => $photo["id"]]);
        }

        return true;
    }

    protected function findImage($id)
    {
        if(!isset($id) || intval($id)==0){
            Session::setFlash('error','Səhifə tapılmadı');
            return false;
        }else{
            $row = Database::get()->selectOne('SELECT * FROM '.$this->dataParams["cName"].' WHERE id=:id',[':id' => $id]);
            if(!$row){
                Session::setFlash('error','Məlumat tapılmadı');
                return false;
            }else{
                return $row;
            }
        }
    }




}