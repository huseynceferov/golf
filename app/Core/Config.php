<?php
/**
 * Config - an example for setting up system settings.
 * When you are done editing, rename this file to 'Config.php'.
 */

namespace Core;

use Helpers\Session;

/**
 * Configuration constants and options.
 */
class Config
{
    /**
     * Executed as soon as the framework runs.
     */
    public function __construct()
    {
        /**
         * Turn on output buffering.
         */
        ob_start();

        /**
         * Define relative base path.
         */
        define('DIR', '/');

        define('SITE_URL', 'https://golfazerbaijan.az');

        /**
         * Set default controller and method for legacy calls.
         */
        define('DEFAULT_CONTROLLER', 'main');
        define('DEFAULT_METHOD', 'index');


		define('LAYOUT', 'main');
        define('DEFAULT_TEMPLATE', 'main');
        define('DEFAULT_MODULE_TEMPLATE', 'main');

        define('MODULE_ADMIN', 'panadmin');
		define('LAYOUT_MODULE_ADMIN', 'admin_main');
		define('DEFAULT_MODULE_CONTROLLER', 'main');
        define('DEFAULT_MODULE_METHOD', 'index');
        define('DEFAULT_MAIL_FROM', 'info@golfazerbaijan.az');
        /**
         * Set a default language.
         */
        define('LANGUAGE_CODE', 'az');

        //database details ONLY NEEDED IF USING A DATABASE

        /**
         * Database engine default is mysql.
         */
        define('DB_TYPE', 'mysql');

        /**
         * Database host default is localhost.
         */
        define('DB_HOST', 'localhost');

        /**
         * Database name.
         */
        define('DB_NAME', 'golf');

        /**
         * Database username.
         */
        define('DB_USER', 'root');

        /**
         * Database password.
         */
        define('DB_PASS', 'Pass1234!');

        /**
         * PREFER to be used in database calls default is smvc_
         */
        define('PREFIX', 'smvc_');

        /**
         * Set prefix for sessions.
         */
        define('SESSION_PREFIX', 'smvc_');

        /**
         * Set expiration time for cookie
         */
        define('COOKIE_EXPIRE', 86400);

        /**
         * Optional create a constant for the name of the site.
         */
        define('SITETITLE', 'V1.0');

        define('MODULE_ADMIN_TITLE', 'Golf');

        define('CMS_KEY', 'mlcoders');

        /**
         * Optionall set a site email address.
         */
        define('SITEEMAIL', 'NO_REPLY');

        /**
         * Turn on custom error handling.
         */
//        set_exception_handler('Core\Logger::ExceptionHandler');
//        set_error_handler('Core\Logger::ErrorHandler');

        /**
         * Set timezone.
         */
        date_default_timezone_set('Asia/Baku');

        /**
         * Start sessions.
         */
        Session::init();
    }
}
