<?php

class View
{
    private $phpFile;
    
    public function __construct($phpFile)
    {
        $this->phpFile = $phpFile;
    }

    public function render()
    {
        require $this->phpFile;
    }

    public function getPhpFile()
    {
        return $this->phpFile;
    }

    public function setPhpFile($phpFile)
    {
        $this->phpFile = $phpFile;
    }
}


?>