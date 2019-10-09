<?php
use Helpers\Date;
use Helpers\Url;
?>
<div class="vincent_title_block vincent_corners">
    <div class="vincent_inner_text">
        <h1><?=$language->get('Our_events')?></h1>
    </div>
</div>
<div class="vincent_container vincent_blog_grid">
    <div class="vincent_blog_grid_wraper">
        <div class="grid1">
            <?php
            foreach ($data['events'] as $event):
                ?>
                <div class="grid-item">
                    <div class="vincent_blog_grid_item">
                        <a href="/event/<?=$event['slug']?>"><h4 class="vincent_blog_grid_title"><?=$event['title_'.$def_lng]?></h4></a href="/event/<?=$event['slug']?>">
                        <div class="vincent_meta">
                            <div><?=Date::tarixLang($event['create_time'],'F d, Y',$def_lng)?></div>
                        </div>
                        <div class="vincent_post_formats">
                            <a href="/event/<?=$event['slug']?>"><img src="<?=Url::uploadPath().$event['image']?>" alt="<?=$event['title_'.$def_lng]?>"></a>
                        </div>
                        <p class="vincent_excerpt"><a href="/event/<?=$event['slug']?>"><?=$event['short_text_'.$def_lng]?></a></p>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <?=$data['pagination']->pageNavigation('vincent_pagination');?>
</div>