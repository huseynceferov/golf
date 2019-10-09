<?php
use Models\LanguagesModel;
$model = $data["model"];
$languages = LanguagesModel::getLanguages();

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
                                <label for="subtitle_az">Qısa mətn</label>
                                <textarea class="form-control editor" id="editor" rows="5" name="subtitle_<?= $language["name"]?>"><?=$model?$model["subtitle_".$language["name"]]:''?></textarea>
                            </div>

                        </div>
                    <?php }  ?>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label for="image">Şəkil</label>
                        <input type="file" id="image" name="image">
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label for="link">Link (Əgər olacaqsa, http:// ilə yazın)</label>
                        <input type="text" class="form-control" name="link" id="link" placeholder="http://numune.com" value="<?=$model?$model["link"]:''?>">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="target" id="target" value="1" <?php if($model && $model["target"]==1) echo "checked"; else echo "";?>><b>Link yeni səhifədə açılsın</b></label>
                    </div>
                    <div class="form-group">
                        <label for="status">Status </label>
                        <input class="switch_checkbox" id="status" type="checkbox" name="status" data-on-text="Aktiv" data-off-text="Deaktiv" value="1" <?php if($model && $model["status"]==0) echo ""; else echo "checked";?>>
                    </div>
                    <hr />

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
