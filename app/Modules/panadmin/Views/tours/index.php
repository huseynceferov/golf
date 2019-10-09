<?php
use \Helpers\Url;
use \Helpers\OperationButtons;
use \Helpers\Pagination;
use Models\LanguagesModel;
use Models\CategoriesModel;
$params = $data['dataParams'];
$pagination = $data["pagination"];
$values = $data["values"];

$defaultLang = LanguagesModel::getDefaultLanguage();
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <?= $params["cTitle"]; ?>
        </h3>
        <?php include "_search.php"; ?>
        <form action="<?php echo Url::to(MODULE_ADMIN."/".$params["cName"]."/operation")?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="pull-left padding-top-7 text-danger margin-right-10">
                        <b>Favorites: </b>
                    </p>

                    <button type="submit" name="delete" value="1" class="btn btn-sm btn-danger pull-left margin-right-10 delete_confirm"><i class="fa fa-times"></i> Delete</button>
                    <button type="submit" name="active" value="1" class="btn btn-sm btn-info pull-left margin-right-10"><i class="fa fa-check"></i> Activate</button>
                    <button type="submit" name="deactive" value="1" class="btn btn-sm btn-warning pull-left margin-right-10"><i class="fa fa-ban"></i> Deactivate</button>

                    <a class="btn  btn-sm btn-primary pull-right margin-right-10 search-box-link"><i class="fa fa-search"></i> Search</a>
                    <a href="<?php echo Url::to(MODULE_ADMIN."/".$params["cName"]."/create")?>" class="btn  btn-sm btn-success pull-right margin-right-10"><i class="fa fa-plus"></i> Add</a>
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
                                <th>Title</th>
                                <th>Photo</th>
                                <th class="width-20">Price</th>
                                <?php if($params["cPositionEnable"]){ ?><th class="width-20">Position</th><?php } ?>
                                <?php if($params["cStatusMode"]){ ?><th class="width-20">Status</th><?php } ?>
                                <?php if($params["cCrudMode"]){ ?><th class="width-20">Operations</th><?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data["rows"]  as $row){ ?>
                                <tr>
                                    <td class="width-20"><input type="checkbox" name="row_check[]" value="<?= $row["id"]; ?>"></td>
                                    <td><?= $row["id"]?></td>
                                    <td><?= $row["title_".$defaultLang]?></td>
                                    <td>
                                        <img class="image-field" src="<?= Url::filePath().$row["thumb"]?>"/>
                                    </td>
                                    <td><?= $row["price_".$defaultLang]?></td>

                                    <?php if($params["cPositionEnable"]){ ?>
                                        <td> <?= OperationButtons::getPositionIcons($row["id"],MODULE_ADMIN."/".$params["cName"])?></td>
                                    <?php } ?>
                                    <?php if($params["cStatusMode"]){ ?>
                                        <td> <?= OperationButtons::getStatusIcons($row["id"],$row["status"]); ?> </td>
                                    <?php } ?>
                                    <?php if($params["cCrudMode"]){ ?>
                                        <td> <?= OperationButtons::getCrudIcons($row["id"],MODULE_ADMIN."/".$params["cName"])?> </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>


                            </tbody>
                        </table>
                    <span class="text-info">
                        <?=Pagination::getCountData($pagination->countRows,$pagination->startRow,$pagination->limitRow);?>
                    </span>
                    <span class="pull-right">
                        <?= $pagination->getLimitSelector()?>
                    </span>
                        <div class="clearfix"></div>
                    </div>
                    <nav class="text-center">
                        <?= $pagination->pageNavigation();?>
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