<?php

class View
{
    protected $phpFile;
    
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

    public function displayError($error)
    {
        echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }

    public function __destruct()
    {
        unset($this->phpFile);
    }
}


?>