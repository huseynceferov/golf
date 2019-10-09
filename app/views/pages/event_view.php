<?php
use Helpers\Url;
use Helpers\Date;
?>
<div class="vincent_title_block vincent_corners">
    <div class="vincent_inner_text">
        <h1><?=$data['result']['title_'.$def_lng]?></h1>
    </div>
</div>
<div class="vincent_container  vincent_standard_post vincent_image_post">
    <div class="row gutters">

        <div class="col col-8 vincent_content">
            <div class="vincent_blog_standard_wraper">
                <div class="vincent_blog_standard_item">
                    <div class="vincent_meta">
                        <div><?=Date::tarixLang($data['result']['create_time'],'F d, Y',$def_lng)?> </div>
                    </div>
                    <div class="vincent_post_formats">
                        <div class="owl-carousel vincent_slider1i ">
                            <div class="vincent_testimonials_item ">
                                <img src="<?=Url::uploadPath().$data['result']['image']?>" alt="<?=$data['result']['title_'.$def_lng]?>">
                            </div>
                        </div>
                    </div>
                    <?=html_entity_decode($data['result']['text_'.$def_lng])?>
                </div>
            </div>
        </div>
        <div class="col col-4 vincent_sidebar">
            <div class="vincent_sidebar_block vincent_featured_posts">
                <h5><?=$language->get('Other_events')?></h5>
                <?php
                foreach ($data['news_recent'] as $new):
                    ?>
                    <div class="vincent_posts_item">
                        <a href="/blog/<?=$new['slug']?>">
                            <img src="<?=Url::uploadPath().$new['image']?>" alt="<?=$new['title_'.$def_lng]?>">
                            <span><?=$new['title_'.$def_lng]?></span>
                        </a>
                        <div class="vincent_date"><?=Date::tarixLang($new['create_time'],'F d, Y',$def_lng)?></div>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>
