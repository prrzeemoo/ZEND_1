<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected $_docRoot;

    protected function _initPath()
    {
        $this->_docRoot = dirname(APPLICATION_PATH) . '/';
        Zend_Registry::set('docRoot', $this->_docRoot);
    }

    protected function _initLoaderResource()
    {
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => $this->_docRoot . '/application',
            'namespace' => 'Saffron'
        ));
        $resourceLoader->addResourceTypes(array(
            'model' => array(
                'namespace' => 'Model',
                'path' => 'models'
            )
        ));
    }

    protected function _initLog()
    {
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/error.log');
        return new Zend_Log($writer);
    }

    protected function _initView()
    {
        $view = new Zend_View();
        return $view;
    }

    protected function _initRouterBezdomyslnych()
    {
        $this->bootstrap('router');
        $router = $this->getResource('router');
        $router->removeDefaultRoutes();
        return $router;
    }

//    Metoda odpowiedzialna za przetworzenie opcji page z listingu 10.14
    protected function _initPage()
    {
        $this->bootstrap(array(
            'layout',
            'view',
            'frontController',
        ));

        $front = $this->getResource('frontController');
        $layout = $this->getResource('layout');
        $view = $this->getResource('view');

        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);

        $baseUrl = $request->getBaseUrl();
        $defaultsArray = array(
            'page' => array(
                'title' => array(
                    'separator' => '',
                    'content' => '',
                    'defaultAttachOrder' => 'APPEND',
                ),
                'css' => array(),
                'js' => array(),
                'keywords' => false,
                'description' => false,
                'extension' => 'phtml',
            )
        );

        $defaults = new Zend_Config($defaultsArray, true);
        $cfg = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
        $cfg = $defaults->merge($cfg);

        $view->headTitle()
            ->setDefaultAttachOrder($cfg->page->title->defaultAttachOrder)
            ->setSeparator($cfg->page->title->separator)
            ->headTitle($cfg->page->title->content);

        foreach ($cfg->page->css as $css) {
            if (isset($css->media)) {
                $view->headLink()->appendStylesheet($baseUrl . $css->href, $css->media);
            } else {
                $view->headLink()->appendStylesheet($baseUrl . $css->href);
            }
        }

        foreach ($cfg->page->js as $js) {
            $view->headScript()->appendFile(
                $baseUrl . $js,
                'text/javascript'
            );
        }

        if ($cfg->page->keywords) {
            $view->headMeta()->appendName('keywords', $cfg->page->keywords);
        }

        if ($cfg->page->description) {
            $view->headMeta()->appendName('description', $cfg->page->description);
        }

        if ($cfg->page->extension != 'phtml') {
            $layout->setViewSuffix($cfg->page->extension);
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
            $viewRenderer->setViewSuffix($cfg->page->extension);
            $viewRenderer->setView($view);
        }
    }

}