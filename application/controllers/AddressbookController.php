<?php

class AddressbookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function contactAction(){
    	$table = new Application_Model_AddressbookMapper();
    	$contacts = $table->fetchAll();

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $this->view->contacts = $contacts;
        $this->render('index');
    }
}