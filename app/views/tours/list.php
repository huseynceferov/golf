<?php
use Helpers\Url;
?>

<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$language->get('header_golf_tours_index')?></h1>
                    <p class="lead"><?=$language->get('golf_tours_text_index')?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay-image"></div>
</header>

<div class="container-fluid py-3 page-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><?=$language->get('Home')?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$language->get('Golf_Tours')?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="tours-section">
    <div class="container">
        <div class="golf-tour-boxes">
            <?php
            foreach ($data['lists'] as $tour){
                echo '
                <div class="golf-tour-box" style="background: url('.Url::uploadPath().$tour['middle'].')">
                    <a href="turlar/'.$tour['slug'].'">
                        <div class="golf-tour-box-text">
                            <h3>'.$tour['title_'.$def_lng].'</h3>
                            <p>'.$language->get('from').' '.$tour['price_'.$def_lng].'</p>
                        </div>
                    </a>
                </div>';
            }
            ?>
        </div>
    </div>
</section>