<?php
use Models\LanguagesModel;
$model = $data["model"];
$languages = LanguagesModel::getLanguages();
$defaultLanguage = LanguagesModel::getDefaultLanguage();
$categories = \Models\CategoriesModel::getCategories();

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
                            <div class="form-group col-md-12">
                                <label for="title_az">Başlıq</label>
                                <input class="form-control" id="title_az" name="title_<?= $language["name"]?>" value="<?=$model?$model["title_".$language["name"]]:''?>">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="text">Tam mətn</label>
                                <textarea class="form-control" id="text" rows="5" name="text_<?= $language["name"]?>"><?=$model?$model["text_".$language["name"]]:''?></textarea>
                            </div>


                        </div>
                    <?php }  ?>
                    <div class="form-group col-md-12">
                        <label for="category">Kateqoriya</label>
                        <select name="parent_id" id="category" class="form-control">
                            <option value="0">Ana kateqoriya</option>
                            <?php
                            foreach($data['categories'] as $key=>$val){
                                if($model && $model["parent_id"]==$key) $selected='selected="selected"'; else $selected='';
                                echo '<option value="'.$key.'" '.$selected.'>'.$val["title_".$defaultLanguage].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label for="category">Açılış vaxtı</label>
                            <div class='input-group date' id='datetimepicker3'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label for="category">Qapanış vaxtı</label>
                            <div class='input-group date' id='datetimepicker4'>
                                <input type='text' class="form-control" name=""/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-12">
                        <label for="status">Status </label>
                        <input class="switch_checkbox" id="status" type="checkbox" name="status" data-on-text="Aktiv" data-off-text="Deaktiv" value="1" <?php if($model && $model["status"]==0) echo ""; else echo "checked";?>>
                    </div>

                    <div class="form-group col-md-12">
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
