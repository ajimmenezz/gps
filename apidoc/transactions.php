<?php

/**
 * @api {post} /transactions Registrar transaccion
 * @apiName PostTransactions
 * @apiGroup Transacciones
 * @apiDescription Registra una nueva transaccion
 * 
 * @apiUse RequireAuth
 * @apiParam {object} transaction Objeto que contiene la informacion de la transaccion
 * @apiParam {int} transaction.clientID ID del cliente involucrado en la transaccion
 * @apiParam {int} transaction.transactionType Tipo de transaccion 
 * @apiParam {array} products Arreglo de productos involucrados en la transaccion
 * @apiParam {int} product.id ID del producto
 * @apiParam {int} product.type Tipo de producto 
 * 
 * @apiParamExample {json} Request-Example 1:
 * {"transaction":{"clientID":3,"transactionType":1},"products":[{"id":5,"type":1},{"id":6,"type":2,"kitID":23},{"id":15,"type":3,"kitID":23}]}
 * 
 * @apiSuccess {int} transactionID ID de la transaccion 
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"transactionID":"40"}}
*/


/**
 * @api {get} /transactions Obtener transacciones
 * @apiName GetTransactions
 * @apiGroup Transacciones
 * @apiDescription Obtiene las transacciones realizadas
 * 
 * @apiUse RequireAuth
 * @apiParam {int} [clientID] Filtrar resultados por un cliente especifico
 * @apiParam {int} [fromTimestamp] Filtrar resultados desde una fecha especifica
 * @apiParam {int} [tillTimestamp] Filtrar resultados hasta una fecha especifica
 * 
 * @apiSuccess {array} transactions Arreglo que contiene las transacciones realizadas 
 * @apiSuccess {int} transaction.id ID de la transaccion
 * @apiSuccess {int} transaction.fromClientID ID del cliente que realiza la transaccion
 * @apiSuccess {string} transaction.fromClient Nombre del cliente que realiza la transaccion
 * @apiSuccess {int} transaction.toClientID ID del cliente involucrado en la transaccion
 * @apiSuccess {string} transaction.toClient Nombre del cliente involucrado en la transaccion
 * @apiSuccess {int} transaction.transactionTypeID ID del Tipo de transaccion 
 * @apiSuccess {string} transaction.transactionType Tipo de transaccion
 * @apiSuccess {int} transaction.timestampTransaction Timestamp de la transaccion
 * 
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"transactions":[{"id":"39","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","transactionTypeID":"1","transactionType":"VENTA","timestampTransaction":"1578507018"},{"id":"40","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","transactionTypeID":"1","transactionType":"VENTA","timestampTransaction":"1578518249"}]}}
*/


/**
 * @api {get} /transactions/:id Informacion de transaccion
 * @apiName GetTransaction
 * @apiGroup Transacciones
 * @apiDescription Obtiene las transacciones realizadas
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccess {object} transaction Contiene los datos de la transaccion 
 * @apiSuccess {int} transaction.id ID de la transaccion
 * @apiSuccess {int} transaction.fromClientID ID del cliente que realiza la transaccion
 * @apiSuccess {string} transaction.fromClient Nombre del cliente que realiza la transaccion
 * @apiSuccess {int} transaction.toClientID ID del cliente involucrado en la transaccion
 * @apiSuccess {string} transaction.toClient Nombre del cliente involucrado en la transaccion
 * @apiSuccess {int} transaction.transactionTypeID ID del Tipo de transaccion 
 * @apiSuccess {string} transaction.transactionType Tipo de transaccion
 * @apiSuccess {int} transaction.timestampTransaction Timestamp de la transaccion
 * @apiSuccess {array} transaction.products Contiene el arreglo de productos involucrados en la transaccion
 * @apiSuccess {int} transaction.product.id ID del producto
 * @apiSuccess {int} transaction.product.productTypeID ID del tipo de producto
 * @apiSuccess {int} transaction.product.productType Tipo de producto
 * @apiSuccess {int} transaction.product.productID ID del producto
 * @apiSuccess {int} transaction.product.product Imei o Serie o Telefono del producto
 * @apiSuccess {int} transaction.product.kitID ID del kit al que pertenece el producto
 * @apiSuccess {int} transaction.product.kitName Nombre del kit al que pertenece el producto
 * 
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"transactions":[{"id":"39","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","transactionTypeID":"1","transactionType":"VENTA","timestampTransaction":"1578507018"},{"id":"40","fromClientID":"2","fromClient":"gps infinity","toClientID":"3","toClient":"aviles","transactionTypeID":"1","transactionType":"VENTA","timestampTransaction":"1578518249"}]}}
*/