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
                        <b>Seçilmişləri: </b>
                    </p>

                    <button type="submit" name="delete" value="1" class="btn btn-sm btn-danger pull-left margin-right-10 delete_confirm"><i class="fa fa-times"></i> Sil</button>
                    <button type="submit" name="active" value="1" class="btn btn-sm btn-info pull-left margin-right-10"><i class="fa fa-check"></i> Aktiv et</button>
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
                                <th>İstifadəçi adı</th>
                                <th>Əlaqə nöm.</th>
                                <th>Email</th>
                                <th>Qazandığı bonus</th>
                                <th>Qeydiyyat tarixi</th>
                                <!--<th>Təsdiq</th>-->
                                <?php if($params["cPositionEnable"]){ ?><th class="width-20">Sıralama</th><?php } ?>
                                <?php if($params["cStatusMode"]){ ?><th class="width-20">Aktiv</th><?php } ?>
                                <?php if($params["cCrudMode"]){ ?><th class="width-20">Əməliyyatlar</th><?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data["rows"]  as $row){ ?>
                                <tr>
                                    <td class="width-20"><input type="checkbox" name="row_check[]" value="<?= $row["id"]; ?>"></td>
                                    <td><?= $row["id"]?></td>
                                    <td><?=$row['name']?></td>
                                    <td><?=$row['phone']?></td>
                                    <td><?=$row['email']?></td>
                                    <td><?=$row['bonus']?> azn</td>
                                    <td><?=date("d-m-Y H:i:s",$row['reg_date'])?></td>
                                    <!--<td class="text-center">
                                        <?php
/*                                        if($row['approve']==0){
                                            echo '<span class="uk-badge uk-badge-muted">Hesab təsdiqlənməyib</span>';
                                            echo '<br>
                                            <a href="/foodorder/admin/users/approved/'.$row['id'].'" class="btn btn-info btn-circle suc_bg" data-toggle="tooltip" data-placement="bottom" title="Təsdiqlə" style="margin-top: 10px;">
                                                <i class="fa fa-check" aria-hidden="true"></i>    
                                            </a>';
                                        }else{
                                            echo '<span class="uk-badge uk-badge-success">Hesab təsdiqlənib</span>';
                                            echo '<br>
                                            <a href="/foodorder/admin/users/pending/'.$row['id'].'" class="btn btn-info btn-circle mt_bg" data-toggle="tooltip" data-placement="bottom" title="Təsdiqlənməyib" style="margin-top: 10px;">
                                                <i class="fa fa-ban" aria-hidden="true"></i>    
                                            </a>';
                                        }
                                        */?>
                                    </td>-->

                                    <?php if($params["cPositionEnable"]){ ?>
                                        <td> <?= OperationButtons::getPositionIcons($row["id"],MODULE_ADMIN."/".$params["cName"])?></td>
                                    <?php } ?>
                                    <?php if($params["cStatusMode"]){ ?>
                                        <td> <?= OperationButtons::getStatusIcons($row["id"],$row["status"]); ?> </td>
                                    <?php } ?>
                                    <?php if($params["cCrudMode"]){ ?>
                                        <td class="text-center"> <?= OperationButtons::getCrudIcons($row["id"],MODULE_ADMIN."/".$params["cName"],'no_view')?> </td>
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