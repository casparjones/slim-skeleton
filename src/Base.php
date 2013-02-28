<?php

class Base {

    /**
     * @var \Slim\Slim
     */
    protected $_oApp;
    protected $_aData = array();
    protected $_aFlash = array();
    protected $_sLayout = 'main.phtml';
    protected $_aParams = array();
    protected $_sUrlPattern;

    public function init($oFrontController) {
        $this->_oApp = \Slim\Slim::getInstance(SLIM_APP_NAME);
	$this->_aParams = $this->_oApp->router()->getCurrentRoute()->getParams();
	$this->_sUrlPattern = $this->_oApp->router()->getCurrentRoute()->getPattern();
    }

    public function assign($sKey, $mValue) {
        $this->_aData[$sKey] = $mValue;
    }

    public function error($sValue) {
        $this->_oApp->flashNow('error', $sValue);
    }

    public function message($sValue) {
        $this->_oApp->flashNow('message', $sValue);
    }

    public function render($sTemplate = false) {
        $this->_oApp = \Slim\Slim::getInstance(SLIM_APP_NAME);
	$this->assign('slimPattern', $this->_sUrlPattern);

        $sContent = isset($this->_aData['slimContent']) ? $this->_aData['slimContent'] : '' ;
        if($sTemplate) {
            $oView = $this->_oApp->view();
            $oView->appendData($this->_aData);
            $sContent = $oView->fetch($sTemplate);
        }

	$this->assign('slimContent', $sContent);
        $this->_oApp->render('/layout/' . $this->_sLayout, $this->_aData);
    }

    public function _redirect($sUrl) {
        $this->_oApp->response()->redirect($sUrl);
    }
}
