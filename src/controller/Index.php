<?php
namespace Controller;

class Index extends \Base {

    public static $aActions = array(
        '/' => 'index',
	'/about' => 'about',
	'/contact' => 'contact',
	'/hallo/:name' => 'hallo',
    );

    public function halloAction() {
	$this->assign('name', $this->_aParams['name']);
	$this->render('hallo.phtml');
    }

    public function aboutAction() {
	$this->render('about.phtml');
    }

    public function contactAction() {
	$this->render('contact.phtml');
    }

    public function indexAction() {
	$this->render('index.phtml');
    }

}
