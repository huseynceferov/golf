<?php

namespace Helpers;


class OperationButtons
{
    public static function getPositionIcons($id,$path)
    {
        return '<div class="operation-buttons">
                    <a href="'.Url::to($path."/up/".$id).'" class="btn btn-success btn-circle">
                        <i class="glyphicon glyphicon-arrow-up"></i>
                    </a>
                    <a href="'.Url::to($path."/down/".$id).'" class="btn btn-warning btn-circle">
                        <i class="glyphicon glyphicon-arrow-down "></i>
                    </a>
                </div>';
    }

    public static function getStatusIcons($id,$status,$readOnly=''){
        if($status==1) $checked='checked'; else $checked='';
        if(intval($readOnly)==1) $readOnly='readOnly';
        return '<input type="checkbox" class="switch_checkbox" onchange="statusChange('.$id.');" name="my-checkbox" '.$readOnly.' data-size="small" data-on-text="On" data-off-text="Off" value="'.$id.'" '.$checked.'  />';
    }

    public static function getCrudIcons($id,$path,$sel='')
    {
        if($sel=='delete'){
            return '<div class="operation-buttons">
                <a href="'.Url::to($path."/delete/".$id).'" class="btn btn-danger btn-circle delete_confirm" data-toggle="tooltip" data-placement="bottom" title="Delete">
                    <i class="fa fa-times"></i>
                </a>
            </div>';
        }elseif($sel=='no_view'){
            return '<div class="operation-buttons">
                <a href="'.Url::to($path."/update/".$id).'" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Update">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
                <a href="'.Url::to($path."/delete/".$id).'" class="btn btn-danger btn-circle delete_confirm" data-toggle="tooltip" data-placement="bottom" title="Delete">
                    <i class="fa fa-times"></i>
                </a>
            </div>';
        }elseif($sel=='edit'){
            return '<div class="operation-buttons">
                <a href="'.Url::to($path."/update/".$id).'" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Update">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </div>';
        }
        else{
            return '<div class="operation-buttons">
                <a href="'.Url::to($path."/view/".$id).'" class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="bottom" title="View">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
                <a href="'.Url::to($path."/update/".$id).'" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Update">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
                <a href="'.Url::to($path."/delete/".$id).'" class="btn btn-danger btn-circle delete_confirm" data-toggle="tooltip" data-placement="bottom" title="Delete">
                    <i class="fa fa-times"></i>
                </a>
            </div>';
        }

    }


    public static function getCrudView($id,$path)
    {
        return '<div class="operation-buttons">
                    <a href="'.Url::to($path."/view/".$id).'" class="btn btn-info btn-circle">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>
                </div>';
    }


}
