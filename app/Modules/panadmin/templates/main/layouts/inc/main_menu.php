<?php
use Helpers\Url;
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/main/index');?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/menus/index');?>"><i class="fa fa-list fa-fw"></i> Menus</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/clubs/index');?>"><i class="fa fa-newspaper-o fa-fw"></i> Golf clubs</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/tours/index');?>"><i class="fa fa-star-half-empty fa-fw"></i> Tours</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/events/index');?>"><i class="fa fa-newspaper-o fa-fw"></i> Events</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/news/index');?>"><i class="fa fa-newspaper-o fa-fw"></i> News</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/subscribers/index');?>"><i class="fa fa-users fa-fw"></i> Subscribers</a></li>
            <?php if(\Helpers\Session::get('auth_session_role') == 1 || \Helpers\Session::get('auth_session_role') == 2) { ?>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/contacts/update/2');?>"><i class="fa fa-fw fa-cog"></i> Site information</a></li>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/admins/index');?>"><i class="fa fa-user-secret fa-fw"></i> Admins</a></li>
            <?php } ?>
            <li><a href="<?php echo Url::to(MODULE_ADMIN.'/main/logout');?>"><i class="fa fa-sign-out  fa-fw"></i> Logout</a></li>
        </ul>
    </div>
</div>
