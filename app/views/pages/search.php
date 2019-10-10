<?php

use Helpers\Date;
use Helpers\Url;
?>

<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$language->get('Search')?></h1>
                    <p class="lead"><?=$data['searchT']?></p>
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
                <li class="breadcrumb-item active" aria-current="page"><?=$language->get('Search')?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="news-section">
    <div class="container">
        <div class="row">
            <?php
            if(count($data['results'])>0){
                foreach ($data['results'] as $new){
                    echo '
                    <div class="col-lg-4">
                        <div class="golf-new-box">
                            <div class="card">
                                <img class="card-img-top" src="'.Url::uploadPath().$new['middle'].'" alt="'.$new['title_'.$def_lng].'">
                                <div class="card-body">
                                    <h4 class="card-title"> <a href="/news/'.$new['slug'].'">'.$new['title_'.$def_lng].'</a> </h4>
                                    <p class="card-text"><small class="text-muted">'.Date::tarixLang($new['create_time']).'</small></p>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }else{
                echo '<h3>'.$language->get('not_found_text').'</h3>';
            }
            ?>
        </div>
    </div>
</section>
