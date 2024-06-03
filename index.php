<?php
error_reporting(1);

require './vendor/autoload.php';

// Import all the needed classes
use Dotenv\Dotenv;
use FASTAPI\App;
use FASTAPI\Response;
use API\Routes;
use FASTAPI\CustomTime\CustomTime;

function errorHandler ($errNo, $errStr, $errFile, $errLine) {
    $time = (new CustomTime())->get_date('l jS \o\f F Y h:i:s A');
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $message = "[$time] - $ipAddress - " . implode('/', array_keys($_GET)) . " - " . $_SERVER['REQUEST_METHOD'] . ": [$errNo], $errLine, $errStr, $errFile \n";
    error_log($message, 3, 'error_log');
}

set_error_handler('errorHandler');


// Load Environmental Variables
$env = Dotenv::createImmutable(__DIR__);
$env->safeLoad();

$app = new App();

try {
    $pdo = new \PDO($_ENV['DB_HOST'],$_ENV['DB_USER'],$_ENV['DB_PASS']);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    (new Response())
    // ->setJsonResponse($_ENV)->send();
    ->setErrorResponse("Database Connection Error: " .$e->getMessage())->send();
}

// Landing Page Routes
$app->get('/', function(){
    (new Response())->setJsonResponse(
        ['error' => 0, 'message' => 'Haneef Network of Schools API V1', 'Date' => (new CustomTime())->get_date_instance()->format('Y-m-d H:i:s')]
    )->send();
});

$app->post('/', function(){
    (new Response())->setJsonResponse(
        ['error' => 0, 'message' => 'Haneef Network of Schools API V1', 'Date' => (new CustomTime())->get_date_instance()->format('Y-m-d H:i:s')]
    )->send();
});

(new Routes($app, $pdo))
    ->set_routes([
        ['url' =>'/setup', 'methods'=> ['get']],
        ['url'=> '/contact-us', 'methods'=> ['post']],
        // ['url'=> '/demo-request-doc', 'methods'=> ['get']],
    ])->load_routes();


$app->run();