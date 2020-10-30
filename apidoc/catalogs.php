<?php
/**
 * @api {get} /catalogs/timezones Timezones
 * @apiName GetTimezones
 * @apiGroup Catalogos
 * @apiDescription Obtiene el listado de zonas horarias
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"timezones":[{"id":"2","name":"(GMT-11:00) Samoa ","timezone":"Pacific/Samoa"},{"id":"1","name":"(GMT-11:00) Midway Island ","timezone":"Pacific/Midway"},{"id":"3","name":"(GMT-10:00) Hawaii ","timezone":"Pacific/Honolulu"},{"id":"4","name":"(GMT-09:00) Alaska ","timezone":"America/Anchorage"}]}}
 * 
 * 
*/

/**
 * @api {get} /catalogs/markers Marcadores
 * @apiName GetMarkers
 * @apiGroup Catalogos
 * @apiDescription Obtiene el listado marcadores disponibles
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccess {Object[]} markers Arreglo que contiene objetos marcador 
 * @apiSuccess {Object} marker Objeto que contiene la informacion de un marcador
 * @apiSuccess {int} marker.id ID del marcador 
 * @apiSuccess {string} marker.name Nombre del marcador
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"markers":[{"id":"3","name":"CAR"},{"id":"1","name":"DEFAULT"},{"id":"4","name":"DIGGER"},{"id":"5","name":"PICKUP"},{"id":"2","name":"SMARTPHONE"}]}}
 * 
 * 
*/


/**
 * @api {get} /catalogs/products/factories Marcas de producto
 * @apiName GetProductFactories
 * @apiGroup Catalogos
 * @apiDescription Obtiene la lista de marcas de producto
 * 
 * @apiUse RequireAuth
 * @apiParam {int} [productType] Filtra el resultado de marcas por tipo de producto
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"factories":[{"id":"1","name":"DEMO","productType":"1","productTypeName":"DISPOSITIVO GPS"},{"id":"4","name":"LOGITECH","productType":"3","productTypeName":"GENERICO"},{"id":"3","name":"SUNTECH","productType":"1","productTypeName":"DISPOSITIVO GPS"}]}}
 * 
 * @apiSuccess {factories[]} factories Arreglo que contiene objectos Marca
 * @apiSuccess {factory} factory objecto que representa una marca
 * @apiSuccess {int} factory.id ID de la marca
 * @apiSuccess {string} factory.name Nombre de la marca
 * @apiSuccess {int} factory.productType Tipo de producto al que pertenece la marca
 * @apiSuccess {string} factory.productTypeName Nombre del tipo de producto al que pertenece la marca
*/

/**
 * @api {get} /catalogs/products/factories/:factoryID/models Modelos de producto
 * @apiName GetProductModels
 * @apiGroup Catalogos
 * @apiDescription Obtiene la lista de modelos de producto de una marca determinada
 * 
 * @apiUse RequireAuth
 * @apiParam {int} factoryID Marca a la que pertenecen los modelos que seran devueltos en el resultado
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"models":[{"id":"1","name":"ST300"},{"id":"3","name":"ST300K"},{"id":"6","name":"ST600MD"}]}}
 * 
 * @apiSuccess {factories[]} models Arreglo que contiene objectos Modelo
 * @apiSuccess {object} model objecto que representa un modelo
 * @apiSuccess {int} model.id ID del modelo
 * @apiSuccess {string} model.name Nombre del modelo
*/