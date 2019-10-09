<?php
/**
 * Routes - all standard routes are defined here.
 *
 */

/** Create alias for Router. */
use Core\Router;
use Helpers\Hooks;
use Helpers\Url;

/** Define routes. */
Router::any('/', 'Controllers\Site@index');
Router::any('elaqe', 'Controllers\Site@contact');

//Clubs
Router::any('qolf-klublari', 'Controllers\Clubs@lists');
Router::any('qolf-klublari/(:any)', 'Controllers\Clubs@view');

//Tours
Router::any('turlar', 'Controllers\Tours@lists');
Router::any('turlar/(:any)', 'Controllers\Tours@view');

//Events
Router::any('tedbirler', 'Controllers\Events@lists');
Router::any('tedbirler/(:any)', 'Controllers\Events@view');

//Xeberler
Router::any('xeberler', 'Controllers\News@lists');
Router::any('xeberler/(:any)', 'Controllers\News@view');

Router::any('elaqe', 'Controllers\Site@contact');
Router::any('haqqimizda', 'Controllers\Site@aboutUs');
Router::any('request/subscriber', 'Controllers\Site@addSubscriber');
Router::any('setlanguage/(:any)', 'Controllers\Site@setlanguage');
Router::any('setcurrency/(:any)', 'Controllers\Site@setcurrency');
Router::any('404.html', 'Controllers\Site@not_found');



/** Module routes. */
//Hooks::addHook('meta', 'Controllers\Site@meta');
$hooks = Hooks::get();
$hooks->run('routes');

$module=Url::getModule();

/** If no route found. */
if($module==false) Router::error('Core\Error@index');
else Router::error('Core\Error@module_index');

/** Turn on old style routing. */
Router::$fallback = true;

/** Execute matched routes. */
Router::dispatch($module);
