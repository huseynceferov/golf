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
                                <label for="working_days">İş günləri</label>
                                <input class="form-control" id="title_az" name="working_days_<?= $language["name"] ?>"
                                       value="<?= $model ? $model["working_days_" . $language["name"]] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="weekend_days">Qeyri iş günləri</label>
                                <input class="form-control" id="title_az" name="weekend_days_<?= $language["name"] ?>"
                                       value="<?= $model ? $model["weekend_days_" . $language["name"]] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Ünvan</label>
                                <input class="form-control" id="address" name="address_<?= $language["name"] ?>"
                                       value="<?= $model ? $model["address_" . $language["name"]] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="diff">Fərqimiz hissəsinin mətni</label>
                                <textarea class="form-control" id="diff" name="diff_<?= $language["name"] ?>"><?= $model ? $model["diff_" . $language["name"]] : '' ?></textarea>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="map">Xəritədə qeyd et</label>
                        <fieldset class="gllpLatlonPicker">
                            <input type="text" class="gllpSearchField">
                            <input type="button" class="gllpSearchButton" value="Axtar">
                            <br><br>
                            <div class="gllpMap"></div>
                            <input type="hidden" class="gllpLatitude" name="map_lat" value="<?= $model ? $model["map_lat"] : '0' ?>"/>
                            <input type="hidden" class="gllpLongitude" name="map_long" value="<?= $model ? $model["map_long"] : '0' ?>"/>
                            <input type="hidden" class="gllpZoom" value="15"/>
                        </fieldset>
                        <script>
                            $(document).ready(function() {
                                // Copy the init code from "jquery-gmaps-latlon-picker.js" and extend it here
                                $(".gllpLatlonPicker").each(function() {
                                    $obj = $(document).gMapsLatLonPicker();

                                    $obj.params.strings.markerText = "Drag this Marker (example edit)";

                                    $obj.params.displayError = function(message) {
                                        console.log("MAPS ERROR: " + message); // instead of alert()
                                    };

                                    $obj.init( $(this) );
                                });
                            });
                        </script>
                    </div>

                    <div class="form-group">
                        <label for="image">Logo</label>
                        <input type="file" id="image" name="image">
                    </div>
                    <?php if ($model): ?>
                        <div class="form-group">
                            <img src="<?= \Helpers\Url::filePath() . $model['logo'] ?>">
                        </div>
                    <?php endif; ?>


                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label for="image2">Logo2</label>
                        <input type="file" id="image2" name="image2">
                    </div>
                    <?php if ($model): ?>
                        <div class="form-group">
                            <img src="<?= \Helpers\Url::filePath() . $model['logo2'] ?>">
                        </div>
                    <?php endif; ?>


                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label for="home_tel">Qısa telefon nömrəsi</label>
                        <input class="form-control" id="home_tel" name="home_tel"
                               value="<?= $model ? $model["home_tel"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile_tel">Mobil telefon nömrəsi</label>
                        <input class="form-control" id="mobile_tel" name="mobile_tel"
                               value="<?= $model ? $model["mobile_tel"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="other_tel">Əlavə telefon nömrəsi</label>
                        <input class="form-control" id="other_tel" name="other_tel"
                               value="<?= $model ? $model["other_tel"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="fax">Faks</label>
                        <input class="form-control" id="fax" name="fax"
                               value="<?= $model ? $model["fax"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control" id="email" name="email"
                               value="<?= $model ? $model["email"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="facebook">Facebook səhifəsi</label>
                        <input class="form-control" id="facebook" name="facebook"
                               value="<?= $model ? $model["facebook"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter səhifəsi</label>
                        <input class="form-control" id="twitter" name="twitter"
                               value="<?= $model ? $model["twitter"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="google_plus">Google+ səhifəsi</label>
                        <input class="form-control" id="google_plus" name="google_plus"
                               value="<?= $model ? $model["google_plus"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram səhifəsi</label>
                        <input class="form-control" id="instagram" name="instagram"
                               value="<?= $model ? $model["instagram"] : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="linkedin">Linkedin səhifəsi</label>
                        <input class="form-control" id="linkedin" name="linkedin"
                               value="<?= $model ? $model["linkedin"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="youtube">Youtube səhifəsi</label>
                        <input class="form-control" id="youtube" name="youtube"
                               value="<?= $model ? $model["youtube"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">Whatsapp səhifəsi</label>
                        <input class="form-control" id="whatsapp" name="whatsapp"
                               value="<?= $model ? $model["whatsapp"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="vkontakte">Vkontakte səhifəsi</label>
                        <input class="form-control" id="vkontakte" name="vkontakte"
                               value="<?= $model ? $model["vkontakte"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="vimeo">Vimeo səhifəsi</label>
                        <input class="form-control" id="vimeo" name="vimeo"
                               value="<?= $model ? $model["vimeo"] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="pinterest">Pinterest səhifəsi</label>
                        <input class="form-control" id="pinterest" name="pinterest"
                               value="<?= $model ? $model["pinterest"] : '' ?>">
                    </div>

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
