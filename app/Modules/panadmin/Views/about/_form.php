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
                    foreach ($languages as $language) {
                        $li_class = '';
                        if ($language["default"]) $li_class = 'active';
                        ?>
                        <li class="<?= $li_class ?>"><a aria-expanded="false" href="#lang-<?= $language["name"] ?>"
                                                        data-toggle="tab"><?= $language["fullname"] ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content form-content">
                    <?php
                    foreach ($languages as $language) {
                        $li_class = '';
                        if ($language["default"]) $li_class = 'active in';
                        ?>
                        <div class="tab-pane fade <?= $li_class ?>" id="lang-<?= $language["name"] ?>">
                            <div class="form-group">
                                <label for="title_<?= $language["name"] ?>">Заглавие (<?= $language["name"] ?>)</label>
                                <input class="form-control" id="title_<?= $language["name"] ?>" name="title_<?= $language["name"] ?>" value="<?= $model ? $model["title_" . $language["name"]] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="text_<?= $language["name"] ?>">Текст (<?= $language["name"] ?>)</label>
                                <textarea class="form-control editor" id="text_<?= $language["name"] ?>" name="text_<?= $language["name"] ?>"><?= $model ? $model["text_" . $language["name"]] : '' ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="desc_<?= $language["name"] ?>">Meta description (<?= $language["name"] ?>)</label>
                                <input class="form-control" id="desc_<?= $language["name"] ?>" name="desc_<?= $language["name"] ?>" value="<?= $model ? $model["desc_" . $language["name"]] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="key_<?= $language["name"] ?>">Meta keywords (<?= $language["name"] ?>)</label>
                                <input class="form-control" id="key_<?= $language["name"] ?>" name="key_<?= $language["name"] ?>" value="<?= $model ? $model["key_" . $language["name"]] : '' ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <input type="hidden" value="<?= \Helpers\Csrf::makeToken(); ?>" name="csrf_token">

                        <input type="submit" name="submit" value="Yadda saxla" class="btn btn-success pull-right">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row (nested) -->
</div>
<!-- /.panel-body -->
