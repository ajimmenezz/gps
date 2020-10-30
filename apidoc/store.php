<?php

/**
 * @api {get} /store/summary Resumen de Almacen
 * @apiName GetStoreSummary
 * @apiGroup Almacen
 * @apiDescription Obtiene el resumen del almacen del cliente
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"summary":[{"productTypeID":"1","productType":"DISPOSITIVO GPS","factoryID":"1","factory":"DEMO","modelID":"7","model":"PRUEBAS","quantity":"2"},{"productTypeID":"3","productType":"GENERICO","factoryID":"4","factory":"LOGITECH","modelID":"8","model":"LG58SX","quantity":"1"},{"productTypeID":"3","productType":"GENERICO","factoryID":"5","factory":"TESLA","modelID":"9","model":"SF35","quantity":"1"},{"productTypeID":"2","productType":"SIM","factoryID":"1","factory":"TELCEL","modelID":null,"model":null,"quantity":"1"},{"productTypeID":"2","productType":"SIM","factoryID":"2","factory":"MOVISTAR (TELEFONICA)","modelID":null,"model":null,"quantity":"1"},{"productTypeID":"2","productType":"SIM","factoryID":"3","factory":"AT&T","modelID":null,"model":null,"quantity":"1"}]}}
 * 
 * @apiSuccess {array} summary Arreglo que los elmentos del resumen de productos del almacen
 * @apiSuccess {object} product Objeto que contiene la informacion del producto
 * @apiSuccess {int} product.productTypeID ID del tipo de producto
 * @apiSuccess {string} product.productType Nombre del tipo de producto
 * @apiSuccess {int} product.factoryID Id del la marca del producto
 * @apiSuccess {string} product.factory Nombre de la marca del producto
 * @apiSuccess {int} product.modelID ID del modelo del producto
 * @apiSuccess {string} product.model Nombre del modelo del producto
 * @apiSuccess {int} product.quantity Numero de elementos en el almacen de ese tipo de producto.
 * 
*/

/**
 * @api {get} /store Almacen
 * @apiName GetStore
 * @apiGroup Almacen
 * @apiDescription Obtiene los productos del almacen
 * 
 * @apiUse RequireAuth
 * @apiParam {int} [clientID] ID del almacen del cliente <br><b>NOTA: </b> Si no se proporciona se utilizara el id del cliente proporcionado por el token
 * @apiParam {string} [id] Imei|Telefono|Serie|ID del producto
 * @apiParam {int} [productType] Tipo de producto
 * @apiParam {int} [factory] Marca del producto
 * @apiParam {int} [model] Modelo del producto
 * @apiParam {int} [limit] Numero de resultados por consulta (paginacion) <br><b>NOTA: </b>Si no se proporciona, se entregaran todos los registros que resulten de la consulta
 * @apiParam {string} [paginationToken] Token para cargar el siguiente bloque de resultados. <br><b>NOTA: </b>Si se proporciona este campo, cualquier otro parametro proporcionado en la consulta sera ignorado
 * @apiParam {boolean} [onTransfers=true] Determina si debe incluir en los resultados, productos que se encuentran actualmente en progreso de transferencia <br><b>NOTA: </b>Si no se proporciona este campo se tomara el valor por default
 * 
 * @apiParamExample Example 1:
 * /store?productType=2&factory=1&model=7&limit=4&ontransfers=false
 * 
 * @apiParamExample Example 2:
 * /store?productType=2&factory=1&model=7&limit=4
 * 
 * @apiParamExample Example 3:
 * /store?clientID=50&id=0004
 * 
 * * @apiParamExample Paginacion:
 * /store?paginationToken=Tzo4OiJzdGRDbGFzcyI6Nzp7czo4OiJjbGllbnRJRCI7czoxOiIyIjtzOjI6ImlkIjtOO3M6MTE6InByb2R1Y3RUeXBlIjtOO3M6NzoiZmFjdG9yeSI7TjtzOjU6Im1vZGVsIjtOO3M6NToibGltaXQiO3M6MToiMiI7czoxMDoicGFnaW5hdGlvbiI7aTo0O30=
 * 
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"Tzo4OiJzdGRDbGFzcyI6Nzp7czo4OiJjbGllbnRJRCI7czoxOiIyIjtzOjI6ImlkIjtOO3M6MTE6InByb2R1Y3RUeXBlIjtOO3M6NzoiZmFjdG9yeSI7TjtzOjU6Im1vZGVsIjtOO3M6NToibGltaXQiO3M6MToiNCI7czoxMDoicGFnaW5hdGlvbiI7aTowO30=","next":"Tzo4OiJzdGRDbGFzcyI6Nzp7czo4OiJjbGllbnRJRCI7czoxOiIyIjtzOjI6ImlkIjtOO3M6MTE6InByb2R1Y3RUeXBlIjtOO3M6NzoiZmFjdG9yeSI7TjtzOjU6Im1vZGVsIjtOO3M6NToibGltaXQiO3M6MToiNCI7czoxMDoicGFnaW5hdGlvbiI7aTo0O30=","prev":""},"data":{"products":[{"id":"0004","productTypeID":"1","productType":"DISPOSITIVO GPS","factoryID":"1","factory":"DEMO","modelID":"7","model":"PRUEBAS"},{"id":"0005","productTypeID":"1","productType":"DISPOSITIVO GPS","factoryID":"1","factory":"DEMO","modelID":"7","model":"PRUEBAS"},{"id":"K5GDJSWE","productTypeID":"3","productType":"GENERICO","factoryID":"4","factory":"LOGITECH","modelID":"8","model":"LG58SX"},{"id":"KFHRDC","productTypeID":"3","productType":"GENERICO","factoryID":"5","factory":"TESLA","modelID":"9","model":"SF35"}]}}
 * 
 * @apiSuccess {array} products Arreglo que contiene los resultados de la consulta.
 * @apiSuccess {object} product Objeto que contiene la informacion del producto
 * @apiSuccess {int} product.id ID|Imei|Telefono|Serie del producto
 * @apiSuccess {int} product.productTypeID Tipo de producto
 * @apiSuccess {string} product.productType Nombre del tipo de producto
 * @apiSuccess {int} product.factoryID Marca del producto
 * @apiSuccess {string} product.factory Nombre de la marca del producto
 * @apiSuccess {int} product.modelID Modelo del producto
 * @apiSuccess {string} product.model Nombre del modelo del producto.
 * 
*/