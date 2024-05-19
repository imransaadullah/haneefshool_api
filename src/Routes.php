<?php

namespace API;

use FASTAPI\Response;
use FASTAPI\StringMethods;
use API\Mailer;

class Routes 
{
    private $routes;
    private $app;
    private $db_driver;
    private $route_dimiter = '-';
    private $method_dimiter = '_';

    public function __construct(\FASTAPI\App $app, \PDO $pdo)
    {
        $this->app = $app;
        $this->db_driver = $pdo;
    }

    public function set_routes(array $routes): self
    {
        $this->routes = $routes;
        return $this;
    }

    public function setup(\FASTAPI\Request $request)
    {
        (new Response())->setJsonResponse([
            'error' => ['Landing Page Setup' => (new Landing($this->db_driver))->setup()]
        ])->send();
    }

    public function test_mail(\FASTAPI\Request $request)
    {
        (new Response())->setBody(
            Mailer::sendmail('New Demo Request', 'Testing Mails', 'imransaadullah@gmial.com', "Imran", false)
        )->send();
    }

    public function create_user(\FASTAPI\Request $request)
    {
        $response = new Response();
        $data = $request->getData();

        // $required_fields = ['email', 'first_name', 'last_name', 'password', 'confirm_password'];
        // $submitted_keys = array_keys($data);
        // $missing_keys = array_diff($required_fields, $submitted_keys);

        // if (!empty($missing_keys)) {
        //     $message = "These feild(s) (" . implode(", ", $missing_keys) . ") are mandatory. kindly check " . $request->getMethod() . "-doc";
        //     $response->setJsonResponse(['error' => 1, 'message' => $message], 420);
        // } else {
        //     if($data['password'] != $data['confirm_password']){
        //         $message = "Password and confirm_password must match. kindly check you password and try again";
        //         $response->setJsonResponse(['error' => 1, 'message' => $message], 421);
        //     }else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        //         $message = 'Invalid Email, kindly make necessary adjustments and try again.';
        //         $response->setJsonResponse(['error' => 1, 'message' => $message], 422);
        //     }else if((new ClientModel($this->db_driver))->getUser($data['email'])){
        //         $message = 'User Already Exists, kindly login if this is not a mistake.';
        //         $response->setJsonResponse(['error' => 1, 'message' => $message], 423);
        //     }else{
        //         unset($data['confirm_password']);
		// 	    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        //         $insertOperation = (new ClientModel($this->db_driver))->createUser($data);
        //         if ($insertOperation) {
        //             $message = 'Welcome TO Aman HMO';
        //             Mailer::sendmail('Welcome To Aman HMO', $message, $data['email'], $data['first_name']." ".$data['last_name'], false);
        //             $response->setJsonResponse(['error' => 0, 'message' => 'User Account Created Successfully']);
        //         } else {
        //             $response->setJsonResponse(['error' => 1, 'message' => 'Unable To Create User Account, Kindly Call Customer Representative Number.'], 400);
        //         }
        //     }
        // }
        $response->send();
    }

    public function contact_us(\FASTAPI\Request $request)
    {
        $response = new Response();
        $data = $request->getData();
        $response->setJsonResponse(['success' => 0, 'message' => 'Welcome', 'data' => $data]);
        // $insertOperation = (new ContactUsModel($this->db_driver, 'demo-requests'))->insertData($data);
        // if(is_array($insertOperation)){
        //     $message = "These feild(s) (". implode(", ", $insertOperation) .") are mandatory. kindly check " . $request->getMethod() . "-doc" ;
        //     $response->setJsonResponse(['error' => 1,'message'=> $message], 428);
        // }elseif($insertOperation){
        //     Mailer::sendmail('New Demo Request',$data['message'], $data['email'], $data['full_name'], true);
        //     $response->setJsonResponse(['error'=> 0,'message'=> 'Demo Request Submitted Successfully']);
        // }else{
        //     $response->setJsonResponse(['error'=> 0,'message'=> 'Unable To Submit Demo-Request, Kindly Call Customer Representative Number.'], 400);
        // }

        $response->send();
    }

    public function login(\FASTAPI\Request $request)
    {
        // $response = new Response();
        // $data = $request->getData();
        // $insertOperation = (new ContactUsModel($this->db_driver, 'demo-requests'))->insertData($data);
        // if(is_array($insertOperation)){
        //     $message = "These feild(s) (". implode(", ", $insertOperation) .") are mandatory. kindly check " . $request->getMethod() . "-doc" ;
        //     $response->setJsonResponse(['error' => 1,'message'=> $message], 428);
        // }elseif($insertOperation){
        //     Mailer::sendmail('New Demo Request',$data['message'], $data['email'], $data['full_name'], true);
        //     $response->setJsonResponse(['error'=> 0,'message'=> 'Demo Request Submitted Successfully']);
        // }else{
        //     $response->setJsonResponse(['error'=> 0,'message'=> 'Unable To Submit Demo-Request, Kindly Call Customer Representative Number.'], 400);
        // }

        // $response->send();
    }

    public function create_user_doc(\FASTAPI\Request $request)
    {
        $response = new Response();
        // $response->setBody("<pre>".RequirementDocs::createUser().'</pre>');
        $response->send();
    }

    public function login_doc(\FASTAPI\Request $request)
    {
        $response = new Response();
        // $response->setBody("<pre>".RequirementDocs::createUser().'</pre>');
        $response->send();
    }

    public function get_routes()
    {
        return $this->routes;
    }

    public function load_routes()
    {
        foreach ($this->routes as $route) {
            foreach ($route['methods'] as $methodName) {
                if (method_exists($this->app, $methodName)) {
                    $method = StringMethods::replaceString($route['url'], $this->route_dimiter, $this->method_dimiter);
                    $handler = [$this, StringMethods::replaceString($method, '/', '')];
                    if (is_callable($handler)) {
                        // (new Response())->setJsonResponse([$handler, $method])->send();
                        $this->app->$methodName($route['url'], $handler);
                    } else {
                        (new Response())->setErrorResponse('Undefined Handler for ' . $route['url'] . '.')->send();
                    }
                } else {
                    (new Response())->setErrorResponse('Method does not exist.');
                }
            }
        }
    }
}
