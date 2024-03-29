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

class Albums extends MyController
{

    public static $safeMode = false;  // silinmemeli olan rowlarin mudafieso
    public static $safeModeFields = ["safe_mode"]; // siline bilmeyen rowlarin nezere alinmali fieldi

    public static $positionEnable = true;     // Siralama aktiv, deaktiv
    public static $positionOrderBy = 'DESC'; // Siralama ucun order
    public static $positionCondition = false;    // siralanma zamani nezere alinacaq fieldlerin olub olmamasi
    public static $positionConditionField = ['parent_id']; // siralanma zamani nezere alinacaq fieldler

    public static $statusMode = true; // Melumatlarin aktiv deaktiv edile bilmesi (status) field
    public static $crudMode = true; // emeliyyatlar bolmesinin gorsenib gorsenmemesi (operations) fields

    public static $issetImage = true;
    public static $requiredImage = true;
    public static $imageFolder = 'albums';
    public static $issetAlbum = true;


    public static $photosTable = 'photos';
    public $operation;


    public $dataParams = [
    ];

    public function getDataParams()
    {
        $this->dataParams = [
            "cName" => "albums",
            "cModelName" => "AlbumsModel",
            "cTitle" => "Albomlar",
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

        $pagination = new Pagination();
        $limitSql = $pagination->getLimitSql($countRows);
        $orderBy = $this->operation->getOrderBy();
        $rows = Database::get()->select("SELECT * FROM " . $this->dataParams["cName"] . " ORDER BY " . $orderBy . $limitSql);

        View::renderModule($this->dataParams["cName"] . '/index', [
            'dataParams' => $this->getDataParams(),
            'rows' => $rows,
            'pagination' => $pagination,
        ]);
    }

    public function create()
    {
        $model = false;
        if (isset($_POST["submit"]) && Csrf::isTokenValid()) {
            $postArray = $this->getPost('create');
            $postArray["create_time"] = time();

            $model = $postArray;
            $rules = TableModel::rules();
            $rules['image'][] = 'required_file';
            $rules['image'][] = 'image_mime_types(png-jpeg-gif-jpg)';
            $validator = SimpleValidator::validate(array_merge($postArray, $_FILES), $rules, TableModel::naming());

            if ($validator->isSuccess()) {
                $insert = Database::get()->insert($this->dataParams["cName"], $postArray);
                if ($insert) {
                    if (self::$issetImage)
                        $this->getImageUpload($insert, true);

                    if (self::$positionEnable)
                        $position = $this->operation->getPositionForNew($insert, 'up', true);

                    Session::setFlash('success', 'Məlumatlar yadda saxlanıldı');
                    return Url::redirect(MODULE_ADMIN . "/" . $this->dataParams["cName"]);
                } else {
                    Session::setFlash('error', 'Xəta baş verdi(DB)');
                }
            } else {
                $msg = '';
                foreach ($validator->getErrors() as $error) {
                    $msg .= $error . "<BR />";
                }
                Session::setFlash('error', $msg);
            }

        }

        View::renderModule($this->dataParams["cName"] . '/create', [
            'dataParams' => $this->getDataParams(),
            'model' => $model,
        ]);

    }


    public function update($id)
    {
        $model = $this->operation->findModel($id);
        $defaultLang = LanguagesModel::getDefaultLanguage();

        if (isset($_POST["submit"]) && Csrf::isTokenValid()) {
            $postArray = $this->getPost('update');
            $model = $postArray;

            $rules = TableModel::rules();
            $validator = SimpleValidator::validate($postArray, $rules, TableModel::naming());

            if ($validator->isSuccess()) {

                $update = Database::get()->update($this->dataParams["cName"], $postArray, ["id" => $id]);

                if ($update or self::$issetImage) {
                    if (self::$issetImage)
                        $this->getImageUpload($id);

                    Session::setFlash('success', 'Məlumatlar yadda saxlanıldı');
                    return Url::redirect(MODULE_ADMIN . "/" . $this->dataParams["cName"]);
                } else {
                    Session::setFlash('error', 'Heç bir məlumat dəyişdirilməyib (DB)');
                }
            } else {
                $msg = '';
                foreach ($validator->getErrors() as $error) {
                    $msg .= $error . "<BR />";
                }
                Session::setFlash('error', $msg);
            }

        }

        View::renderModule($this->dataParams["cName"] . '/update', [
            'dataParams' => $this->getDataParams(),
            'model' => $model,
        ]);
    }


    protected function getImageUpload($id, $createStatus = false)
    {
        if (!empty($_FILES['image']['tmp_name']) and Security::filterFileMimeTypes($_FILES['image']['type'])) {

            $new_dir = Url::uploadPath() . self::$imageFolder . '/' . $id;
            $new_thumb_dir = Url::uploadPath() . self::$imageFolder . '/' . $id . '/thumbs';

            if ($createStatus) {
                mkdir($new_dir);
                chmod($new_dir, 0777);

                mkdir($new_thumb_dir);
                chmod($new_thumb_dir, 0777);
            }

            $file_arr = explode('.', $_FILES['image']['name']);
            $ext = end($file_arr);
            $destination_original = $new_dir . "/" . $id . "_0." . $ext;
            $destination = $new_thumb_dir . "/" . $id . "_0." . $ext;


            $img = new SimpleImage();
            $img->load($_FILES["image"]["tmp_name"])->save($destination_original);
            $img->load($_FILES["image"]["tmp_name"])->resize(320, 239)->save($destination);

            $sql_img = self::$imageFolder . '/' . $id . '/' . $id . "_0." . $ext;
            $sql_thumb_img = self::$imageFolder . '/' . $id . '/thumbs/' . $id . "_0." . $ext;
            Database::get()->update($this->dataParams["cName"], ['image' => $sql_img, 'thumb' => $sql_thumb_img], ['id' => $id]);
        }
    }

    public function view($id)
    {
        $model = $this->operation->findModel($id);
        $photos = [];
        if (self::$issetAlbum) {
            $photos = AlbumsModel::getPhotos($this->dataParams["cName"], $id);
        }
        View::renderModule($this->dataParams["cName"] . '/view', [
            'dataParams' => $this->getDataParams(),
            'result' => $model,
            'defaultLang' => $this->defaultLanguage(),
            'photos' => $photos,
            'issetAlbum' => self::$issetAlbum
        ]);
    }

    protected function getPost($action = 'create')
    {
        $languages = LanguagesModel::getLanguages();
        $defaultLang = $this->defaultLanguage();
        extract($_POST);
        $array = [];
        foreach ($languages as $lang) {
            $text = "text_" . $lang["name"];
            $array[$text] = Security::safe($$text);

            $title = "title_" . $lang["name"];
            $array[$title] = Security::safe($$title);
        }
        $array["status"] = Security::safe($status);

        return $array;
    }


    public function deleteImage($id)
    {
        if (is_dir(Url::uploadPath() . self::$imageFolder . '/' . $id)) {
            File::rmDir(Url::uploadPath() . self::$imageFolder . '/' . $id);
        }

        return true;
    }

    public function delete($id)
    {
        $model = $this->operation->findModel($id);

        if (self::$issetImage) $this->deleteImage($id);
        if (self::$issetAlbum) Photos::deletePhotos($this->dataParams['cName'], $id);

        $this->operation->deleteModel([$id]);
        return Url::previous(MODULE_ADMIN . "/" . $this->dataParams["cName"]);
    }

    public function up($id)
    {
        $this->operation->move($id, 'up');
        return Url::previous(MODULE_ADMIN . "/" . $this->dataParams["cName"]);
    }

    public function down($id)
    {
        $this->operation->move($id, 'down');
        return Url::previous(MODULE_ADMIN . "/" . $this->dataParams["cName"]);
    }

    public function status($id)
    {
        $model = $this->operation->findModel($id);
        $status = $model["status"] == 1 ? 0 : 1;
        $this->operation->statusModel([$id], $status);
        return Url::previous(MODULE_ADMIN . "/" . $this->dataParams["cName"]);
    }

    public function operation()
    {
        if (isset($_POST["row_check"])) {
            if (isset($_POST["delete"])) {
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
            } elseif (isset($_POST["active"])) {
                $row_check = $_POST["row_check"];
                $this->operation->statusModel($row_check, 1);
            } elseif (isset($_POST["deactive"])) {
                $row_check = $_POST["row_check"];
                $this->operation->statusModel($row_check, 0);
            }
        } else {
            Session::setFlash('error', 'Seçim edilməyib');

        }


        return Url::previous(MODULE_ADMIN . "/" . $this->dataParams["cName"]);

    }


    /*
     * for gallery photos
     * */

    public function upload()
    {
        if (isset($_POST["submit"]) && Csrf::isTokenValid()) {
            $table_name = Security::safe($_POST["table_name"]);
            $row_id = intval($_POST["row_id"]);
            if ($row_id > 0) {
                if (!empty($_FILES['image']['tmp_name']) and Security::filterFileMimeTypes($_FILES['image']['type'])) {
                    $image_path = 'photos/' . $table_name . '/' . date("Y-m") . '/images/';
                    $thumb_path = 'photos/' . $table_name . '/' . date("Y-m") . '/thumbs/';

                    $new_dir = Url::uploadPath() . $image_path;
                    $new_thumb_dir = Url::uploadPath() . $thumb_path;

                    if (File::makeDir($new_dir) and File::makeDir($new_thumb_dir)) {
                        $file_arr = explode('.', $_FILES['image']['name']);
                        $ext = end($file_arr);
                        $file_name = $row_id . "_" . time() . rand(10, 99);

                        $destination_original = $new_dir . $file_name . "." . $ext;
                        $destination_thumb = $new_thumb_dir . $file_name . "." . $ext;

                        $img = new SimpleImage();
                        $img->load($_FILES["image"]["tmp_name"])->save($destination_original);
                        $img->load($_FILES["image"]["tmp_name"])->resize(320, 239)->save($destination_thumb);

                        $image_sql = $image_path . $file_name . "." . $ext;
                        $thumb_sql = $thumb_path . $file_name . "." . $ext;

                        Database::get()->insert('photos', ['image' => $image_sql, 'thumb' => $thumb_sql, 'table_name' => $table_name, 'row_id' => $row_id, 'status' => 1]);
                        Url::redirect("admin/" . $table_name . "/view/" . $row_id . "#gallery-block");
                    } else {
                        echo "file yoxdu";
                    }

                } else {
                    echo "tmp name yoxdu";
                }
            } else {
                echo "row_id yoxdu";
            }

        } else {
            echo "Token valid deyil";
        }
    }

    public function position($id, $direction)
    {
        if (!in_array($direction, ["up", "down"])) {
            Url::redirect("admin/main");
        }


        $row = $this->findImage($id);
        if ($row) {

            Database::get()->delete(self::$photosTable, ["id" => $row["id"]]);
            Url::redirect("admin/" . $row["table_name"] . "/view/" . $row["row_id"] . "#gallery-block");
        } else {
            Url::redirect("admin/main");
        }
    }


    public function imagedelete($id)
    {
        $row = $this->findImage($id);
        if ($row) {
            unlink(Url::uploadPath() . $row["image"]);
            unlink(Url::uploadPath() . $row["thumb"]);
            Database::get()->delete(self::$photosTable, ["id" => $row["id"]]);
            Url::redirect("admin/" . $row["table_name"] . "/view/" . $row["row_id"] . "#gallery-block");
        } else {
            Url::redirect("admin/main");
        }
    }

    protected function findImage($id)
    {
        if (!isset($id) || intval($id) == 0) {
            Session::setFlash('error', 'Səhifə tapılmadı');
            return false;
        } else {
            $row = Database::get()->selectOne('SELECT * FROM ' . self::$photosTable . ' WHERE id=:id', [':id' => $id]);
            if (!$row) {
                Session::setFlash('error', 'Məlumat tapılmadı');
                return false;
            } else {
                return $row;
            }
        }
    }


}