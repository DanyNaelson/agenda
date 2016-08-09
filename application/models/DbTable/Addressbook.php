<?php
// application/models/DbTable/Addressbook.php
 
class Application_Model_DbTable_Addressbook extends Zend_Db_Table_Abstract
{
    protected $_id;
    protected $_name;
    protected $_telephone;
    protected $_email;
    protected $_address;
}