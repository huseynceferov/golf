<?php
use Helpers\Url;
?>

<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$language->get('header_golf_events_index')?></h1>
                    <p class="lead"><?=$language->get('golf_events_text_index')?></p>
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
                <li class="breadcrumb-item active" aria-current="page"><?=$language->get('Golf_Events')?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="event-page-section event-section">

    <div class="container">
        <?php
        foreach ($data['lists'] as $list):
        ?>
        <div class="event-full-box">
            <div class="event-box event-image" style="background-image: url(<?=Url::uploadPath().$list['middle']?>);">
                <span><?=$list['arena_'.$def_lng]?></span>
            </div>
            <div class="event-box event-content">
                <h3><a href="tedbirler/<?=$list['slug']?>"><?=$list['title_'.$def_lng]?></a></h3>
                <div class="date-and-time">
                    <div><i class="far fa-calendar-alt"></i> <?=$list['event_date_'.$def_lng]?></div>
                    <div></div>
                    <div><i class="fas fa-map-marker-alt"></i> <?=$list['location_'.$def_lng]?></div>
                </div>
                <hr>
                <p>
                    <?=$list['short_text_'.$def_lng]?>
                </p>
                <a href="/tedbirler/<?=$list['slug']?>"><?=$language->get('Continue_Reading')?>...</a>
            </div>
        </div>
        <?php
        endforeach;
        ?>

        <div class="text-center">
            <a href="#" class="btn my-5 btn-green">Load more</a>
        </div>
    </div>
</section>