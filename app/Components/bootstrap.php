<?php
use Core\Language;
use Models\LanguagesModel;
use Helpers\Database;
use Controllers\MyController;

$def_lng = LanguagesModel::defaultLanguage();
$contacts = Database::get()->selectOne("SELECT * FROM `contacts` ORDER  BY `id` DESC LIMIT 1");
$get_about = MyController::getAbout($def_lng);

$getMenus = MyController::getAllMenu();
$list_lang = LanguagesModel::getLanguages();

$language = new Language();
$language->load('app');