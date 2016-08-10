<?php

class AddressbookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function addAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $this->render('add-contact');
    }

    public function contactAction(){
    	$addressbookMapper = new Application_Model_AddressbookMapper();
    	$contacts = $addressbookMapper->fetchAll();

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $this->view->contacts = $contacts;
        $this->render('contact');
    }

    public function detailAction(){
    	$id_contacto = $this->getRequest()->getPost("contacto");

    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $address = new Application_Model_AddressMapper();
    	$direcciones = $address->findIdContact($id_contacto);        
        $detail_address = $this->create_html_address($direcciones);

        $telephone = new Application_Model_TelephoneMapper();
    	$telefonos = $telephone->findIdContact($id_contacto);        
        $detail_telephone = $this->create_html_telephone($telefonos);

        $email = new Application_Model_EmailMapper();
    	$correos = $email->findIdContact($id_contacto);        
        $detail_email = $this->create_html_email($correos);

		echo $detail_address . $detail_telephone . $detail_email;
    }

    public function saveAction(){
    	
    }

    private function create_html_address($direcciones){
    	$html_direcciones = "";
        $html_direcciones .= '<div class="col-md-4">';
        
        foreach ($direcciones as $direccion){
			$html_direcciones .= 	'<address>';
			$html_direcciones .= 		'<strong>Dirección:</strong><br>';
			$html_direcciones .= 		$direccion->getCalle() . ' #' . $direccion->getNumExt() . ' ' . $direccion->getNumInt() . ', ' . $direccion->getColonia() . '<br>';
			$html_direcciones .= 		$direccion->getDelegacionMunicipio() . ', ' . $direccion->getEstado() . ', CP. ' . $direccion->getCp() . '<br>';
			$html_direcciones .= 	'</address>';
		}

		$html_direcciones .= '</div>';

		return $html_direcciones;
    }

    private function create_html_telephone($telefonos){
    	$html_telefonos = "";
        $html_telefonos .= '<div class="col-md-4">';
        
        foreach ($telefonos as $telefono){
			$html_telefonos .= 	'<address>';
			$html_telefonos .= 		'<strong>Teléfono:</strong><br>';
			$html_telefonos .= 		'(' . $telefono->getLada() . ') ' . $telefono->getNumero();
			$html_telefonos .= 	'</address>';
		}

		$html_telefonos .= '</div>';

		return $html_telefonos;
    }

    private function create_html_email($correos){
    	$html_correos = "";
        $html_correos .= '<div class="col-md-4">';
        
        foreach ($correos as $correo){
			$html_correos .= 	'<address>';
			$html_correos .= 		'<strong>Correo:</strong><br>';
			$html_correos .= 		'<a href="mailto:' . $correo->getCorreo() . '">' . $correo->getCorreo() . '</a>';
			$html_correos .= 	'</address>';
		}

		$html_correos .= '</div>';

		return $html_correos;
    }
}