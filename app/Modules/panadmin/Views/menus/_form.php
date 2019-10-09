<?php
use Models\LanguagesModel;
$model = $data["model"];
$languages = LanguagesModel::getLanguages();
$defaultLanguage = LanguagesModel::getDefaultLanguage();
$menus = \Modules\panadmin\Models\MenusModel::getMenus();
?>
<div class="panel-body">
    <div class="row">
        <form action="" method="post">
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
                                <label for="text">Text (<?= $language["name"]?>)</label>
                                <textarea class="form-control editor" id="editor" rows="5" name="text_<?= $language["name"]?>"><?=$model?$model["text_".$language["name"]]:''?></textarea>
                            </div>


                        </div>
                    <?php }  ?>

                    <div class="form-group">
                        <label for="url">Address (If it is a different site, type with http: //)</label>
                        <input class="form-control" id="url" name="url" value="<?=($model && array_key_exists("url",$model))?$model["url"]:''?>">
                    </div>

                    <h5><b>Menu type</b></h5>
                    <div class="form-group">
                        <?php foreach ($params["menuType"] as $key => $value): ?>
                            <?php
                            if(isset($model["menu_type"]) && $model["menu_type"] == $key) {
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }
                            ?>
                        <label class="radio-inline"><input type="radio" name="menu_type" value="<?=$key?>" <?=$checked?>><?=$value?></label>
                        <?php endforeach; ?>
                    </div>

                    <?php if($data["dataParams"]["posUp"] || $data["dataParams"]["posDown"]) { ?>
                    <div class="checkbox">
                        <h5><b>Menu location</b></h5>
                        <?php if($data["dataParams"]["posUp"]) {
                            if($model["up"] == 1) {
                                $checkedUp = 'checked';
                            } else {
                                $checkedUp = '';
                            }
                        ?>
                        <label class="checkbox-inline"><input type="checkbox" id="up" name="up" value="1" <?=$checkedUp?>>Up</label>
                        <?php } ?>

                        <?php if($data["dataParams"]["posDown"]) {
                            if($model["down"] == 1) {
                                $checkedDown = 'checked';
                            } else {
                                $checkedDown = '';
                            }
                            ?>
                        <label class="checkbox-inline"><input type="checkbox" id="down" name="down" value="1" <?=$checkedDown?>>Down</label>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="category">Menu</label>
                        <select name="parent_id" id="category" class="form-control">
                            <option value="0">Main menu</option>
                            <?php
                            foreach($data['menus'] as $key=>$val){
                                if($model && $model["parent_id"]==$key) $selected='selected="selected"'; else $selected='';
                                echo '<option value="'.$key.'" '.$selected.'>'.$val["title_".$defaultLanguage].'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label for="status">Status </label>
                        <input class="switch_checkbox" id="status" type="checkbox" name="status" data-on-text="Aktiv" data-off-text="Deaktiv" value="1" <?php if($model && $model["status"]==0) echo ""; else echo "checked";?>>
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
