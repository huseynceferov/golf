<?php
use Models\LanguagesModel;
$languages = LanguagesModel::getLanguages();
$log_actions = \Modules\admin\Models\LogsModel::getAllLogActions();
$values = $data['values'];

?>
<div class="panel panel-default search-box" style="<?php if($values['page']=='search'){ echo 'display:block;';} ?>">
    <div class="panel-heading">
        <i class="fa fa-search"></i> Axtarış
    </div>

    <div class="panel-body">
        <div class="row">
            <form action="search" method="get" id="partnerstats" accept-charset="utf-8">
                <div class="col-md-12">
                    <input type="hidden" id="from_date" name="from" value="<?=$values['from'];?>" />
                    <input type="hidden" id="to_date" name="to" value="<?=$values['to'];?>" />
                    <div class="tab-content form-content">
                        <div class="form-group col-md-3 range">
                            <label for="id">Tarix seç</label>
                            <input type="text" class="form-control" id="daterange">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="id">İstifadəçi ID</label>
                            <input class="form-control" name="user_id" id="user_id" value="<?=$values['user_id'];?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="category">Kateqoriya</label>
                            <select id="category" name="action_id" class="form-control">
                                <?php
                                foreach($log_actions as $key=>$val){
                                    if($values["action_id"]==$key) $selected='selected="selected"'; else $selected='';
                                    echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="aktiv">Status </label><br />
                            <input class="switch_checkbox" id="aktiv" type="checkbox" <?php if($values['page']=='search' && $values['status']==0){echo '';}else{echo 'checked';} ?> name="status" data-on-text="Aktiv" data-off-text="Deaktiv" value="1">
                        </div>

                        <div class="form-group">

                            <input type="submit" name="submit" value="Axtar" class="btn btn-primary pull-right">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.row (nested) -->
    </div>
    <!-- /.panel-body -->

    <!-- /.panel-body -->
</div>