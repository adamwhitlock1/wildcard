<?php
namespace App;

use FilesystemIterator;

class Utils {

    /** @var string */
    private $_path;

    /** @var string */
    private $_dir;

    /** @var array|false */
    private $_dirs;

    /** @var int */
    private $_rand_dir_index;

    /** @var array|false */
    private $_files;

    /** @var int */
    private $_file_index;

    public function __construct()
    {
        $this->_path = $_SERVER['DOCUMENT_ROOT'];
    }

    public function randomPic($dir)
    {
        $this->_files = glob($dir . '/*.*');
        if ( $this->_files !== false ) {
            $this->_file_index = intval(array_rand($this->_files));
        }
        return $this->_files[$this->_file_index];
    }

    public function getDebug() {
        $this->_dir = $this->_path . "/public/dog";
        $this->_files = glob($this->_dir . '/*.*');
        if ( $this->_files !== false ) {
            $this->_file_index = intval(array_rand($this->_files));
        }
        return gettype($this->_files);
    }

    /**
     * @param $dir string
     * @return string
     */
    public function randomDir($dir)
    {
        $this->_dirs = glob($dir . '/*/');
        if ( $this->_dirs !== false ) {
            $this->_rand_dir_index = intval(array_rand($this->_dirs));
            return $this->_dirs[$this->_rand_dir_index];
        }
        return "error getting random directory";
    }

    public function readStats()
    {
        $contents = file_get_contents("stats.json");
        if ($contents) {
            return json_decode($contents);
        }
        return false;
    }


    /**
     * @return bool|false|string
     */
    public function updateStats()
    {
        $filename = $this->_path . "/stats.json";
        $contents = $this->readStats();
        if ($filename) {
            return false;
        }
        $handle = fopen($filename, "w+");
        $stats = array( "count" => $contents->count + 1);
        if ($handle) {
            $stats_encode = json_encode($stats);
            if ($stats_encode) {
                fwrite($handle, $stats_encode);
            }
            fclose($handle);
            return json_encode($stats);
        }
        return false;
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
    }

    public function getDirData(){
        $dir = $this->_path . "/public";
        $dirs = glob($dir . '/*/');
        $res = array();
        foreach ( $dirs as $dirname ) {
            $arr = explode('/', $dirname);
            $index = count($arr) - 2;
            $fi = new FilesystemIterator($this->_path . "/public/" . $arr[$index], FilesystemIterator::SKIP_DOTS);
            $res[] = array (
                "name" => $arr[$index],
                "total" => iterator_count($fi)
            );
        }
        return $res;
        // return json_encode($dirs);
    }

    public function getImageTotal() {
        $total = 0;
        foreach ($this->getDirNames() as $dir){
            $fi = new FilesystemIterator($this->_path . "/public/" . $dir, FilesystemIterator::SKIP_DOTS);
            $total = $total + iterator_count($fi);
        }
        return $total;

    }

    public function genPic($t)
    {
        $haystack = $this->getDirNames();
        if ( in_array($t, $haystack, true) ) {
            $this->_dir = $this->_path . "/public/" . $t;
        } else {
            $this->_dir = $this->randomDir($this->_path . "/public");
        }
        $this->updateStats();
        return $this->randomPic($this->_dir);
    }
}
