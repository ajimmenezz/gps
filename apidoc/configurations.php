<?php

/**
 * @api {put} /configuration/eventpassword Actualizar contraseña de eventos
 * @apiName PutEventPassword
 * @apiGroup Configuration
 * @apiDescription Define / actualiza la contraseña de eventos
 * 
 * @apiUse RequireAuth
 * @apiParam {string} password Contraseña que se actualizara
 * @apiUse SuccessOK
 *
*/


/**
 * @api {get} /configuration/eventpassword/exists Comprobar existencia de contraseña de eventos
 * @apiName GetEventPasswordExists
 * @apiGroup Configuration
 * @apiDescription Consulta si la cuenta tiene definida una contraseña de eventos
 * 
 * @apiUse RequireAuth
 * @apiSuccess {boolean} eventPasswordExists Indica si la cuenta tiene contraseña definida.
 *
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"eventPasswordExists":true}}
*/

/**
 * @api {get} /configuration/eventpassword/expiration Comprobar expiracion de contraseña de eventos
 * @apiName GetEventPasswordExpiration
 * @apiGroup Configuration
 * @apiDescription Consulta el timestamp de expiracion de la contraseña de eventos
 * 
 * @apiUse RequireAuth
 * @apiSuccess {int} timestampExpiration timestamp que indica cuando expira la contraseña de eventos
 * 
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"timestampExpiration":"1568844000"}}
 *
*/

/**
 * @api {get} /configuration/eventpassword/validate Comprobar si la contraseña de eventos es correcta
 * @apiName GetEventPasswordValidate
 * @apiGroup Configuration
 * @apiDescription Comprueba si la contraseña de eventos es valida
 * 
 * @apiUse RequireAuth
 * @apiParam {string} password Contraseña a comprobar
 * 
 * @apiSuccess {boolean} isValidEventPassword resultado de comprobar si la contraseña de eventos es valida
 * 
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"isValidEventPassword":true}}
 *
*/


/**
 * @api {get} /configuration/account Informacion de la cuenta
 * @apiName GetMyAccountInfo
 * @apiGroup Configuration
 * @apiDescription Obtiene informacion de la cuenta
 * @apiUse InformacionDeCliente
 * @apiUse RequireAuth
 */


 /**
 * @api {put} /configuration/account Actualizar datos de la cuenta
 * @apiName PutMyAccountInfo
 * @apiGroup Configuration
 * @apiDescription Actualiza la informacion de la cuenta
 * @apiUse RequireAuth
 * @apiUse UdpdateInformacionDeCliente
 */