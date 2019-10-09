<?php
use \Helpers\Url;
use \Helpers\OperationButtons;
use Models\LanguagesModel;
$params = $data['dataParams'];
$values = $data["values"];

$defaultLang = LanguagesModel::getDefaultLanguage();
$categories = \Models\CategoriesModel::getCategories();
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <?=$params["cTitle"]; ?>
        </h3>
        <?php include "_search.php"; ?>

        <form action="<?php echo Url::to(MODULE_ADMIN."/".$params["cName"]."/operation")?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="pull-left padding-top-7 text-danger margin-right-10">
                        <b>Seçilmişləri: </b>
                    </p>

                    <button type="submit" name="delete" value="1" class="btn btn-sm btn-danger  pull-left margin-right-10 delete_confirm"><i class="fa fa-times"></i> Sil</button>
                    <button type="submit" name="active" value="1" class="btn btn-sm btn-info  pull-left margin-right-10"><i class="fa fa-check"></i> Aktiv et</button>
                    <button type="submit" name="deactive" value="1" class="btn btn-sm btn-warning pull-left margin-right-10"><i class="fa fa-ban"></i> Deaktiv et</button>

                    <a class="btn  btn-sm btn-primary pull-right margin-right-10 search-box-link"><i class="fa fa-search"></i> Axtarış</a>
                    <div class="clearfix"></div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="width-20"><input type="checkbox" class="all-check"></th>
                                <th class="width-20">#</th>
                                <th>Istifadəçi (İD,email)</th>
                                <th>Object</th>
                                <th>Əməliyyat adı</th>
                                <th>Məbləğ</th>
                                <th>Tarix</th>
                                <?php if($params["cPositionEnable"]){ ?><th class="width-20">Sıralama</th><?php } ?>
                                <?php if($params["cCrudMode"]){ ?><th class="width-20">Əməliyyatlar</th><?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data["rows"]  as $row){ ?>
                                <tr>
                                    <td class="width-20"><input type="checkbox" name="row_check[]" value="<?= $row["id"]; ?>"></td>
                                    <td><?= $row["id"]?></td>
                                    <td>ID:<?= $row["user_id"].'<br>Email:'.\Modules\admin\Models\UsersModel::getuserinfo($row["user_id"])['email']?></td>
                                    <td><?= $row["object"]?></td>
                                    <td><?= \Modules\admin\Models\LogsModel::getLogaction($row["action_id"])?></td>
                                    <td><?= $row["cost"]?> Azn</td>
                                    <td><?= $row["dt"]?></td>

                                    <?php if($params["cPositionEnable"]){ ?>
                                        <td> <?= OperationButtons::getPositionIcons($row["id"],MODULE_ADMIN."/".$params["cName"])?></td>
                                    <?php } ?>
                                    <?php if($params["cCrudMode"]){ ?>
                                        <td> <?= OperationButtons::getCrudView($row["id"],MODULE_ADMIN."/".$params["cName"])?> </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>


                            </tbody>
                        </table>
                        <span class="text-info">
                        <?php //=Pagination::getCountData($pagination->countRows,$pagination->startRow,$pagination->limitRow);?>
                    </span>
                        <span class="pull-right">
                        <?php //= $pagination->getLimitSelector()?>
                    </span>
                        <div class="clearfix"></div>
                    </div>
                    <nav class="text-center">
                        <?php //= $pagination->pageNavigation();?>
                    </nav>

                    <div class="clearfix"></div>
                </div>


                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
    </div>
    </form>
</div>
</div>