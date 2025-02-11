<?php
namespace App\Utils;

use FilesystemIterator;

class Utils
{

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
        $this->_path = '/var/www/html';
    }

    public function randomPic($dir)
    {
        $this->_files = glob($dir . '/*.*');
        if ($this->_files === false || empty($this->_files)) {
            error_log("No files found in directory: " . $dir);
            return false;
        }
        $this->_file_index = array_rand($this->_files);
        return $this->_files[$this->_file_index];
    }

    public function getDebug()
    {
        $this->_dir = $this->_path . "/public/dog";
        $this->_files = glob($this->_dir . '/*.*');
        if ($this->_files !== false) {
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
        if ($this->_dirs === false || empty($this->_dirs)) {
            error_log("No directories found in: " . $dir);
            return false;
        }
        $this->_rand_dir_index = array_rand($this->_dirs);
        return $this->_dirs[$this->_rand_dir_index];
    }

    public function readStats()
    {
        $filename = $this->_path . "/stats.json";
        if (!file_exists($filename)) {
            // Initialize the file if it doesn't exist
            file_put_contents($filename, json_encode(array("count" => 0)));
        }

        $handle = fopen($filename, 'r');
        if ($handle) {
            // Acquire a shared (read) lock
            flock($handle, LOCK_SH);
            $contents = fread($handle, filesize($filename));
            // Release the lock
            flock($handle, LOCK_UN);
            fclose($handle);

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

        // Open with c+ to create if doesn't exist and allow read/write
        $handle = fopen($filename, "c+");

        if ($handle) {
            try {
                // Acquire an exclusive lock
                if (flock($handle, LOCK_EX)) {
                    // Read current contents
                    $contents = fread($handle, filesize($filename) ?: 1);
                    $stats = json_decode($contents);

                    if (!$stats) {
                        // Initialize if invalid JSON or empty file
                        $stats = (object) array("count" => 0);
                    }

                    // Update the count
                    $stats->count++;

                    // Reset file pointer to beginning
                    ftruncate($handle, 0);
                    rewind($handle);

                    // Write new contents
                    $stats_encode = json_encode($stats);
                    fwrite($handle, $stats_encode);

                    // Release the lock
                    flock($handle, LOCK_UN);

                    return $stats_encode;
                }
                return 'Could not acquire lock in updateStats()';
            } finally {
                // Always close the handle
                fclose($handle);
            }
        }
        return 'Could not open file in updateStats()';
    }

    public function getDirNames()
    {
        $dir = $this->_path . "/public";
        $dirs = glob($dir . '/*/');
        $res = array();
        foreach ($dirs as $dirname) {
            $arr = explode('/', $dirname);
            $index = count($arr) - 2;
            $res[] = $arr[$index];
        }
        return $res;
    }

    public function getDirData()
    {
        $dir = $this->_path . "/public";
        $dirs = glob($dir . '/*/');
        $res = array();
        foreach ($dirs as $dirname) {
            $arr = explode('/', $dirname);
            $index = count($arr) - 2;
            $fi = new FilesystemIterator($this->_path . "/public/" . $arr[$index], FilesystemIterator::SKIP_DOTS);
            $res[] = array(
                "name" => $arr[$index],
                "total" => iterator_count($fi)
            );
        }
        return $res;
        // return json_encode($dirs);
    }

    public function getImageTotal()
    {
        $total = 0;
        foreach ($this->getDirNames() as $dir) {
            $fi = new FilesystemIterator($this->_path . "/public/" . $dir, FilesystemIterator::SKIP_DOTS);
            $total = $total + iterator_count($fi);
        }
        return $total;
    }

    public function genPic($t)
    {
        $haystack = $this->getDirNames();
        if (in_array($t, $haystack, true)) {
            $this->_dir = $this->_path . "/public/" . $t;
        } else {
            $randomDir = $this->randomDir($this->_path . "/public");
            if ($randomDir === false) {
                error_log("Failed to get random directory");
                return false;
            }
            $this->_dir = $randomDir;
        }

        $pic = $this->randomPic($this->_dir);
        if ($pic === false) {
            error_log("Failed to get random picture from " . $this->_dir);
            return false;
        }

        $this->updateStats();
        return $pic;
    }
}
