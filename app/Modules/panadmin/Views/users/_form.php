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
                <div class="tab-content form-content">

                <div class="form-group col-sm-12">
                    <label for="name">Adı</label>
                    <input class="form-control" id="name" name="name" value="<?=$model?$model["name"]:''?>">
                </div>
                <div class="form-group col-sm-12">
                    <label for="email">Email</label>
                    <input class="form-control" id="email" name="email" value="<?=$model?$model["email"]:''?>">
                </div>
                <div class="form-group col-sm-12">
                    <label for="bonus">Bonus</label>
                    <input class="form-control" id="bonus" name="bonus" value="<?=$model?$model["bonus"]:''?>">
                </div>
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
