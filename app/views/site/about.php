<?php

use Helpers\Url;

?>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$language->get('Welcome_to_Azerbaijan')?></h1>
                    <p class="lead"><?=$language->get('You_will_know_almost_everything')?></p>
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
                <li class="breadcrumb-item active" aria-current="page"><?=$language->get('foot_about')?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="page-section-content">
    <div class="container">
        <div class="row about-page-content">
            <div class="col-lg-6">
                <p class="page-name"><?=$language->get('About_Azerbaijan')?></p>
                <h2 class="page-title mb-3"><?=$language->get('about_tit')?></h2>
                <p class="page-text"><?=$language->get('about_text_1')?></p>
                <p class="page-text"><?=$language->get('about_text_2')?></p>
            </div>
            <div class="col-lg-6">
                <iframe width="100%" height="400" src="https://www.youtube.com/embed/-1E0RsZJrIg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>


<section class="tours-section">
    <div class="container">
        <div class="row mb-5 ">
            <div class="col-lg-8">
                <h2 class="section-title "><?=$language->get('header_golf_tours_index')?></h2>
                <p class="section-description"><?=$language->get('golf_tours_text_index')?></p>
            </div>
        </div>

        <div class="golf-tour-boxes">
            <?php
            foreach ($data['golfTours'] as $tour){
                echo '
                <div class="golf-tour-box" style="background: url('.Url::uploadPath().$tour['middle'].')">
                    <a href="/turlar/'.$tour['slug'].'">
                        <div class="golf-tour-box-text">
                            <h3>'.$tour['title_'.$def_lng].'</h3>
                            <p>'.$language->get('from').' '.$tour['price_'.$def_lng].'</p>
                        </div>
                    </a>
                </div>';
            }
            ?>
        </div>

        <a href="/turlar/" class="btn my-5 btn-green"><?=$language->get('View_all_tours')?></a>

    </div>
</section>