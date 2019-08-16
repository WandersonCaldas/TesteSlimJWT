<?php

require_once 'vendor/autoload.php';

use Slim\App;
use Slim\Middleware\TokenAuthentication;
use Lcobucci\JWT\Builder;

$authenticator = function($request, TokenAuthentication $tokenAuth){
    
    $token = $tokenAuth->findToken($request);
    
    $auth = new \app\Auth();
    
    $auth->getUserByToken($token);    
};

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

$app = new App($config);

$app->add(new TokenAuthentication([
    'path' =>   '/api',
    'passthrough' => '/api/auth', //Configure quais rotas não requerem autenticação, configurando-a na opção passthrough.
    'authenticator' => $authenticator,
    'secure' => true, //Habilitar HTTPS,
    'relaxed' => ['localhost']
]));

$app->get('/api', function($request, $response){
    $output = ['msg' => 'It is a public area'];          
    return $response->withJson($output, 200, JSON_PRETTY_PRINT);    
});

$app->post('/api/auth', function ($request, $response) {  
    $data = $request->getParsedBody();

    $auth = new \app\Auth();       
    $token = $auth->GerarToken($data['login'], $data['senha']);
    echo($token); 
});

$app->run();