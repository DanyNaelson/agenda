<?php
class Application_Model_EmailMapper
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
            $this->setDbTable('Application_Model_DbTable_Email');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Addressbook $email)
    {
        $data = array(
            'correo' => $email->getCorreo()
        );
 
        if (null === ($id = $email->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id_contacto = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Email $email)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $email->setId($row->id_contacto)
                  ->setCorreo($row->correo);
    }

    public function findIdContact($id_contacto)
    {
    	$where = array("id_contacto = " . $id_contacto);
        $resultSet = $this->getDbTable()->fetchAll($where);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Email();
            $entry->setId($row->id_contacto)
                  ->setCorreo($row->correo);
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
                  ->setCorreo($row->correo);
            $entries[] = $entry;
        }
        return $entries;
    }
}