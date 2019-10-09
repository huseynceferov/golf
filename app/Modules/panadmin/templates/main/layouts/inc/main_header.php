<?php
use Helpers\Url;
?>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo Url::to(MODULE_ADMIN.'/main/index');?>"><?= MODULE_ADMIN_TITLE;?></a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> Admin <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="<?= \Helpers\Url::to('admin/contacts/create')?>"><i class="fa fa-gear fa-fw"></i> Məlumatları dəyiş</a>
            </li>
            <li class="divider"></li>
            <li><a href="<?= \Helpers\Url::to('admin/main/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Çıxış</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->
<div class="navbar-right" id="time__clock">
    <span><i class="fa fa-clock-o" aria-hidden="true"></i> </span>
    <div id="time_clock"></div>
</div>