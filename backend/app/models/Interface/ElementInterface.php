<?php

namespace FileSystem\Model;

interface ElementInterface
{


    public function getID(): int;

    public function getName(): String;

    public function getParentID(): int;


    public function setID(int $id): void;

    public function setName(String $name): void;

    public function setParentID(int $parentID): void;
}
