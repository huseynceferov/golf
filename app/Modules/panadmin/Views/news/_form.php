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
                             <label for="title_az">Title (<?= $language["name"]?>)</label>
                            <input class="form-control" id="title_az" name="title_<?= $language["name"]?>" value="<?=$model?$model["title_".$language["name"]]:''?>">
                         </div>
                        <div class="form-group">
                            <label for="text_<?= $language["name"]?>">Text (<?= $language["name"]?>)</label>
                            <textarea class="form-control editor" id="text_<?= $language["name"]?>" rows="5" name="text_<?= $language["name"]?>"><?=$model?$model["text_".$language["name"]]:''?></textarea>
                        </div>
                    </div>
                <?php }  ?>
                    <hr>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image">
                </div>
                    <?php if($model): ?>
                <div class="form-group">
                    <img src="<?=\Helpers\Url::filePath().$model['thumb']?>">
                </div>
                <?php endif; ?>

                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label for="status">Status </label>
                    <input class="switch_checkbox" type="checkbox" name="status" id="status" data-on-text="Active" data-off-text="Inactive" value="1" <?php if($model && $model["status"]==0) echo ""; else echo "checked";?>>
                </div>

                <div class="form-group">
                    <input type="hidden" value="<?= \Helpers\Csrf::makeToken();?>" name="csrf_token">

                    <input type="submit" name="submit" value="Save" class="btn btn-success pull-right">
                </div>
            </div>
    </div>
    </form>
</div>
<!-- /.row (nested) -->
</div>
<!-- /.panel-body -->
