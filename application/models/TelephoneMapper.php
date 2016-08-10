<?php
class Application_Model_TelephoneMapper
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
            $this->setDbTable('Application_Model_DbTable_Telephone');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Telephone $telephone)
    {
        $data = array(
            'lada' => $telephone->getLada(),
            'numero' => $telephone->getNumero()
        );
 
        if (null === ($id = $telephone->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id_contacto = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Telephone $telephone)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $telephone->setId($row->id_contacto)
                  ->setLada($row->lada)
                  ->setNumero($row->numero);
    }

    public function findIdContact($id_contacto)
    {
    	$where = array("id_contacto = " . $id_contacto);
        $resultSet = $this->getDbTable()->fetchAll($where);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Telephone();
            $entry->setId($row->id_contacto)
                  ->setLada($row->lada)
                  ->setNumero($row->numero);
            $entries[] = $entry;
        }
        return $entries;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Telephone();
            $entry->setId($row->id_contacto)
                  ->setLada($row->lada)
                  ->setNumero($row->numero);
            $entries[] = $entry;
        }
        return $entries;
    }
}