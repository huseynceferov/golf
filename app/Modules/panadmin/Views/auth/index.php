<?php
use Helpers\Csrf;
?>
<div class="login_page">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <div class="user_avatar"></div>
                </div>
                <div class="panel-body">
                    <?= \Helpers\Session::getFlash();?><br />
                    <form action="" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Login" name="login_admin" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Şifrə" name="password" type="password" value="">
                            </div>
                            <input type="hidden" value="<?=Csrf::makeToken()?>" name="csrf_token" />
                            <input type="submit" class="btn btn-lg btn-block md-btn-primary" value="Daxil ol" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>