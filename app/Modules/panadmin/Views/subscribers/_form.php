<?php
use Models\LanguagesModel;
$model = $data["model"];
$languages = LanguagesModel::getLanguages();
$defaultLanguage = LanguagesModel::getDefaultLanguage();

?>
<div class="panel-body">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <?php
                    foreach($languages as $language){
                        $li_class = '';
                        if($language["default"]) $li_class = 'active';
                        ?>
                        <li class="<?= $li_class?>"><a aria-expanded="false" href="#lang-<?= $language["name"]?>" data-toggle="tab"><?= $language["fullname"]?></a></li>
                    <?php }  ?>
                </ul>
                <div class="tab-content form-content">
                <?php
                foreach($languages as $language){
                    $li_class = '';
                    if($language["default"]) $li_class = 'active in';
                    ?>
                    <div class="tab-pane fade <?= $li_class?>" id="lang-<?= $language["name"]?>">
                        <div class="form-group">
                             <label for="title_az">Mətbəx adı</label>
                            <input class="form-control" id="title_az" name="title_<?= $language["name"]?>" value="<?=$model?$model["title_".$language["name"]]:''?>">
                         </div>
                    </div>
                <?php }  ?>

                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label for="status">Status </label>
                    <input class="switch_checkbox" type="checkbox" name="status" id="status" data-on-text="Aktiv" data-off-text="Deaktiv" value="1" <?php if($model && $model["status"]==0) echo ""; else echo "checked";?>>
                </div>

                <div class="form-group">
                    <input type="hidden" value="<?= \Helpers\Csrf::makeToken();?>" name="csrf_token">

                    <input type="submit" name="submit" value="Yadda saxla" class="btn btn-success pull-right">
                </div>
            </div>
    </div>
    </form>
</div>
<!-- /.row (nested) -->
</div>
<!-- /.panel-body -->
