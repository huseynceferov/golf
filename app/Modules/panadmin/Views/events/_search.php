<?php
use Models\LanguagesModel;
$languages = LanguagesModel::getLanguages();
$categories = \Models\CategoriesModel::getCategories();
$values = $data['values'];
?>
<div class="panel panel-default search-box" style="<?php if($values['page']=='search'){ echo 'display:block;';} ?>">
    <div class="panel-heading">
        Axtarış
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <form role="form" action="search" method="get">
                    <div class="tab-content form-content">
                        <div class="form-group col-md-3">
                            <label for="id">ID</label>
                            <input class="form-control" name="id" id="id" value="<?=$values['id']?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="title_az">Başlıq</label>
                            <input class="form-control" name="title_az" id="title_az" value="<?=$values['title_'.$defaultLang]?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="category">Kateqoriya</label>
                            <select id="category" name="category_id" class="form-control">
                                <?php
                                foreach($categories as $key=>$val){
                                    if($values["category_id"]==$key) $selected='selected="selected"'; else $selected='';
                                    echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="aktiv">Status </label><br />
                            <input class="switch_checkbox" id="aktiv" type="checkbox" <?php if($values['page']=='search' && $values['status']==0){echo '';}else{echo 'checked';} ?> name="status" data-on-text="Aktiv" data-off-text="Deaktiv" value="1">
                        </div>

                        <div class="form-group col-md-12">

                            <input type="submit" name="submit" value="Axtar" class="btn btn-primary pull-right">
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col-lg-6 (nested) -->

            <!-- /.col-lg-6 (nested) -->
        </div>
        <!-- /.row (nested) -->
    </div>
    <!-- /.panel-body -->
</div>