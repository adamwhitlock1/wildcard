<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once "./vendor/autoload.php";

use App\Utils;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Intervention\Image\ImageManager;

ini_set('error_log', '/Users/adam/Documents/GitHub/wildcard/logs/php_error.log');

$collector = new RouteCollector();

$collector->get('/', function () {
    require_once "index.view.php";
});

function useUtils()
{
    return new Utils\Utils();
}

$collector->get('/{t}/{w}/{h}', function ($t, $w, $h) {
    try {
        //create instance of image manager and use image magick for driver
        if ($w > 2000 || $h > 2000) {
            $w = 2000;
            $h = 2000;
        }

        $img = new ImageManager(array('driver' => 'imagick'));
        error_log("ImageManager created successfully");

        $path = useUtils()->genPic($t);
        error_log("Generated path: " . $path);

        if (!file_exists($path)) {
            error_log("Error: File does not exist at path: " . $path);
            return "Image not found";
        }

        // Set proper content type header
        header('Content-Type: image/jpeg');

        $image = $img->make($path);
        error_log("Image loaded successfully");

        $fitted = $image->fit($w, $h);
        error_log("Image fitted successfully");

        $response = $fitted->response('jpg', 60);
        error_log("Response generated successfully");

        unset($path);
        return $response;

    } catch (\Exception $e) {
        error_log("Error processing image: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        return "Error processing image: " . $e->getMessage();
    }
});

$collector->get('/stats', function () {
    return useUtils()->updateStats();
});

$collector->get('/homepage', function () {
    return json_encode(
        array(
            "dirName" => useUtils()->getDirNames(),
            "imageCount" => useUtils()->getImageTotal()
        )
    );
});

$collector->get('/data', function () {
    return json_encode(
        array(
            "dirName" => useUtils()->getDirData(),
            "totalImages" => useUtils()->getImageTotal(),
            "totalUsage" => useUtils()->readStats()->count,
            "debug" => useUtils()->getDebug()
        )
    );
});

$collector->get('/dirs', function () {
    return json_encode(useUtils()->getDirNames());
});


$dispatcher = new Dispatcher($collector->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
echo $response;

error_log('test');
