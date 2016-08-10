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
    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

    	$contact_data = $this->getRequest()->getPost("form_data");
    	$contact_phone = $this->getRequest()->getPost("telephone");
    	$mapper = new Application_Model_AddressMapper();
    	$db = $mapper->getDbTable()->getAdapter();
    	
    	$statement = $db->prepare("CALL insert_contact(:nombre_c, :calle_c, :num_exterior_c, :num_interior_c, :colonia_c, :delegacion_municipio_c, :estado_c, :cp_c, :correo_c)");
    	$statement->bindParam(":nombre_c", $contact_data["nombre"], PDO::PARAM_STR);
    	$statement->bindParam(":calle_c", $contact_data["calle"], PDO::PARAM_STR);
    	$statement->bindParam(":num_exterior_c", $contact_data["num_exterior"], PDO::PARAM_STR);
    	$statement->bindParam(":num_interior_c", $contact_data["num_interior"], PDO::PARAM_STR);
    	$statement->bindParam(":colonia_c", $contact_data["colonia"], PDO::PARAM_STR);
    	$statement->bindParam(":delegacion_municipio_c", $contact_data["delegacion_municipio"], PDO::PARAM_STR);
    	$statement->bindParam(":estado_c", $contact_data["estado"], PDO::PARAM_STR);
    	$statement->bindParam(":cp_c", $contact_data["cp"], PDO::PARAM_STR);
    	$statement->bindParam(":correo_c", $contact_data["correo"], PDO::PARAM_STR);
    	$statement->execute();
    	
    	$response = array("respuesta" => "t");

    	echo json_encode($response);
    }

    public function updateAction(){
    	$id_contacto = $this->getRequest()->getPost("id_contacto");

    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $addressbookMapper = new Application_Model_AddressbookMapper();
    	$contacts = $addressbookMapper->findIdContact($id_contacto);

        $address = new Application_Model_AddressMapper();
    	$direcciones = $address->findIdContact($id_contacto);

        $telephone = new Application_Model_TelephoneMapper();
    	$telefonos = $telephone->findIdContact($id_contacto);

        $email = new Application_Model_EmailMapper();
    	$correos = $email->findIdContact($id_contacto);

        $this->view->contacts = $contacts;
        $this->view->direcciones = $direcciones;
        $this->view->telefonos = $telefonos;
        $this->view->correos = $correos;
        $this->render('update-contact');
    }

    public function updatecAction(){
    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $id_contacto = $this->getRequest()->getPost("id_contacto");
    	$contact_data = $this->getRequest()->getPost("form_data");
    	$contact_phone = $this->getRequest()->getPost("telephone");
    	$mapper = new Application_Model_AddressMapper();
    	$db = $mapper->getDbTable()->getAdapter();
    	
    	$statement = $db->prepare("CALL update_contact(:id_contact, :nombre_c, :calle_c, :num_exterior_c, :num_interior_c, :colonia_c, :delegacion_municipio_c, :estado_c, :cp_c, :correo_c)");
    	$statement->bindParam(":id_contact", $id_contacto, PDO::PARAM_INT);
    	$statement->bindParam(":nombre_c", $contact_data["nombre"], PDO::PARAM_STR);
    	$statement->bindParam(":calle_c", $contact_data["calle"], PDO::PARAM_STR);
    	$statement->bindParam(":num_exterior_c", $contact_data["num_exterior"], PDO::PARAM_STR);
    	$statement->bindParam(":num_interior_c", $contact_data["num_interior"], PDO::PARAM_STR);
    	$statement->bindParam(":colonia_c", $contact_data["colonia"], PDO::PARAM_STR);
    	$statement->bindParam(":delegacion_municipio_c", $contact_data["delegacion_municipio"], PDO::PARAM_STR);
    	$statement->bindParam(":estado_c", $contact_data["estado"], PDO::PARAM_STR);
    	$statement->bindParam(":cp_c", $contact_data["cp"], PDO::PARAM_STR);
    	$statement->bindParam(":correo_c", $contact_data["correo"], PDO::PARAM_STR);
    	$statement->execute();
    	
    	$response = array("respuesta" => "t");

    	echo json_encode($response);
    }

    private function create_html_address($direcciones){
    	$html_direcciones = "";
        $html_direcciones .= '<div class="col-md-4">';
        
        foreach ($direcciones as $direccion){
			$html_direcciones .= 	'<address>';
			$html_direcciones .= 		'<strong>Dirección:</strong><br>';
			$html_direcciones .= 		$direccion->getCalle() . ' #' . $direccion->getNumExt() . ' ' . $direccion->getNumInt() . ', ' . $direccion->getColonia() . ',<br>';
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