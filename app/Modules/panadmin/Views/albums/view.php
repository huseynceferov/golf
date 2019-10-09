<?php
use \Helpers\OperationButtons;
use Models\LanguagesModel;
use Models\CategoriesModel;

$languages = LanguagesModel::getLanguages();
$defaultLang = LanguagesModel::getDefaultLanguage();
$categories = CategoriesModel::getCategories();
?>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <h3>Alboma bax</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills">
                            <?php
                            foreach ($languages as $language) {
                                $li_class = '';
                                if ($language["default"]) $li_class = 'active';
                                ?>
                                <li class="<?= $li_class ?>">
                                    <a aria-expanded="false" href="#lang-<?= $language["name"] ?>"
                                                                data-toggle="tab"><?= $language["fullname"] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content form-content">
                            <?php
                            foreach ($languages as $language):
                                $li_class = '';
                                if ($language["default"]) $li_class = 'active in';
                                ?>
                                <div class="tab-pane fade <?= $li_class ?>" id="lang-<?= $language["name"] ?>">
                                    <h5><b>Başlıq:</b> <?= $data['result']['title_' . $language['name']] ?></h5>
                                    <h5><b>Mətn:</b> <?= htmlspecialchars_decode($data['result']['text_' . $language['name']]) ?></h5>
                                </div>
                                <?php
                            endforeach;
                            if($data['result']['status']==0){$status='Deaktivdir';}else{$status='Aktivdir';}

                            ?>
                            <hr>
                            <h5><b>ID:</b> <?= $data['result']['id'] ?></h5>
                            <h5><b>Status:</b> <?= $status ?></h5>

                        </div>
                    </div>

                </div>
                <!-- /.row (nested) -->

                <?php
                if($data["issetAlbum"])
                    include dirname(__DIR__)."/photos/_photos.php";
                ?>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>

