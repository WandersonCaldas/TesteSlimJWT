<?php

namespace app;

require_once 'vendor/autoload.php';
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Auth
{    
    public function getUserByToken($token)
    {        
        if ($token != 'usertokensecret') {
                   
            throw new UnauthorizedException('TOKEN INVÁLIDO');
        }

        $user = [
            'name' => 'Dyorg',
            'id' => 1,
            'permisssion' => 'admin'
        ];

        return $user;
    }

    public function GerarToken($login, $senha) {
        $key = 'BFECC44AC8380E9B10310EE57BC2BB9E806C9922F12F601D1474B135C50D765A';
        
        $signer = new Sha256();
        $time = time();
        return (new Builder())->issuedAt($time) // Configures the time that the token was issue (iat claim)
                              ->canOnlyBeUsedAfter($time + 60) // Configures the time that the token can be used (nbf claim)
                              ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
                              ->withClaim('id', 1) // Configures a new claim, called "uid"                              
                              ->getToken($signer, new Key($key)); // Retrieves the generated token        
        
    }

}