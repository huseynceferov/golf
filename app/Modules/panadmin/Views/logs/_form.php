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
                                <label for="title_az">Başlıq</label>
                                <input class="form-control" id="title_az" name="title_<?= $language["name"]?>" value="<?=$model?$model["title_".$language["name"]]:''?>">
                            </div>
                            <div class="form-group">
                                <label for="text">Qısa mətn</label>
                                <textarea class="form-control " id="editor" rows="5" name="short_text_<?= $language["name"]?>"><?=$model?$model["short_text_".$language["name"]]:''?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="text">Tam mətn</label>
                                <textarea class="form-control editor" id="editor" rows="5" name="text_<?= $language["name"]?>"><?=$model?$model["text_".$language["name"]]:''?></textarea>
                            </div>


                        </div>
                    <?php }  ?>
                    <div class="form-group">
                        <label for="category">Kateqoriya</label>
                        <select name="category_id" id="category" class="form-control">
                            <?php

                            foreach($data["categories"] as $category){
                                if($model && $model["category_id"]==$category["id"]) $selected='selected="selected"'; else $selected='';
                                echo '<option value="'.$category["id"].'" '.$selected.'>'.$category["title_".$defaultLanguage].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Şəkil</label>
                        <input type="file" id="image" name="image">
                    </div>
                    <?php if($model): ?>
                        <div class="form-group">
                            <img src="<?=\Helpers\Url::filePath().$model['thumb']?>">
                        </div>
                    <?php endif; ?>

                    <div class="form-group col-md-4 row">
                        <label for="datetimepicker1">Tarix</label>
                        <div class='input-group date form-control'>
                            <input type='datetime' id="datetimepicker1" name="news_time" class="datetimepicker form-control" value="<?= $model?date("d/m/Y H:i",$model["news_time"]):date("d/m/Y H:i");?>" />
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label for="keyword">Açar sözlər</label>
                        <input class="form-control" id="keyword" name="tags" value="<?=$model?$model["tags"]:''?>">
                    </div>
                    <div class="form-group">
                        <label for="meta_description">Meta açıqlama</label>
                        <input class="form-control" name="meta_description" id="meta_description" value="<?=$model?$model["meta_description"]:''?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="flash_status">Manşet</label>
                        <input class="switch_checkbox" type="checkbox" name="flash_status" id="flash_status" data-on-text="Göstər" data-off-text="Göstərmə" value="1" <?php if($model && $model["status"]==1) echo "checked"; else echo "";?>>
                    </div>
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
