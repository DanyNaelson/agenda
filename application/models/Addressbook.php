<?php
class Application_Model_Addressbook
{
    protected $_nombre;
    protected $_id_contacto;
 
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 
    public function setNombre($text)
    {
        $this->_nombre = (string) $text;
        return $this;
    }
 
    public function getNombre()
    {
        return $this->_nombre;
    }
 
    public function setId($id_contacto)
    {
        $this->_id_contacto = (int) $id_contacto;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id_contacto;
    }
}