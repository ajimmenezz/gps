<?php


/**
 * @api {post} /accounts Registrar Cuenta
 * @apiName PostAccounts
 * @apiGroup Clientes
 * @apiDescription Realiza el Registro un nuevo cliente o distribuidor en la plataforma
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {object} account Objeto que contiene la informacion de la nueva cuenta
 * @apiParam {int} account.type Tipo de cuenta (Cliente o Distribuidor) 
 * @apiParam {string} account.name Nombre de la cuenta
 * @apiParam {string} account.email Correo de la cuenta
 * 
 * @apiParam {object} legal Objecto que contiene la informacion de los datos legales y/o para facturacion
 * @apiParam {int} legal.status Estado legal del la cuenta
 * @apiParam {string} legal.name Nombre legal de la compañia o del representante legal 
 * @apiParam {string} legal.country Pais
 * @apiParam {string} legal.region Region o Estado
 * @apiParam {string} legal.zipcode Codigo postal
 * @apiParam {string} legal.notes notas adicionales
 * @apiParam {string} legal.address Direccion
 * @apiParam {string} legal.id RFC o ID legal
 * 
 * @apiParam {array} contacts Arreglo que contiene objectos contacto
 * @apiParam {object} contact Objecto que representa un contacto
 * @apiParam {string} contact.type Tipo de contacto 
 * @apiParam {string} contact.name Nombre del contacto
 * @apiParam {string} contact.phone Telefono local o de oficina del contacto
 * @apiParam {string} contact.cel Telefono celular del contacto
 * @apiParam {string} contact.email Correo del contacto
 * @apiParam {string} contact.notes Notas adicionales
 * 
 * @apiParamExample {json} Request-Example:
 * {"account":{"type":2,"name":"distribuidor avilex","email":"naviles@globalgps.com.mx"},"legal":{"status":1,"name":"aviles sa de cv","country":"Mexico","region":"Morelos","zipcode":62460,"notes":"notas varias","address":"direccion","id":"RFC123456"},"contacts":[{"type":1,"name":"noe aviles","phone":"123456","cel":"777123456","email":"contact@email","notes":"notas contact"},{"type":2,"name":"marco aviles","phone":"22222","cel":"77733333","email":"contact2@email","notes":"notas 2 contact"}]}
 * 
 * @apiUse SuccessOK
 * 
 * 
*/

/**
 * @api {get} /accounts Lista de clientes
 * @apiName GetAccounts
 * @apiGroup Clientes
 * @apiDescription Obtiene la lista de clientes de un cliente (distribuidor / administrador)
 * 
 * @apiUse RequireAuth
 * @apiParam {int} [status] Estado de los clientes (Activos, Elimindos). si no se especifica la funcion devolvera los clientes activos
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"customers":[{"id":"3","clientTypeID":"1","clientType":"CLIENTE","customer":"aviles","creationTimestamp":"0"},{"id":"4","clientTypeID":"1","clientType":"CLIENTE","customer":"maguersa","creationTimestamp":"1576882215"}]}}
 * 
 * @apiSuccess {array} customer Arreglo que contine informacion de cada cliente
 * @apiSuccess {object} client Objeto que representa un cliente
 * @apiSuccess {int} product.id ID del cliente
 * @apiSuccess {int} product.clientTypeID ID del tipo de cliente
 * @apiSuccess {string} product.clientType Tipo de cliente
 * @apiSuccess {string} product.customer Nombre de la cuenta / cliente
 * @apiSuccess {long} product.creationTimestamp Fecha de registro
*/


/**
 * @api {get} /accounts/:id Informacion del cliente
 * @apiName GetAccount
 * @apiGroup Clientes
 * @apiDescription Obtiene informacion de una cuenta
 * @apiUse InformacionDeCliente
 * @apiUse RequireAuth
 */

 /**
 * @apiDefine InformacionDeCliente
 * @apiParam {int} id ID del cliente a consultar
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"customer":{"id":"3","ownerID":"2","clientTypeID":"1","clientType":"CLIENTE","account":"aviles","creationTimestamp":"0","legal":{"statusID":"1","status":"NINGUNO","name":"NOE AVILES","country":"MEXICO","region":"MORELOS","zipCode":"62460","note":null,"taxID":null},"contacts":[{"id":"3","contactTypeID":"3","contactType":"RESPONSABLE","name":"Noe ","phone":"123456","cel":"789456","email":"naviles@globalgps.com.mx","creationTimestamp":"1579043528","notes":null}]}}}
 * 
 * @apiSuccess {object} customer Objeto que contine la informacion del cliente
 * @apiSuccess {int} customer.id ID de la cuenta
 * @apiSuccess {int} customer.ownerID ID del propietario de la cuenta
 * @apiSuccess {int} customer.clientTypeID ID del tipo de cliente
 * @apiSuccess {string} customer.clientType Tipo de cliente
 * @apiSuccess {string} customer.account Nombre de la cuenta / cliente
 * @apiSuccess {long} customer.creationTimestamp Fecha de registro
 * @apiSuccess {object} legal Objeto que contiene la informacion legal y de facturacion
 * @apiSuccess {int} legal.statusID ID del estado legal
 * @apiSuccess {string} legal.status Estado legal (Persona Fisica, Moral o ninguno)
 * @apiSuccess {string} legal.name Nombre legal o Razon Social
 * @apiSuccess {string} legal.country Pais
 * @apiSuccess {string} legal.region Ciudad o region
 * @apiSuccess {int} legal.zipCode Codigo Postal
 * @apiSuccess {string} legal.notes Notas adicionales
 * @apiSuccess {string} customer.taxID RFC o ID legal
 * @apiSuccess {array} contacts Arreglo que contiene informacion de los contactos
 * @apiSuccess {object} contact Representa un contacto
 * @apiSuccess {int} contact.id ID del contacto
 * @apiSuccess {int} contact.contactTypeID ID del tipo de contacto
 * @apiSuccess {string} contact.contactType Tipo de contacto
 * @apiSuccess {string} contact.name Nombre del contacto
 * @apiSuccess {string} contact.phone Numero de telefono del contacto
 * @apiSuccess {string} contact.cel Numero celular del contacto
 * @apiSuccess {string} contact.email Correo electronico del contacto
 * @apiSuccess {string} contact.creationTimestamp Fecha de registro del contacto
 * @apiSuccess {string} contact.notes Notas adicionales
 * 
*/

/**
 * @api {put} /accounts/:id Actualizar cliente
 * @apiName PutAccount
 * @apiGroup Clientes
 * @apiDescription Actualiza la informacion del cliente
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del cliente a actualizar
 * @apiUse UdpdateInformacionDeCliente
 */

/** 
 * @apiDefine UdpdateInformacionDeCliente
 * @apiParam {object} customer Objeto que contine la informacion del cliente
 * @apiParam {object} legal Objeto que contiene la informacion legal y de facturacion
 * @apiParam {string} [legal.statusID] ID del estado legal (Persona Fisica, Moral o ninguno)
 * @apiParam {string} [legal.name] Nombre legal o Razon Social <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParam {string} [legal.country] Pais <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParam {string} [legal.region] Ciudad o region <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParam {int} [legal.zipCode] Codigo Postal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParam {string} [legal.notes] Notas adicionales <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParam {string} [legal.taxID] RFC o ID legal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParam {string} [legal.address] Direccion legal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio 
 * @apiParamExample {json} Example
 * {"customer":{"legal":{"country":"MEXICO","region":"MORELOS","address":"Azucena 140","zipCode":"62000","notes":"","taxID":""}}}
*/


/**
 * @api {post} /accounts/:id/contacts Registrar contacto a cliente
 * @apiName PostAccountContact
 * @apiGroup Clientes
 * @apiDescription Registra un nuevo contacto a un cliente determinado
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del cliente a actualizar
 * @apiUse CreateContact
 */

/**
 * @api {post} /accounts/contacts Registrar contacto
 * @apiName PostMyAccountContact
 * @apiGroup Clientes
 * @apiDescription Registra un nuevo contacto
 * @apiUse RequireAuth
 * 
 * @apiUse CreateContact
 */

 /** 
 * @apiDefine CreateContact
 * @apiParam {object} contact Objeto que contine la informacion del contacto
 * @apiParam {int} contact.contactType Tipo de contacto
 * @apiParam {string} contact.name Nombre del contacto 
 * @apiParam {string} contact.phone Telefono
 * @apiParam {string} contact.cel Telefono celular 
 * @apiParam {string} contact.email Correo electronico
 * @apiParam {string} contact.notes Notas adicionales 
 *
 * @apiParamExample {json} Example
 * {"contact":{"contactType":1,"name":"new name","phone":"123456","cel":"777123456","email":"email","notes":"some notes"}}
*/



/**
 * @api {delete} /accounts/contacts/:id Eliminar contacto
 * @apiName DeleteContact
 * @apiGroup Clientes
 * @apiDescription Elimina un contacto
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del contacto a eliminar
 */

/**
 * @api {put} /accounts/:id/status Suspender Cuenta
 * @apiName PutAccountStatus
 * @apiGroup Clientes
 * @apiDescription Actualiza el estado de una cuenta (suspender)
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID de la cuenta a suspender
 * @apiParam {bool} status Indica el estado de la cuenta <br> True = Cuenta activa <br> False = Cuenta suspendida
 * @apiParamExample Ejemplo
 * {"status":false}
 * 
 * @apiUse SuccessOK
 */