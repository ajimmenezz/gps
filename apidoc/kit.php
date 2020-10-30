<?php
/**
 * @api {post} /kits Registrar Kit
 * @apiName PostKit
 * @apiGroup Kits
 * @apiDescription Registra una plantilla de kit de productos
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {object} kit Objeto que contiene la informacion del nuevo kit
 * @apiParam {string} kit.name Nombre del kit
 * @apiParam {string} kit.notes Notas del kit
 * @apiParam {array} products Arreglo que contiene los productos del kit
 * @apiParam {int} product.productType Tipo de producto
 * @apiParam {int} product.model Modelo del producto
 * @apiParam {int} product.quantity Cantidad de productos de ese modelo especifico
 * 
 * @apiParamExample {json} Request-Example:
 * {"kit":{"name":"StarterPak","notes":"paquete inicial"},"products":[{"productType":2,"model":4,"quantity":7},{"productType":3,"model":2,"quantity":7}]}
 * 
 * @apiSuccess {int} kitID ID de la plantilla kit generada
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"kitID":"18"}}
 * 
*/


/**
 * @api {get} /kits Lista de Kits
 * @apiName GetKits
 * @apiGroup Kits
 * @apiDescription Obtiene la lista de kits 
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccess {array} kits Arreglo que contiene los kits del cliente
 * @apiSuccess {int} kit.id ID del kit
 * @apiSuccess {string} kit.kitName Nombre del kit
 * @apiSuccess {int} kit.clientID ID del cliente propietario del kit
 * @apiSuccess {int} kit.creationTimestamp Fecha en Unix timestamp de registro del kit
 * @apiSuccess {string} kit.notes Notas del kit 
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"kits":[{"id":"16","kitName":"Nuevo nombre","clientID":"2","creationTimestamp":"1577822754","notes":"nuevas notas 1024"},{"id":"17","kitName":"Kit Prueba","clientID":"2","creationTimestamp":"1577822804","notes":"Kit Inicial notas"},{"id":"18","kitName":"StarterPak","clientID":"2","creationTimestamp":"1578337469","notes":"paquete inicial"}]}}
 * 
*/

/**
 * @api {get} /kits/:id Informacion del Kit
 * @apiName GetKit
 * @apiGroup Kits
 * @apiDescription Obtiene la informacion del kit 
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID del kit a consultar
 * 
 * @apiSuccess {object} kit Objecto que contiene la informacion del kit
 * @apiSuccess {int} kit.id ID del kit
 * @apiSuccess {string} kit.kitName Nombre del kit
 * @apiSuccess {int} kit.clientID ID del cliente propietario del kit
 * @apiSuccess {int} kit.creationTimestamp Fecha en Unix timestamp de registro del kit
 * @apiSuccess {string} kit.notes Notas del kit 
 * @apiSuccess {array} products Arreglo que contiene los productos que componen la plantilla kitW
 * @apiSUccess {int} product.id ID del registro del detalle de la plantilla
 * @apiSuccess {int} product.productTypeID Tipo de producto
 * @apiSuccess {string} product.productType Tipo de producto
 * @apiSuccess {int} product.modelID Modelo del producto
 * @apiSuccess {string} product.model Modelo del producto
 * @apiSuccess {int} product.factoryID Marca del producto
 * @apiSuccess {string} product.factory Marca del producto
 * @apiSuccess {int} product.quantity Cantidad de elementos del producto
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"kit":{"id":"17","kitName":"Kit Prueba","clientID":"2","creationTimestamp":"1577822804","notes":"Kit Inicial notas","products":[{"id":"13","productTypeID":"1","productType":"DISPOSITIVO GPS","modelID":"2","model":"IOS","factoryID":"2","factory":"SMARTPHONE","quantity":"2"},{"id":"14","productTypeID":"3","productType":"GENERICO","modelID":"5","model":"ST640LC","factoryID":"3","factory":"SUNTECH","quantity":"3"}]}}}
 * 
*/

/**
 * @api {put} /kits/:id Editar Kit
 * @apiName PutKit
 * @apiGroup Kits
 * @apiDescription Actualiza la informacion del kit 
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del kit a editar
 * @apiParam {object} kit Objeto que contiene la informacion del nuevo kit
 * @apiParam {string} [kit.name] Nombre del kit
 * @apiParam {string} [kit.notes] Notas del kit
 * @apiParam {array} products Arreglo que contiene los productos del kit <br><br><b>NOTA IMPORTANTE </b> La funcion actualizara la lista de productos de la plantilla basado en el contenido proporcionado, si el arreglo se manda vacio. se entiende que la plantilla esta vacia, asi pues si se quieren conservar los productos existentes en la plantilla deveran volver a enviarse junto a esta peticion
 * @apiParam {int} product.productType Tipo de producto
 * @apiParam {int} product.model Modelo del producto
 * @apiParam {int} product.quantity Cantidad de productos de ese modelo especifico
 * 
 * @apiParamExample Example
 * {"kit":{"name":"Nuevo nombre"},"products":[{"productType":2,"model":4,"quantity":7},{"productType":3,"model":2,"quantity":7}]}
 * 
 * @apiUse SuccessOK
*/



/**
 * @api {delete} /kits/:id Eliminar Kit
 * @apiName DeleteKit
 * @apiGroup Kits
 * @apiDescription Elimina el kit 
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del kit a eliminar
 * 
 * @apiUse SuccessOK 
*/

