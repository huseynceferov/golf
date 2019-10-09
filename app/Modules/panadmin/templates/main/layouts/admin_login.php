<?php
use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?=MODULE_ADMIN_TITLE;?></title>
    <?php 
    Assets::css([
        Url::templateModulePath() . 'css/bootstrap.min.css',
        Url::templateModulePath() . 'css/metisMenu.min.css',
        Url::templateModulePath() . 'css/sb-admin-2.css',
        Url::templateModulePath() . 'css/font-awesome.min.css',
        Url::templateModulePath() . 'css/custom.css',
    ]);
    $hooks->run("css");
    ?>
</head>
<body>
<div class="container">

    <?php eval($content)?>
</div>
<?php
Assets::js([
    Url::templateModulePath()  . 'js/jquery.min.js',
    Url::templateModulePath()  . 'js/bootstrap.min.js',
    Url::templateModulePath()  . 'js/metisMenu.min.js',
    Url::templateModulePath()  . 'js/sb-admin-2.js',
    Url::templateModulePath()  . 'js/script_coders.js',
]);
$hooks->run('js');
?>
</body>
</html>