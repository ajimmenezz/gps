<?php
namespace Libraries;

use Libraries\Token;
use Models\DataBaseUser;

class Authorization{
    private $token;
    private $databaseUser;
    public function __construct() {
        $this->token = new Token();
        $this->databaseUser = new DataBaseUser();
    }

    public function validateToken($tokenString){
        try{
            $this->token->validateToken($tokenString);    
        }
        catch(ExpiredException $err){
            throw new HttpException("TOKEN_EXPIRED","El token ha expirado", HttpStatusCode::HTTP_UNAUTHORIZED);
        }
        catch(SignatureInvalidException $err){
            throw new HttpException("INVALID_TOKEN","La firma del token es invalida", HttpStatusCode::HTTP_UNAUTHORIZED);
        }
        catch(Exception $err){
            throw new HttpException("INVALID_TOKEN","El token es invalido", HttpStatusCode::HTTP_UNAUTHORIZED);
        }

        $data = $this->getTokenData($tokenString);
        $this->validateSession($data->userID);

        return true;
    }

    public function getTokenData($tokenString){
        try{
            return (object) $this->token->decode($tokenString);
        }
        catch(Exception $err){
            return new \stdClass();
        }
        
    }

    public function validateSession($userID){
        $status = $this->databaseUser->getStatus($userID);
        if($status->distributorStatus)
        {
            if($status->clientStatus){
                if($status->userStatus)
                    return true;
                else
                    throw new HttpException("USER_SUSPEND","El usuario se encuentra suspendido", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
            else
                throw new HttpException("ACCOUNT_SUSPEND","La cuenta se encuentra suspendida", HttpStatusCode::HTTP_UNAUTHORIZED);
        }
        else
            throw new HttpException("PROVIDER_SUSPEND","El proovedor se encuentra suspendido", HttpStatusCode::HTTP_UNAUTHORIZED);      
    }
}