<?php

/**
 * Element model File
 *
 *
 * */

namespace FileSystem\Model;

require_once('Interface/ElementInterface.php');

class Element implements ElementInterface
{
    protected $_id;
    protected $_name;
    protected $_parentID;

    public function __construct($data)
    {

        if (is_Array($data)) {
            if (isset($data['id'])) $this->setID($data['id']);
            $this->setName($data['name']);
            $this->setParentID($data['parent_id']);
        }
    }


    public function getID(): int
    {
        return $this->_id;
    }
    public function getName(): String
    {
        return $this->_name;
    }
    public function getparentID(): int
    {
        return $this->_parentID;
    }
    public function setID($id): void
    {
        $this->_id = (int) $id;
    }
    public function setName($name): void
    {
        $this->_name = $name;
    }
    public function setParentID($id): void
    {
        $this->_parentID = (int) $id;
    }
}
