<?php
class FrontController {

    protected $_sAction;
    protected $_sController;
    protected $_oApp;

    public function __construct() {
        $this->_oApp = \Slim\Slim::getInstance(SLIM_APP_NAME);
    }

    public function getApp() {
        return $this->_oApp;
    }

    public function setAction($sAction)
    {
        $this->_sAction = $sAction;
    }

    public function setController($sController)
    {
        $this->_sController = $sController;
    }

    public function runController() {
        $oClass = new $this->_sController;
        $oClass->init($this);
	call_user_func(array($oClass, $this->_sAction));
    }

    public function init() {
        foreach(glob(MODULE_USER_PATH . '/controller/*.php') as $sControllerFile) {
            require_once($sControllerFile);
            $sControllerName = strtolower(basename($sControllerFile, '.php'));
            $sControllerClass = "Controller\\" . ucfirst($sControllerName);
            foreach($sControllerClass::$aActions as $sRoute => $sActionName) {
		if(is_string($sRoute)) {
			$sPathUrl = $sRoute;
		} else {
	                $sPathUrl = '/' . $sControllerName . '/' . strtolower($sActionName);
		}

                $oController = new self();
                $oController->setController($sControllerClass);
                $oController->setAction(ucfirst($sActionName) . 'Action');

                if(substr_count($sActionName, 'Post') > 0) {
                    $sOrgActionName = $sActionName;
                    $sActionName = str_replace('Post', '', $sActionName);
                    $sPathUrl = '/' . $sControllerName . '/' . strtolower($sActionName);

                    $oController->setAction(ucfirst($sOrgActionName) . 'Action');
                    $this->_oApp->post($sPathUrl, array($oController, 'runController'));
                } else {
                    $this->_oApp->get($sPathUrl, array($oController, 'runController'));
                }
            }
        }
    }

    public function run() {
        $this->_oApp->run();
    }

}
