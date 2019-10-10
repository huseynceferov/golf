<!-- nav section -->
<?php
use Helpers\Url;
$logo2 = (Url::getController() == 'main') ? '' : 'logo2';
$logo_img = (Url::getController() == 'main') ? Url::filePath().$contacts['logo'] : Url::filePath().$contacts['logo2'];


$languages = \Models\LanguagesModel::getLanguages();
if(isset($data['page']) and $data['page']=='other'){
    $class = 'navbar navbar-expand-lg navbar-light bg-light fixed-top';
    $navId = '';
}else{
    $class = 'navbar navbar-expand-lg navbar-dark bg-transparent fixed-top pt-5';
    $navId = 'main-page-nav';
}
?>



<nav class="<?=$class?>" id="<?=$navId?>">
    <div class="container ">
        <a class="navbar-brand" href="/">Golf in <br> Azerbaijan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ml-5">
                <li class="nav-item">
                    <a class="nav-link" href="about"><?=$language->get('foot_about')?></a>
                </li>
            <?php
            foreach ($getMenus as $getMenu){
                echo '
                <li class="nav-item">
                    <a class="nav-link" href="'.$getMenu['slug'].'">'.$getMenu['title_'.$def_lng].'</a>
                </li>';
            }
            ?>

                <li class="nav-item">
                    <a class="nav-link" href="contact"><?=$language->get('foot_contacts')?></a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0 search-form" method="get" action="search">
                <input class="form-control mr-sm-2 search-input" name="q" type="search" placeholder="<?=$language->get('Search')?>" aria-label="Search" id="searchInpt">
                <button class="btn my-2 my-sm-0 search-button" type="submit" id="searchBtn"><i class="fas fa-search"></i></button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?=ucfirst($def_lng)?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <?php
                        foreach ($list_lang as $lang){
                            if ($lang['name']==$def_lng){
                                $hide = 'hide';
                            }else{
                                $hide = '';
                            }
                            echo '<a class="dropdown-item '.$hide.'" href="setlanguage/'.$lang['name'].'">'.$lang['fullname'].'</a>';
                        }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
