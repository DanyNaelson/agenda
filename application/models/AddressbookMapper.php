<?php
class Application_Model_AddressbookMapper
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
            $this->setDbTable('Application_Model_DbTable_Addressbook');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Addressbook $addressbook)
    {
        $data = array(
            'nombre' => $addressbook->getComment()
        );
 
        if (null === ($id = $addressbook->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id_contacto = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Addressbook $addressbook)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $addressbook->setId($row->id_contacto)
                  ->setNombre($row->nombre);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Addressbook();
            $entry->setId($row->id_contacto)
                  ->setNombre($row->nombre);
            $entries[] = $entry;
        }
        return $entries;
    }
}