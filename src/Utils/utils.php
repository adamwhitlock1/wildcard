<?php
namespace App;

class Utils {

    private $_path;
    private $_dir;

    public function __construct()
    {
        $this->_path = $_SERVER['DOCUMENT_ROOT'];
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

    public static function readStats()
    {
        return json_decode(file_get_contents("stats.json"));
    }

    public function updateStats()
    {
        $filename = $this->_path . "/stats.json";
        $contents = $this::readStats();

        $handle = fopen($filename, "w+");
        $stats = array( "count" => $contents->count + 1);
        fwrite($handle, json_encode($stats));
        fclose($handle);
        return json_encode($stats);
    }

    public function getDirNames(){
        $dir = $this->_path . "/public";
        $dirs = glob($dir . '/*/');
        $res = array();
        foreach ( $dirs as $dirname ) {
            $arr = explode('/', $dirname);
            $index = count($arr) - 2;
            $res[] = $arr[$index];
        }
        return $res;
        // return json_encode($dirs);
    }

    public function genPic($t)
    {
        $haystack = $this->getDirNames();
        if ( in_array($t, $haystack) ) {
            $this->_dir = $this->_path . "/public/" . $t;
        } else {
            $this->_dir = $this->randomDir($this->_path . "/public");
        }
        $this->updateStats();
        return $this->randomPic($this->_dir);
    }
}
