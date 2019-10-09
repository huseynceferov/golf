<?php
use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

$hooks = Hooks::get();
$get_url_im = \Helpers\Url::getFullUrl();

global $language;
global $def_lng;
global $foot_menu;

?>
<?php eval($content); ?>

