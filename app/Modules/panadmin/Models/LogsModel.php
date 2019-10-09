<?php

namespace Modules\panadmin\Models;

use Core\Model;
use Helpers\Database;
use Models\LanguagesModel;

class LogsModel extends Model{


    public static $tableName = 'logs';


    public static function getLogaction($action_id)
    {
        $get_action_info =Database::get()->selectOne("SELECT `title_az` FROM `log_actions` WHERE `id`='".$action_id."' ");
        return $get_action_info['title_az'];
    }


    public static function getAllLogActions()
    {
        $data = [0 => " - "];
        $defaultLang = LanguagesModel::getDefaultLanguage();
        $rows = Database::get()->select('SELECT `id`,`title_'.$defaultLang.'` FROM `log_actions`');
        foreach($rows as $row){
            $data[$row["id"]] = $row["title_".$defaultLang];
        }
        return $data;
    }



    public function __construct(){
        parent::__construct();
    }

}

?>