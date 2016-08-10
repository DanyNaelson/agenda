<?php
class Application_Model_AddressMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Address');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Address $address)
    {
        $data = array(
            'calle' => $address->getCalle(),
            'num_exterior' => $address->getNumExt(),
            'num_interior' => $address->getNumInt(),
            'colonia' => $address->getColonia(),
            'delegacion_municipio' => $address->getDelegacionMunicipio(),
            'estado' => $address->getEstado(),
            'cp' => $address->getCp()
        );
 
        if (null === ($id = $address->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id_contacto = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Address $address)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $address->setId($row->id_contacto)
                ->setCalle($row->calle)
                ->setNumExt($row->num_exterior)
                ->setNumInt($row->num_interior)
                ->setColonia($row->colonia)
                ->setDelegacionMunicipio($row->delegacion_municipio)
                ->setEstado($row->estado)
                ->setCp($row->cp);
    }

    public function findIdContact($id_contacto)
    {
    	$where = array("id_contacto = " . $id_contacto);
        $resultSet = $this->getDbTable()->fetchAll($where);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Address();
            $entry->setId($row->id_contacto)
	              ->setCalle($row->calle)
	              ->setNumExt($row->num_exterior)
	              ->setNumInt($row->num_interior)
	              ->setColonia($row->colonia)
	              ->setDelegacionMunicipio($row->delegacion_municipio)
	              ->setEstado($row->estado)
	              ->setCp($row->cp);
            $entries[] = $entry;
        }
        return $entries;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Email();
            $entry->setId($row->id_contacto)
	              ->setCalle($row->calle)
	              ->setNumExt($row->num_exterior)
	              ->setNumInt($row->num_interior)
	              ->setColonia($row->colonia)
	              ->setDelegacionMunicipio($row->delegacion_municipio)
	              ->setEstado($row->estado)
	              ->setCp($row->cp);
            $entries[] = $entry;
        }
        return $entries;
    }
}