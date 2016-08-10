<?php
class Application_Model_Address
{
    protected $_calle;
    protected $_num_exterior;
    protected $_num_interior;
    protected $_colonia;
    protected $_delegacion_municipio;
    protected $_estado;
    protected $_cp;
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
 
    public function setCalle($calle)
    {
        $this->_calle = (string) $calle;
        return $this;
    }
 
    public function getCalle()
    {
        return $this->_calle;
    }

    public function setNumExt($num_exterior)
    {
        $this->_num_exterior = (string) $num_exterior;
        return $this;
    }
 
    public function getNumExt()
    {
        return $this->_num_exterior;
    }

    public function setNumInt($num_interior)
    {
        $this->_num_interior = (string) $num_interior;
        return $this;
    }
 
    public function getNumInt()
    {
        return $this->_num_interior;
    }

    public function setColonia($colonia)
    {
        $this->_colonia = (string) $colonia;
        return $this;
    }
 
    public function getColonia()
    {
        return $this->_colonia;
    }

    public function setDelegacionMunicipio($delegacion_municipio)
    {
        $this->_delegacion_municipio = (string) $delegacion_municipio;
        return $this;
    }
 
    public function getDelegacionMunicipio()
    {
        return $this->_delegacion_municipio;
    }

    public function setEstado($estado)
    {
        $this->_estado = (string) $estado;
        return $this;
    }
 
    public function getEstado()
    {
        return $this->_estado;
    }

    public function setCp($cp)
    {
        $this->_cp = (string) $cp;
        return $this;
    }
 
    public function getCp()
    {
        return $this->_cp;
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