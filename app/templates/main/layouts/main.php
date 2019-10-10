<?php
use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

$hooks = Hooks::get();
$get_url_im = Url::getFullUrl();

global $language;
global $contacts;
global $def_lng;
global $list_lang;
global $getMenus;
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>
    <title><?php echo $data['title']; ?></title>
	<base href="<?=DIR?>" />
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Golf in Azerbaijan">
	<meta name="keywords" content="<?=$data['keywords']?>">
	<meta name="description" content="<?=$data['description']?>">
	<meta name="copyright" content="Golf in Azerbaijan" />
	<meta name="apple-mobile-web-app-title" content="Golf in Azerbaijan">
	<meta name="application-name" content="Golf in Azerbaijan">

    <!-- favicon -->
    <!------------------------------------------------------------------------------------------------>

    <!------------------------------------------------------------------------------------------------>

    <meta property="og:url" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Golf in Azerbaijan" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="" />

    <?php $hooks->run('meta'); ?>
    <!-- Font Awesome icon -->
    <script src="https://kit.fontawesome.com/dec05b47cd.js"></script>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<?php
	Assets::css(array(
		Url::templatePath() . 'css/fonts.css',
        Url::templatePath() . 'css/main.css?v='.time(),
        Url::templatePath() . 'css/animate.css',
        Url::templatePath() . 'css/app.css?v='.time(),
        Url::templatePath() . 'css/toastr.min.css',
	));
	$hooks->run('css');
	?>
</head>
<body>

    <?php include dirname(__DIR__).'/layouts/inc/nav_menu.php'; ?>

	<?php eval($content); ?>

    <section class="subscriber-section">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="text-white section-title"><?=$language->get('Enjoy_game_golf')?></h2>
                    <p class="text-light"><?=$language->get('Enjoy_alt_Text')?></p>

                    <form action="" method="post" id="form_subscribe">
                        <div class="input-group mt-5">
                            <input type="email" name="subscriber" class="form-control" placeholder="<?=$language->get('enter_email')?>">
                            <span class="input-group-btn">
                                <button class="btn" type="submit"><?=$language->get('Subscribe_Now')?></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <a href="http://azerbaijan.travel" target="_blank">
                        <img src="<?=Url::templatePath()?>img/atb.svg" alt="Azerbaijan travel" width="150">
                    </a>
                </div>
                <div class="col-lg-6 mx-auto mt-5">
                    <div class="footer-social-networks text-white text-bold">
                        <a href="<?=$contacts['facebook']?>" target="_blank" rel="noreferrer noopener" class="soc-links"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?=$contacts['twitter']?>" target="_blank" rel="noreferrer noopener" class="soc-links"><i class="fab fa-twitter"></i></a>
                        <a href="<?=$contacts['linkedin']?>" target="_blank" rel="noreferrer noopener" class="soc-links"><i class="fab fa-linkedin-in"></i></a>
                        <a href="<?=$contacts['youtube']?>" target="_blank" rel="noreferrer noopener" class="soc-links"><i class="fab fa-youtube"></i></a>
                        <a href="<?=$contacts['instagram']?>" target="_blank" rel="noreferrer noopener" class="soc-links"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-3 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center text-light">
                    <small>© Copyright Golf in Azerbaijan 2019.</small>
                </div>
            </div>
        </div>
    </footer>


    <!-- JQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <!-- Bootstrap CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <?php
    Assets::js(array(
        Url::templatePath() . 'js/search.js',
        Url::templatePath() . 'js/toastr.min.js',
        Url::templatePath() . 'js/main.js',
        Url::templatePath() . 'js/scroll.js'
    ));
    $hooks->run('js');
    $hooks->run('footer');
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
</body>
</html>
