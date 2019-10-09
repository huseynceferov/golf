<?php
use Helpers\Url;
?>

<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$language->get('header_golf_index')?></h1>
                    <p class="lead"><?=$language->get('golf_text_index')?></p>
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
                <li class="breadcrumb-item active" aria-current="page"><?=$language->get('Golf_Clubs')?></li>
            </ol>
        </nav>
    </div>
</div>
<section class="golf-club-section" id="golf_clubs">
    <div class="container">

        <div class="golf-clubs">
            <?php
            foreach ($data['lists'] as $list){
                echo '
            <div class="golf-club-box" style="background: url('.Url::uploadPath().$list['thumb'].')">
                <div class="text-white golf-club-box-text">
                    <a href="qolf-klublari/'.$list['slug'].'"><h3>'.$list['title_'.$def_lng].'</h3></a>
                    <p class="golf-club-description">'.$list['short_text_'.$def_lng].'</p>
                    <p class="golf-club-location">'.$list['location_'.$def_lng].'</p>
                </div>
                <div class="overlay-image"></div>
            </div>';
            }
            ?>

        </div>

    </div>
</section>