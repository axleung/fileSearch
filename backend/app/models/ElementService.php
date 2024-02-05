<?php

namespace FileSystem\Service;

require_once('Element.php');
require_once('Interface/ElementServiceInterface.php');



use FileSystem\Model\Element;

class ElementService implements ElementServiceInterface
{
    protected $_db;

    public final function __construct($db)
    {
        $this->setDb($db);
    }

    public final function setDb(\PDO $db)
    {
        $this->_db = $db;
    }

    public final function addElement(Element $element): int
    {

        $q = $this->_db->prepare("INSERT INTO files (name, parent_id) VALUES (:name, :parent_id)");
        $q->bindValue(':name', $element->getName());
        $q->bindValue(':parent_id', $element->getparentID());

        $q->execute();

        $element->setID($this->_db->lastInsertId());
        return $this->_db->lastInsertId();
    }

    public final function getElements($nameFilter): array
    {
        $array = [];
        $q = $this->_db->prepare("SELECT * FROM files WHERE name LIKE CONCAT('%',:name,'%')");
        $q->bindValue(':name', strtoupper($nameFilter));

        $q->execute();

        while ($data = $q->fetch(\PDO::FETCH_ASSOC)) {

            $array[] = new Element($data);
        }
        return $array;
    }

    public final function getElement($id): Element
    {
        $q = $this->_db->prepare("SELECT * FROM files WHERE id = :id");
        $q->bindValue(':id', $id);

        $q->execute();
        $sqlResult =  $q->fetch(\PDO::FETCH_ASSOC);
        return new Element($sqlResult);
    }

    public final function deleteAll()
    {
        $this->_db->query("TRUNCATE TABLE files");
    }



    public final function loadFile($fileName = 'file_system.txt')
    {
        self::deleteAll();
        try {
            $file = fopen($fileName, 'r');
            $parents = [];
            while (!feof($file)) {
                $line = fgets($file);
                $indent = strlen($line) - strlen(ltrim($line));
                if (empty(trim($line))) continue;
                if (sizeof($parents) - 1 == $indent) {
                    $lastID = array_pop($parents);
                } else if (sizeof($parents) - 1 > $indent) {
                    while (sizeof($parents) - 1 >= $indent) {
                        $lastID = array_pop($parents);
                    }
                }
                if (sizeof($parents) == 0)
                    $element = new Element(["name" => trim($line), "parent_id" => null]);
                else
                    $element = new Element(["name" => trim($line), "parent_id" => $parents[sizeof($parents) - 1]]);

                //insert to DB
                $lastID = self::addElement($element);
                $parents[sizeof($parents)] = $lastID;
            }
            return true;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            fclose($file);
        }
    }
}
