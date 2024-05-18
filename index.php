<?php

require './vendor/autoload.php';

// Import all the needed classes
use Dotenv\Dotenv;
use FASTAPI\App;
use FASTAPI\Response;
use API\Routes;
use FASTAPI\CustomTime\CustomTime;

// Load Environmental Variables
$env = Dotenv::createImmutable(__DIR__);
$env->safeLoad();

$app = new App();

try {
    $pdo = new \PDO($_ENV['DB_HOST_APP_LOCAL'],$_ENV['DB_USER_APP_LOCAL'],$_ENV['DB_PASS_APP_LOCAL']);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    (new Response())->setErrorResponse("Database Connection Error: " .$e->getMessage())->send();
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
        ['url' =>'/setup', 'method'=> 'get'],
        ['url'=> '/contact_us', 'method'=> 'post'],
        ['url'=> '/demo-request-doc', 'method'=> 'get'],
    ])->load_routes();


$app->run();