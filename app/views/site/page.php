<?php
use Core\Language;
$page = $data['get_page'];
?>
<div class="clearfix"></div>
<section id="page_title">
	<div class="container">
		<div id="main_title"><?=$page['title_'.$data['language']]?></div>
		<div id="main_url"><a href="<?= SITE_URL ?>"><?=$data['lang']->get('main_page')?></a> > <?=$page['title_'.$data['language']]?></div>
		<div class="bottom_line"></div>
	</div>
</section>
<!-- section tours begin -->
<section id="page_section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="page_text">
					<?=html_entity_decode($page['text_'.$data['language']])?>
				</div>
				<br>
			</div>
		</div>
	</div>
</section>
<!-- section tours end -->
