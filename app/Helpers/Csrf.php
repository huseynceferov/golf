<?php
/**
 * Cross Site Request Forgery helper
 *
 */

namespace Helpers;

use Helpers\Session;

/**
 * Instructions:
 * At the top of the controller where the other "use" statements are place:
 * use Helpers\Csrf;
 *
 * Just prior to rendering the view for adding or editing data create the CSRF token:
 * $data['csrf_token'] = Csrf::makeToken();
 * $this->view->renderTemplate('header', $data);
 * $this->view->render('pet/edit', $data, $error); // as an example
 * $this->view->renderTemplate('footer', $data);
 *
 * At the bottom of your form, before the submit button put:
 * <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>" />
 *
 * These lines need to be placed in the controller action to validate CSRF token submitted with the form:
 * if (!Csrf::isTokenValid()) {
 *      Url::redirect('admin/login'); // or wherever you want to redirect to.
 *    }
 * And that's all
 */
class Csrf
{
    public static function makeToken()
    {
        Session::set('csrf_token', md5(uniqid(rand(), true)));
        return Session::get('csrf_token');
    }

    public static function isTokenValid()
    {
        return $_POST['csrf_token'] === Session::get('csrf_token');
    }

    public static function updateToken(){
        Session::set('csrf_token', md5(uniqid(rand(), true)));
    }
    public static function getToken(){
        return Session::get('csrf_token');
    }
}
