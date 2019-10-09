<?php
/**
 * View - load template pages
 *
 */

namespace Core;

/**
 * View class to load template and views files.
 */
class View
{
    /**
     * @var array Array of HTTP headers
     */
    private static $headers = array();

    /**
     * Include template file.
     *
     * @param  string $path  path to file from views folder
     * @param  array  $data  array of data
     * @param  array  $error array of errors
     */
    public static function render($path, $data = false, $layout=LAYOUT, $template = DEFAULT_TEMPLATE)
    {
        self::sendHeaders();

        $file = 'app/views/'.$path.'.php';

        if(is_readable($file)) {
            $content='require SMVC."app/views/$path.php";';
            require SMVC."app/templates/".$template."/layouts/".$layout.".php";

        } else {
            self::render("error/404",['error' => 'Template file ('.$path.') not found'],'error');
        }

//		$content='require SMVC."app/views/$path.php";';
//        require SMVC."app/templates/layouts/".$layout.".php";
    }

    /**
     * Include template file.
     *
     * @param  string  $path  path to file from Modules folder
     * @param  array $data  array of data
     * @param  array $error array of errors
     */
    public static function renderModule($path, $data = false, $modul=MODULE_ADMIN, $layout = LAYOUT_MODULE_ADMIN, $template = DEFAULT_MODULE_TEMPLATE){
        self::sendHeaders();

        $file = 'app/Modules/'.$modul.'/Views/'.$path.'.php';

        if(is_readable($file)) {
            $content='require SMVC."app/Modules/'.$modul.'/Views/'.$path.'.php";';
            require SMVC."app/Modules/".$modul."/templates/".$template."/layouts/".$layout.".php";

        } else {
            self::render("error/404",['error' => 'Template file (admin module: '.$path.') not found'],'error');
        }
        

    }

    /**
     * Add HTTP header to headers array.
     *
     * @param  string  $header HTTP header text
     */
    public function addHeader($header)
    {
        self::$headers[] = $header;
    }

    /**
     * Add an array with headers to the view.
     *
     * @param array $headers
     */
    public function addHeaders(array $headers = array())
    {
        self::$headers = array_merge(self::$headers, $headers);
    }
    
    /**
     * Send headers
     */
    public static function sendHeaders()
    {
        if (!headers_sent()) {
            foreach (self::$headers as $header) {
                header($header, true);
            }
        }
    }
}
