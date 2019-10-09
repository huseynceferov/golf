<?php
use Helpers\Date;
use Helpers\Url;
?>
<div class="vincent_title_block vincent_corners">
    <div class="vincent_inner_text">
        <h1><?=$language->get('Blog')?></h1>
    </div>
</div>
<div class="vincent_container vincent_blog_grid">
    <div class="vincent_blog_grid_wraper">
        <div class="grid1">
            <?php
            foreach ($data['blogs'] as $blog):
            ?>
            <div class="grid-item">
                <div class="vincent_blog_grid_item">
                    <a href="/blog/<?=$blog['slug']?>"><h4 class="vincent_blog_grid_title"><?=$blog['title_'.$def_lng]?></h4></a href="/blog/<?=$blog['slug']?>">
                    <div class="vincent_meta">
                        <div><?=Date::tarixLang($blog['create_time'],'F d, Y',$def_lng)?></div>
                    </div>
                    <div class="vincent_post_formats">
                        <a href="/blog/<?=$blog['slug']?>"><img src="<?=Url::uploadPath().$blog['image']?>" alt="<?=$blog['title_'.$def_lng]?>"></a>
                    </div>
                    <p class="vincent_excerpt"><a href="/blog/<?=$blog['slug']?>"><?=$blog['short_text_'.$def_lng]?></a></p>
                </div>
            </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <?=$data['pagination']->pageNavigation('vincent_pagination');?>
</div>