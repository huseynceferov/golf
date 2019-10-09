<?php
use \Helpers\OperationButtons;
use Models\LanguagesModel;
use Models\CategoriesModel;

$languages = LanguagesModel::getLanguages();
$defaultLang = LanguagesModel::getDefaultLanguage();
$categories = CategoriesModel::getCategories();
?>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <h3>#<?= $data['result']['id'] ?> id-li loga baxış</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-content">
                            <?php
                            if($data['result']['status']==0){$status='Deaktivdir';}else{$status='Aktivdir';}
                            ?>
                            <h5><b>Istifadəçi İD:</b> <?= $data['result']['user_id']?></h5>
                            <h5><b>Istifadəçi email:</b> <?= \Modules\admin\Models\UsersModel::getuserinfo($data['result']["user_id"])['email'] ?></h5>
                            <h5><b>Object:</b> <?= $data['result']['object'] ?></h5>
                            <h5><b>Məbləğ:</b> <?= $data['result']['cost'] ?> Azn</h5>
                            <h5><b>Əməliyyat adı:</b> <?=\Modules\admin\Models\LogsModel::getLogaction($data['result']["action_id"])?></h5>
                            <h5><b>Tarix:</b> <?= $data['result']['dt'] ?></h5>
                            <h5><b>Statusu:</b> <?= $status ?></h5>

                        </div>
                    </div>

                </div>
                <!-- /.row (nested) -->

                <?php
                if($data["issetAlbum"])
                    include dirname(__DIR__)."/photos/_photos.php";
                ?>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>

