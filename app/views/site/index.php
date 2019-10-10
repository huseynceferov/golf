<?php
use Helpers\Url;
use Helpers\MyHelpers;
use Helpers\Date;
?>
<header class="main-page-header">
    <div class="header-bg-image"></div>
    <div class="overlay-image"></div>
    <div class="container">
        <div class="row ">
            <div class="col-lg-6 header-main-content">
                <h1 class="slideInLeft animated mb-5"><?=$language->get('title_header')?></h1>
                <a href="#golf-tours" class="js-scroll-trigger fadeIn animated"><?=$language->get('title_header_alt')?></a>
            </div>
            <div class="col-lg-8 mx-auto text-center arrow-down">
                <a href="#golf_clubs" class="js-scroll-trigger">
                    <img src="<?=Url::templatePath()?>img/arrow_down.svg" class="arrow bounce" alt="" width="40">
                </a>
            </div>
        </div>
    </div>
</header>

<section class="golf-club-section" id="golf_clubs">
    <div class="container">
        <div class="row mb-5 ">
            <div class="col-lg-8">
                <p class="section-sub-title"><?=$language->get('title_golf_index')?></p>
                <h2 class="section-title "><?=$language->get('header_golf_index')?></h2>
                <p class="section-description"><?=$language->get('golf_text_index')?></p>
            </div>
        </div>

        <div class="golf-clubs">
            <?php
            foreach ($data['golfClubs'] as $club){
            echo '
            <div class="golf-club-box" style="background: url('.Url::uploadPath().$club['thumb'].')">
                <div class="text-white golf-club-box-text">
                    <a href="/golf-clubs/'.$club['slug'].'"><h3>'.$club['title_'.$def_lng].'</h3></a>
                    <p class="golf-club-description">'.$club['short_text_'.$def_lng].'</p>
                    <p class="golf-club-location">'.$club['location_'.$def_lng].'</p>
                </div>
                <div class="overlay-image"></div>
            </div>';
            }
            ?>

        </div>

        <a href="/golf-clubs" class="btn my-5 btn-green"><?=$language->get('View_all_clubs')?></a>
    </div>
</section>

<section class="tours-section">
    <div class="container">
        <div class="row mb-5 ">
            <div class="col-lg-8">
                <p class="section-sub-title"><?=$language->get('title_golf_tours_index')?></p>
                <h2 class="section-title "><?=$language->get('header_golf_tours_index')?></h2>
                <p class="section-description"><?=$language->get('golf_tours_text_index')?></p>
            </div>
        </div>

        <div class="golf-tour-boxes">
            <?php
            foreach ($data['golfTours'] as $tour){
                echo '
                <div class="golf-tour-box" style="background: url('.Url::uploadPath().$tour['middle'].')">
                    <a href="/tours/'.$tour['slug'].'">
                        <div class="golf-tour-box-text">
                            <h3>'.$tour['title_'.$def_lng].'</h3>
                            <p>'.$language->get('from').' '.$tour['price_'.$def_lng].'</p>
                        </div>
                    </a>
                </div>';
            }
            ?>
        </div>

        <a href="/tours/" class="btn my-5 btn-green"><?=$language->get('View_all_tours')?></a>

    </div>
</section>

<section class="event-section" id="golf-tours">
    <div class="overlay-image"></div>

    <div class="container">
        <div class="row mb-5 ">
            <div class="col-lg-8">
                <p class="section-sub-title"><?=$language->get('title_golf_events_index')?></p>
                <h2 class="section-title text-white"><?=$language->get('header_golf_events_index')?></h2>
                <p class="section-description text-light"><?=$language->get('golf_events_text_index')?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg">
                <div id="eventSlider" class="carousel slide event-slider" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $c=1;
                        foreach ($data['events'] as $event):
                            if($c==1){
                                $active = 'active';
                            }else{
                                $active = '';
                            }
                        ?>
                        <div class="carousel-item <?=$active?>">
                            <div class="event-item-<?=$c?>">
                                <div class="event-full-box">
                                    <div class="event-box event-image" style="background-image: url(<?=Url::uploadPath().$event['middle']?>);">
                                        <span><?=$event['arena_'.$def_lng]?></span>
                                    </div>
                                    <div class="event-box event-content">
                                        <h3><a href="/events/<?=$event['slug']?>"><?=$event['title_'.$def_lng]?></a></h3>
                                        <div class="date-and-time">
                                            <div><i class="far fa-calendar-alt"></i> <?=$event['event_date_'.$def_lng]?></div>
                                            <div></div>
                                            <div><i class="fas fa-map-marker-alt"></i> <?=$event['location_'.$def_lng]?></div>
                                        </div>
                                        <hr>
                                        <p>
                                            <?=$event['short_text_'.$def_lng]?>
                                        </p>
                                        <a href="/events/<?=$event['slug']?>"><?=$language->get('Continue_Reading')?>...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $c++;
                        endforeach;
                        ?>
                    </div>
                    <div class="slider-buttons">
                        <a class="" href="#eventSlider" role="button" data-slide="prev">
                            <span class="fas fa-caret-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="" href="#eventSlider" role="button" data-slide="next">
                            <span class="fas fa-caret-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <a href="/events" class="btn my-5 btn-green"><?=$language->get('View_all_events')?></a>
            </div>
        </div>

    </div>
</section>

<section class="news-section">
    <div class="container">
        <div class="row mb-5 ">
            <div class="col-lg-8">
                <p class="section-sub-title"><?=$language->get('title_golf_news_index')?></p>
                <!-- <h2 class="section-title">Here you can see golf news title</h2> -->
                <p class="section-description"><?=$language->get('header_golf_news_index')?></p>
            </div>
        </div>
        <div class="row">
            <?php
            foreach ($data['news'] as $new){
                echo '
                <div class="col-lg-4">
                    <div class="golf-new-box">
                        <div class="card">
                            <img class="card-img-top" src="'.Url::uploadPath().$new['middle'].'" alt="'.$new['title_'.$def_lng].'">
                            <div class="card-body">
                                <h4 class="card-title"> <a href="/news/'.$new['slug'].'">'.$new['title_'.$def_lng].'</a> </h4>
                                <p class="card-text"><small class="text-muted">'.Date::tarixLang($new['create_time'],'d F Y , H:i',$def_lng).'</small></p>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</section>
