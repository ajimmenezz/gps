<?php
/**
 * @api {post} /products/generic Registrar producto
 * @apiName PostProducts
 * @apiGroup Productos
 * @apiDescription Registra una nuevo producto en el almacen
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {object} product Objeto que contiene la informacion del nuevo producto
 * @apiParam {int} [product.clientID] ID del cliente al que se le asignara el producto, si no se proporciona se asignara al cliente del token actual 
 * @apiParam {int} product.model Modelo del producto
 * @apiParam {int} product.productStatus Estado de adquision del producto
 * @apiParam {string} product.serial ID o numero serial Unico para la identificacion del producto
 * @apiParam {string} [product.notes] Notas adicionales 
 * 
 * @apiParamExample {json} Request-Example:
 * {"product":{"model":6,"productStatus":1,"notes":"producto chino","serial":"DKHLK"}}
 * 
 * @apiSuccess {int} productID ID del producto registrado
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"productID":"12"}}
 * 
 * 
*/

/**
 * @api {get} /products/generic Lista de productos
 * @apiName GetProducts
 * @apiGroup Productos
 * @apiDescription Obtiene la lista de productos del almacen de un cliente / cuenta
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"products":[{"id":"9","clientID":"2","serial":"K5GDJSWE","factoryID":"4","modelID":"8","factoryName":"LOGITECH","modelName":"LG58SX","productStatusID":"1","productStatusName":"PAGADO","notes":"alguna nota","creationTimestamp":"1577394955"},{"id":"10","clientID":"2","serial":"KFHRDC","factoryID":"5","modelID":"9","factoryName":"TESLA","modelName":"SF35","productStatusID":"1","productStatusName":"PAGADO","notes":"alguna nota","creationTimestamp":"1577394959"}]}}
 * 
 * @apiSuccess {object[]} products Arreglo que contiene objectos Producto
 * @apiSuccess {object} product objecto que representa un producto
 * @apiSuccess {int} product.id ID del producto
 * @apiSuccess {int} product.clientID ID del propietario del producto
 * @apiSuccess {int} product.serial Serie o ID del producto
 * @apiSuccess {int} product.factoryID ID de la marca del producto
 * @apiSuccess {int} product.modelID ID del modelo del producto
 * @apiSuccess {int} product.factoryName Marca del producto
 * @apiSuccess {int} product.modelName Modelo del producto
 * @apiSuccess {int} product.productStatusID ID del estado del producto
 * @apiSuccess {string} product.productStatusName Estado del producto
 * @apiSuccess {string} product.notes Notas adicionales
 * @apiSuccess {long} product.creationTimestamp Fecha de registro del producto 
 * 
 * 
*/

/**
 * @api {get} /products/generic/:id Informacion de producto
 * @apiName GetProduct
 * @apiGroup Productos
 * @apiDescription Obtiene la informacion de un producto
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID del producto a consultar
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"product":{"id":"7","clientID":"3","serial":"XBRKL2","factoryID":"4","modelID":"8","factoryName":"LOGITECH","modelName":"LG58SX","productStatusID":"1","productStatusName":"PAGADO","notes":"version editado 2","creationTimestamp":"1577140095"}}}
 * 
 * @apiSuccess {object} product Objeto que contiene la informacion del producto consultado
 * @apiSuccess {int} product.id ID del producto
 * @apiSuccess {int} product.clientID ID del propietario del producto
 * @apiSuccess {int} product.serial Serie o ID del producto
 * @apiSuccess {int} product.factoryID ID de la marca del producto
 * @apiSuccess {int} product.modelID ID del modelo del producto
 * @apiSuccess {int} product.factoryName Marca del producto
 * @apiSuccess {int} product.modelName Modelo del producto
 * @apiSuccess {int} product.productStatusID ID del estado del producto
 * @apiSuccess {string} product.productStatusName Estado del producto
 * @apiSuccess {string} product.notes Notas adicionales
 * @apiSuccess {long} product.creationTimestamp Fecha de registro del producto 
 * 
*/

/**
 * @api {put} /products/generic/:id Actualizar producto
 * @apiName UpdateProduct
 * @apiGroup Productos
 * @apiDescription Actualiza los datos de un producto
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del producto a actualizar
 * @apiParam {object} product Objeto que contiene la informacion del producto
 * @apiParam {string} [product.serial] Nuevo Serial o ID del producto <br><b>NOTA:</b>Solo podra actualizar este campo el nuevo serial no esta registrado 
 * @apiParam {int} [product.model] Modelo del producto
 * @apiParam {int} [product.productStatus] Estado del Producto
 * @apiParam {string} [product.notes] Notas adicionales
 * 
 * @apiParamExample {json} Request-Example:
 * {"product":{"model":7,"productStatus":1,"notes":"Nueva nota","serial":"DKHLKA"}}
 * 
 * @apiParamExample {json} Request-Example 2:
 * {"product":{"model":7,"productStatus":1}}
 * 
 * @apiParamExample {json} Request-Example 3:
 * {"product":{"notes":"Nueva nota"}}
 * 
 * @apiUse SuccessOK
*/

/**
 * @api {delete} /products/generic/:id Eliminar producto
 * @apiName DeleteProduct
 * @apiGroup Productos
 * @apiDescription Elimina un producto del almacen
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID del producto eliminar
 * 
 * @apiUse SuccessOK
 * 
*/
