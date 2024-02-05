<?php

namespace FileSystem\Service;

use FileSystem\Model\Element;


interface ElementServiceInterface
{
    public function addElement(Element $element): int;

    public function getElement(int $id): Element;

    public function getElements(String $nameFilter): array;

    public function setDb(\PDO $db);
}
