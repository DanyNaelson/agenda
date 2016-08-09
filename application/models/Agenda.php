<?php
// application/models/Addressbook.php
 
class Application_Model_Addressbook
{
    protected $_name_c;
    protected $_telephone;
    protected $_email;
    protected $_address;
    protected $_id;
 
    public function __set($name, $value);
    public function __get($name);
 
    public function setName($name_c);
    public function getName();

    public function setTelephone($telephone);
    public function getTelephone();
 
    public function setEmail($email);
    public function getEmail();
 
    public function setAddress($address);
    public function getAddress();
 
    public function setId($id);
    public function getId();
}
 
class Application_Model_GuestbookMapper
{
    public function save(Application_Model_Addressbook $addressbook);
    public function find($id);
    public function fetchAll();
}