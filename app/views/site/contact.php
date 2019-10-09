<?php

use Helpers\Url;

?>
<header class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 page-header-col">
                <div class="page-header-content">
                    <h1><?=$language->get('write_us')?></h1>
                    <p class="lead"><?=$language->get('bro_say')?></p>
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
                <li class="breadcrumb-item active" aria-current="page"><?=$language->get('write_us')?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="contact-us-page-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form role="form" id="contact-form" class="contact-form" method="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" autocomplete="off" id="Name" placeholder="<?=$language->get('name')?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" autocomplete="off" id="email" placeholder="<?=$language->get('your_email')?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control textarea" rows="3" name="message" id="Message" placeholder="<?=$language->get('contact_message')?>"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn main-btn pull-right"><?=$language->get('send')?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>