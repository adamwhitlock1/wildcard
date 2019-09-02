<?php
require_once "vendor/autoload.php";

use App\Utils;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Intervention\Image\ImageManager;

$collector = new RouteCollector();

$collector->get('/', function(){
    require_once "index.view.php";
});


$collector->get('/{t}/{w}/{h}', function($t, $w, $h ){
    //create instance of image manager and use image magick for driver
    if ($w > 2000 || $h > 2000) {
        $w = 2000;
        $h = 2000;
    }
    $img = new ImageManager(array('driver' => 'imagick'));
    $utils = new Utils();
    $path = $utils->genPic($t);
    return $img->make($path)->fit($w, $h)->response("jpg", 60);
});

$dispatcher = new Dispatcher($collector->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
echo $response;



//echo json_encode($path);






