<?php
namespace App;

class Utils {

    private $_path;
    private $_dir;

    public function __construct()
    {
        $this->_path = $_SERVER['DOCUMENT_ROOT'];
    }

    public function getPath() {
        return $this->_path;
    }

    public function randomPic($dir)
    {
        $files = glob($dir . '/*.*');
        $file = array_rand($files);
        return $files[$file];
    }

    public function randomDir($dir)
    {
        $dirs = glob($dir . '/*/');
        $rand_dir = array_rand($dirs);
        return $dirs[$rand_dir];
    }

    public function genPic($t) {
        switch ($t) {
            case "r":
                $this->_dir = $this->randomDir($this->_path . "/public");
                break;
            case "bird":
                $this->_dir = $this->_path . "/public/bird";
                break;
            case "bug":
                $this->_dir = $this->_path . "/public/bug";
                break;
            case "cat":
                $this->_dir = $this->_path . "/public/cat";
                break;
            case "dog":
                $this->_dir = $this->_path . "/public/dog";
                break;
            case "fish":
                $this->_dir = $this->_path . "/public/fish";
                break;
            case "lion":
                $this->_dir = $this->_path . "/public/lion";
                break;
            case "tiger":
                $this->_dir = $this->_path . "/public/tiger";
                break;
        }
        return $this->randomPic($this->_dir);
    }
}
