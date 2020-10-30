<?php

/**
 * @api {post} /transfers Registrar Transferencia
 * @apiName PostTransfer
 * @apiGroup Transferencias
 * @apiDescription Registra una nueva transferencia
 * 
 * @apiUse RequireAuth
 * @apiParam {object} transfer Objeto que contiene la informacion de la transferencia
 * @apiParam {int} [tranfer.clientID] ID del cliente al que se le enviaran los productos <br><b>NOTA: </b>Si este valor no es proporcionado, la transferencia sera considerada como devolucion, por lo que la transferencia estara dirigida hacia el distribuidor del cliente que realiza la accion
 * @apiParam {string} tranfer.notes Notas adicionales
 * @apiParam {array} products Arreglo de productos involucrados en la transferencia
 * @apiParam {int} product.id ID del producto
 * @apiParam {int} product.type Tipo de producto 
 * 
 * @apiParamExample {json} Request-Example 1:
 * {"transfer":{"clientID":2,"notes":""},"products":[{"type":2,"id":6},{"type":1,"id":7},{"type":3,"id":8}]}
 * 
 * @apiSuccess {int} transferID ID de la transferencia 
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"transferID":"19"}}
 */


 /**
 * @api {get} /transfers Consultar Transferencias
 * @apiName GetTransfers
 * @apiGroup Transferencias
 * @apiDescription Consulta las transferenceias realizadas
 * 
 * @apiUse RequireAuth
 * @apiParam {int} [tranfer.clientID] ID del cliente que estuvo involucrado en transferencias con el ID del cliente que realiza la solicitud es decir transferencias entre 2 clientes especificos. el cliente que realiza la peticion y el cliente que se proporciona en este parametro <br><b>NOTA: </b>Si no se proporciona este parametro, los resultados seran todas las transferencias en las que el cliente que realiza la peticion estuvo involucrado
 * @apiParam {int} [fromTimestamp] Consulta transferencias desde la fecha proporcionada
 * @apiParam {int} [toTimestamp] Consulta transferencias hasta la fecha proporcionada
 * @apiParam {array} [transferStates] Consulta las transferencias donde el estado de la transferencia coincida con los valores proporcionados. <br><b>Nota:</b> Si no se proporciona devolvera todas las tranferencias sin distincion de su estado
 * @apiParam {array} [transferTypes] Consulta las transferencias donde el tipo de transferencia coincida con los valores proporcionados <br><b>Nota: </b> Si no se proporciona se devolveran todas las transferencias sin importar el tipo de transferencia
 * @apiParam {int} [limit] Limite de registros por consulta
 * 
 * @apiParamExample {json} Request-Example 1:
 * {{url}}/transfers?clientID=3&transferStates[]=1&transferStates[]=2&transferTypes[]=1&transferTypes[]=2
 * 
 * @apiParamExample {json} Request-Example 2:
 * {{url}}/transfers?fromTimestamp=123456&transferTypes[]=1&transferTypes[]=2
 * 
 * @apiSuccess {array} transfers Arreglo que contiene las transferencias
 * @apiSuccess {int} transfer.id ID de la transferencia
 * @apiSuccess {int} transfer.fromClientID ID del cliente que realiza la transferencia
 * @apiSuccess {string} transfer.fromClient Nombre del cliente que realiza la transferencia
 * @apiSuccess {int} transfer.toClientID ID del cliente que recibe la transferencia
 * @apiSuccess {string} transfer.toClient Nombre del cliente que recibe la transferencia
 * @apiSuccess {int} transfer.typeID Tipo de transferencia
 * @apiSuccess {string} transfer.type Tipo de transferencia
 * @apiSuccess {int} transfer.stateID Estado de la transferencia
 * @apiSuccess {string} transfer.state Estado de la transferencia
 * @apiSuccess {int} transfer.creationTimestamp Fecha en la que se registro la tranferencia
 * @apiSuccess {string} transfer.notes Notas adicionales
 * @apiSuccess {int=1,0} transfer.isTransferReceived Indica si la transferencia fue enviada al cliente que realiza la peticion
 *  
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"transfers":[{"id":"32","fromClientID":"4","fromClient":"maguersa","toClientID":"2","toClient":"gps infinity","typeID":"2","type":"DEVOLUCION","stateID":"2","state":"COMPLETADO","creationTimestamp":"1580407888","notes":null,"isReceivedTransfer":"1"},{"id":"31","fromClientID":"1","fromClient":"administrador","toClientID":"2","toClient":"gps infinity","typeID":"1","type":"TRANSFERENCIA","stateID":"1","state":"PENDIENTE","creationTimestamp":"1580337907","notes":null,"isReceivedTransfer":"1"},{"id":"28","fromClientID":"2","fromClient":"gps infinity","toClientID":"1","toClient":"administrador","typeID":"2","type":"DEVOLUCION","stateID":"2","state":"COMPLETADO","creationTimestamp":"1580325076","notes":"transferencia de prueba","isReceivedTransfer":"0"},{"id":"27","fromClientID":"2","fromClient":"gps infinity","toClientID":"1","toClient":"administrador","typeID":"2","type":"DEVOLUCION","stateID":"3","state":"CANCELADO","creationTimestamp":"1580325074","notes":"transferencia de prueba","isReceivedTransfer":"0"},{"id":"26","fromClientID":"2","fromClient":"gps infinity","toClientID":"4","toClient":"maguersa","typeID":"1","type":"TRANSFERENCIA","stateID":"1","state":"PENDIENTE","creationTimestamp":"1580325067","notes":"transferencia de prueba","isReceivedTransfer":"0"},{"id":"25","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","typeID":"1","type":"TRANSFERENCIA","stateID":"1","state":"PENDIENTE","creationTimestamp":"1580325045","notes":"transferencia de prueba","isReceivedTransfer":"0"},{"id":"24","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","typeID":"1","type":"TRANSFERENCIA","stateID":"1","state":"PENDIENTE","creationTimestamp":"1580325042","notes":"transferencia de prueba","isReceivedTransfer":"0"},{"id":"23","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","typeID":"1","type":"TRANSFERENCIA","stateID":"3","state":"CANCELADO","creationTimestamp":"1580325041","notes":"transferencia de prueba","isReceivedTransfer":"0"},{"id":"22","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","typeID":"1","type":"TRANSFERENCIA","stateID":"2","state":"COMPLETADO","creationTimestamp":"1580325037","notes":"transferencia de prueba","isReceivedTransfer":"0"}]}}
 */


 /**
 * @api {get} /transfers/:id Consultar Transferencia
 * @apiName GetTransfer
 * @apiGroup Transferencias
 * @apiDescription Consulta los detalles de una transferencia especifica
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la transferencia a consultar
 * 
 * @apiSuccess {object} transfer Objeto que contiene la informacion del la transferencia
 * @apiSuccess {int} transfer.id ID de la transferencia a consultar
 * @apiSuccess {int} transfer.fromClientID ID del cliente que realiza la transferencia
 * @apiSuccess {string} transfer.fromClient Nombre del cliente que realiza la transferencia
 * @apiSuccess {int} transfer.toClientID ID del cliente que recibe la transferencia
 * @apiSuccess {string} transfer.toClient Nombre del cliente que recibe la transferencia
 * @apiSuccess {int} transfer.typeID Tipo de transferencia
 * @apiSuccess {string} transfer.type Tipo de transferencia
 * @apiSuccess {int} transfer.stateID Estado de la transferencia
 * @apiSuccess {string} transfer.state Estado de la transferencia
 * @apiSuccess {int} transfer.creationTimestamp Fecha en la que se registro la tranferencia
 * @apiSuccess {string} transfer.notes Notas adicionales
 * 
 * @apiSuccess {array} products Arreglo que contiene los productos involucrados en la transferencia
 * @apiSuccess {int} product.transferID ID de la transferencia
 * @apiSuccess {int} product.typeID Tipo de producto
 * @apiSuccess {int} product.type Tipo de producto
 * @apiSuccess {int} product.stateID Estado de la transferencia
 * @apiSuccess {int} product.state Estado de la transferencia
 * @apiSuccess {int} product.productID ID del producto
 * @apiSuccess {int} product.serie Imei/Serie/Telefono del producto
 * @apiSuccess {int} product.factoryID Marca del producto
 * @apiSuccess {int} product.factory Marca del producto
 * @apiSuccess {int} product.modelID Modelo del producto
 * @apiSuccess {int} product.model Modelos del producto
 * 
 * @apiSuccess {array} bitacora Arreglo que contiene los registros de bitacora realizados en la transferencia
 * @apiSuccess {int} bitacora.clientID ID del cliente
 * @apiSuccess {int} bitacora.client Nombre del cliente
 * @apiSuccess {int} bitacora.userID ID del usuario
 * @apiSuccess {int} bitacora.user Nombre del usuario
 * @apiSuccess {int} bitacora.actionID Accion realizada 
 * @apiSuccess {int} product.action Accion realizada
 * @apiSuccess {int} product.notes Notas
 * @apiSuccess {int} product.creationTimestamp Fecha en la que se registro en bitacora
 * 
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"transfer":{"id":"22","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","typeID":"1","type":"TRANSFERENCIA","stateID":"2","state":"COMPLETADO","creationTimestamp":"1580325037","notes":"transferencia de prueba","products":[{"transferID":"22","typeID":"1","type":"DISPOSITIVO GPS","stateID":"1","state":"PENDIENTE","productID":"9","serie":"0002","factoryID":"1","factory":"DEMO","modelID":"1","model":"DEMO"},{"transferID":"22","typeID":"2","type":"SIM","stateID":"2","state":"ACEPTADO","productID":"6","serie":"223456","factoryID":"3","factory":"AT&T","modelID":null,"model":null},{"transferID":"22","typeID":"3","type":"GENERICO","stateID":"3","state":"RECHAZADO","productID":"13","serie":"GEN01","factoryID":"2","factory":"DEMO B","modelID":"11","model":"GEN DEMO"}],"bitacora":[{"clientID":"3","client":"aviles","userID":"3","user":"aviles","actionID":"2","action":"FINALIZAR","notes":"SIMOn","creationTimestamp":"1580337788"},{"clientID":"2","client":"gps infinity","userID":"2","user":"gps infinity","actionID":"1","action":"REGISTRAR","notes":"","creationTimestamp":"1580325037"}]}}}
 */


 /**
 * @api {delete} /transfers/:id Cancelar Transferencia
 * @apiName DeleteTransfer
 * @apiGroup Transferencias
 * @apiDescription Cancela una transferencia o devulucion realizada <b>con estatus pendiente</b>
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la tranferencia a cancelar <br><b>NOTA: </b>Solo se pueden cancelar transferencias o devoluciones que tienen estatus pendiente y que fueron realizadas por el cliente que esta realizando la consulta
 * @apiParam {string} notes Razon por la cual se cancela la transferencia 
 * 
 * @apiParamExample Request-Example 1:
 * {{url}}/transfers/43?notes=Los productos involucrados estan incorrectos
 * 
 * @apiUse SuccessOK
 */
