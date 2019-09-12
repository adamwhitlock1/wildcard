<?php
require_once "../vendor/autoload.php";

use App\Utils;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Intervention\Image\ImageManager;

$collector = new RouteCollector();

$collector->get('/', function(){
    require_once "index.view.php";
});

function useUtils() {
    return new Utils();
}

$collector->get('/{t}/{w}/{h}', function($t, $w, $h ){
    //create instance of image manager and use image magick for driver
    if ($w > 2000 || $h > 2000) {
        $w = 2000;
        $h = 2000;
    }
    $img = new ImageManager(array('driver' => 'imagick'));
    $path = useUtils()->genPic($t);
    $response = $img->make($path)->fit($w, $h)->response("jpg", 60);
    unset($path);
    return $response;
});

$collector->get('/stats', function() {
    return useUtils()->updateStats();
});

$collector->get('/homepage', function() {
    return json_encode(
        array(
            "dirName" => useUtils()->getDirNames(),
            "imageCount" => useUtils()->getImageTotal()
        )
    );
});

$collector->get('/data', function() {
    return json_encode(
        array(
            "dirName" => useUtils()->getDirData(),
            "totalImages" => useUtils()->getImageTotal(),
            "totalUsage" => useUtils()->readStats()->count
        )
    );
});

$collector->get('/dirs', function() {
    return json_encode(useUtils()->getDirNames() );
});


$dispatcher = new Dispatcher($collector->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
echo $response;



//echo json_encode($path);






