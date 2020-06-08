<?php
namespace src\Floor;

/*
Abstract Floor class used to share common properties among different types of floors
like total area to be cleaned or cleaned area.
*/
abstract class Floor
{
    protected $totalArea;
    protected $cleanedArea;
    public function __construct(int $totalArea)
    {
        $this->totalArea = $totalArea;
        $this->cleanedArea = 0;
    }

    public function getTotalArea()
    {
        return $this -> totalArea;
    }
    
    public function setTotalArea($totalArea)
    {
        $this -> totalArea = $totalArea;
    }

    public function getCleanedArea()
    {
        return $this -> cleanedArea;
    }
    
    public function setCleanedArea($cleanedArea)
    {
        $this -> cleanedArea = $cleanedArea;
    }
}
