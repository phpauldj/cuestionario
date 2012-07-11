<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function run() {
        parent::run();
    }

    public function _initConfig()
    {
        $config = new Zend_Config($this->getOptions(), true);
        $config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini'));
        $config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/app.ini'));
        $config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/private.ini'));
        $config->setReadOnly();
        Zend_Registry::set('config', $config);
    }    

    public function _initViewHelpers()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $config = Zend_Registry::get('config');

        //$view->doctype(Zend_View_Helper_Doctype::HTML5);
        $view->headMeta()->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1');
        //$view->headMeta()->appendName("robots", "noindex, nofollow");
        $view->headMeta()->appendName(
            "description", $config->app->description
        );
        $view->headMeta()->appendName(
            "keywords", $config->app->keywords
        );
        $view->headMeta()->appendName("Author", $config->app->author);
        $view->headMeta()->appendName("viewport", "width=device-width, initial-scale=1.0");
        //$view->headMeta()->appendName("Content-Language", "es");
        //$view->headMeta()->appendName("geo.placename", "Lima, Perú");

        /*$view->headTitle($config->app->title)->setSeparator(' - ');
        $view->headLink(
            array(
                'rel' => 'shortcut icon',
                'href' => $config->app->mediaUrl . '/images/favicon.ico'
            )
        );*/

        $view->headLink()->appendStylesheet($config->app->mediaUrl . '/css/main.css', 'all');
        //$view->headScript()->appendFile($config->app->mediaUrl . '/js/libs/modernizr-2.5.3.min.js');
        /*$view->headScript()->offsetSetFile(0, $config->app->mediaUrl . '/js/libs/jquery-1.7.1.min.js');
        $view->headScript()->offsetSetFile(1, $config->app->mediaUrl . '/js/main.js');*/

        $js = sprintf(
            "var urls = {
            	mediaUrl : '%s', 
            	elementsUrl : '%s', 
            	siteUrl : '%s', 
            	fDayCurrent : %s,
            	fMonthCurrent : %s, 
            	fYearCurrent : %s, 
            	fMinDate : %s
            }",
            $config->app->mediaUrl, 
            $config->app->elementsUrl, 
            $config->app->siteUrl, 
            date('j'), date('n'), date('Y'), '1900'
        );
        $view->headScript()->appendScript($js);

        //Definiendo Constante para Partials
        define('MEDIA_URL', $config->app->mediaUrl);
        define('ELEMENTS_URL', $config->app->elementsUrl);
        define('ELEMENTS_ROOT', $config->paths->elementsRoot);
        define('SITE_URL', $config->app->siteUrl);
        define('HOST_URL', $config->app->hostname);

        $view->addHelperPath('App/View/Helper', 'App_View_Helper');
    }

    public function _initRoutes()
    {
        $this->bootstrap('frontController');
        $router = $this->getResource('frontController')->getRouter();
        $routeConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini');
        $router->addConfig($routeConfig);
    }

    public function _initRegistries()
    {
        //$config = Zend_Registry::get('config');

        $this->_executeResource('multidb');
        $adapter = $this->getPluginResource('multidb')->getDb('db');
        Zend_Registry::set('db', $adapter);
    }

    public function _initLibreries()
    {
        
    }
}

