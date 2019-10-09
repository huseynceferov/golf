<?php
/**
 * Breadcrumbs static helper
*/

namespace Helpers;


class Breadcrumbs
{
    public static function getBreadCrumbs($array = [])
    {
        $return = '<ol class="breadcrumb pull-right">';
        $return .= '<li><a href="'.Url::to(MODULE_ADMIN).'">İdarə paneli</a></li>';

        $count = count($array);
        $i = 1;
        foreach($array as $key=>$val){
            $active = '';
            if($count==$i) $return.='<li class="active">'.$val.'</li>';
            else $return.='<li><a href="'.$key.'">'.$val.'</a></li>';
            $i++;
        }
        $return.='</ol>';
        return $return;
    }
}
