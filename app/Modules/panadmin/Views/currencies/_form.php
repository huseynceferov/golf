<?php
use Models\LanguagesModel;
use \Helpers\Url;
$languages = LanguagesModel::getLanguages();
$model = $data["model"];
?>
<div class="panel-body">
    <div class="row">
        <form action="" method="post">
            <div class="col-md-12">
                <ul class="nav nav-pills hidden">
                    <?php
                    foreach($languages as $language){
                        $li_class = '';
                        if($language["default"]) $li_class = 'active';
                        ?>
                        <li class="<?= $li_class?>"><a aria-expanded="false" href="#lang-<?= $language["name"]?>" data-toggle="tab"><?= $language["fullname"]?></a></li>
                    <?php }  ?>
                </ul>
                <div class="tab-content form-content"">
                    <?php
                    foreach($languages as $language){
                        $li_class = '';
                        if($language["default"]) $li_class = 'active in';
                        ?>
                        <div class="tab-pane fade <?= $li_class?>" id="lang-<?= $language["name"]?>">

                        </div>
                    <?php }  ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kursun adı</label>
                            <input class="form-control" name="fullname" value="<?=$model?$model["fullname"]:''?>">
                         </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kursun kodu</label>
                            <input class="form-control" name="name" value="<?=$model?$model["name"]:''?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kursun dəyəri</label>
                            <input class="form-control" name="rate" value="<?=$model?$model["rate"]:''?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="hidden" value="<?= \Helpers\Csrf::makeToken();?>" name="csrf_token">
                            <input type="submit" class="btn btn-success form-control" name="submit" value="Yadda saxla" />
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!-- /.row (nested) -->
</div>
<!-- /.panel-body -->
