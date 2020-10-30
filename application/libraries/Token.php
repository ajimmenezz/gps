<?php
namespace Libraries;

use \Firebase\JWT\JWT;
use \DomainException;
use \InvalidArgumentException;
use \UnexpectedValueException;

class Token{
    private $secretKey = "#!UniversalP0w3r.";
    private $jwt;
    public function __construct(){
        $this->jwt = new JWT();
    }

    public function clearToken($token){
        $token= str_replace('BEARER', '', $token);
        $token= str_replace('Bearer', '', $token);
        $token= str_replace('bearer', '', $token);
        $token = trim($token);
        return $token;
    }
    public function validateToken($token){
        $token = $this->clearToken($token);
        $payload = $this->decode($token);
        return true;
    }

    public function getUserID($token){
        $token = $this->clearToken($token);

        $payload = $this->decode($token);
        return $payload['userID'];
    }

    public function getTokenType($token){
        $token = $this->clearToken($token);

        $payload = $this->decode($token);
        return $payload['tokenType'];
    }

    public function encode($payload, $timestampExpiration = null){
        $date = new \DateTime();
        $payload['iat'] = $date->getTimestamp();

        if($timestampExpiration != null){
            $payload->exp = $date->getTimestamp()+180;
        }

        return $this->jwt->encode($payload, $this->secretKey);
    }

    public function decode($token){
        $token = $this->clearToken($token);
        
        $decoded = $this->jwt->decode($token, $this->secretKey, array('HS256'));
        $payload = (array) $decoded;

        return $payload;
    }

}