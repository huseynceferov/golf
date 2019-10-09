<?php
use Helpers\Url;
use Helpers\Date;
?>

<header class="page-header post-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$data['result']['title_'.$def_lng]?></h1>
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
                <li class="breadcrumb-item"><a href="/xeberler"><?=$language->get('Golf_News')?></a></li>
                <li class="breadcrumb-item active"><?=$data['result']['title_'.$def_lng]?></li>
            </ol>
        </nav>
    </div>
</div>

<section>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="post-main-information">
                    <h2 class="mt-4"><?=$data['result']['title_'.$def_lng]?></h2>
                    <!-- Author -->
                    <!--<p class="posted-by">
                        by
                        <a href="#">Veli Eliyev</a>
                    </p>-->
                    <hr>
                    <!-- Date/Time -->
                    <p class="text-muted"><?=Date::tarixLang($data['result']['create_time'])?></p>
                </div>
                <hr>
                <!-- Preview Image -->
                <img class="w-100 img-fluid rounded" src="<?=Url::uploadPath().$data['result']['middle']?>" alt="<?=$data['result']['title_'.$def_lng]?>">
                <hr>
                <!-- Post Content -->
                <?=html_entity_decode($data['result']['text_'.$def_lng])?>
            </div>
            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Search Widget -->
                <div class="card my-4">
                    <h5 class="card-header"><?=$language->get('Search')?></h5>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="<?=$language->get('Search_for')?>...">
                            <span class="input-group-btn">
                     <button class="btn btn-secondary" type="button"><?=$language->get('Go')?>!</button>
                     </span>
                        </div>
                    </div>
                </div>
                <!-- Events Widget -->
                <div class="card my-4">
                    <h5 class="card-header"><?=$language->get('Golf_Events')?></h5>
                    <div class="card-body">
                        <ul class="list-unstyled widget-others">
                            <?php
                            foreach ($data['events'] as $event){
                                echo '
                                <li>
                                    <a href="tedbirler/'.$event['slug'].'">
                                        <span>'.$event['title_'.$def_lng].'</span>
                                    </a>
                                    <small>'.Date::tarixLang($event['create_time'], 'd M Y H:i').'</small>
                                </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- Side Widget -->
                <div class="card my-4">
                    <h5 class="card-header"><?=$language->get('Golf_News')?></h5>
                    <div class="card-body">
                        <ul class="list-unstyled widget-others">
                            <?php
                            foreach ($data['news'] as $news){
                                echo '
                                <li>
                                    <a href="xeberler/'.$news['slug'].'">
                                        <span>'.$news['title_'.$def_lng].'</span>
                                    </a>
                                    <small>'.Date::tarixLang($news['create_time'], 'd M Y H:i').'</small>
                                </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>