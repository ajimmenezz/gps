<?php
/**
 * @api {post} /fleets Registrar Flotilla
 * @apiName PostFleets
 * @apiGroup Flotillas
 * @apiDescription Registra una nueva flotilla
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {object} fleet Objeto que contiene la informacion de la nueva flotilla
 * @apiParam {string} fleet.name Nombre de la flotilla 
 * @apiParam {int[]} fleet.devices Arreglo de id´s de dispositivos que seran agregados a la flotilla
 * 
 * @apiParamExample {json} Request-Example:
 * {"fleet":{"name":"Nueva flota","devices":[45,46,47]}}
 * 
 * @apiSuccess {int} fleetID ID de la flotilla creada
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":201,"data":{"fleetID":"11"}}
 * 
 * 
*/

/**
 * @api {get} /fleets Lista de flotillas
 * @apiName GetFleets
 * @apiGroup Flotillas
 * @apiDescription Obtiene la lista de las flotillas del usuario
 * 
 * @apiUse RequireAuth
 * 
 * @apiSuccess {object[]} fleets Arreglo que contiene flotillas
 * @apiSuccess {object} fleet Objecto que contiene la informacion de la flotilla 
 * @apiSuccess {int} fleet.id ID de la flotilla
 * @apiSuccess {string} fleet.name Nombre de la flotilla 
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"fleets":[{"id":"6","name":"FLOTA A"},{"id":"7","name":"FLOTA B"},{"id":"11","name":"Nueva flota"}]}}
 * 
 * 
*/

/**
 * @api {get} /fleets/:id Informacion de Flotilla
 * @apiName GetFleet
 * @apiGroup Flotillas
 * @apiDescription Obtiene la informacion de una flotilla
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la flotilla a consultar
 * 
 * @apiSuccess {object} fleet Objecto que contiene la informacion de la flotilla 
 * @apiSuccess {int} fleet.id ID de la flotilla
 * @apiSuccess {string} fleet.name Nombre de la flotilla 
 * @apiSuccess {int[]} fleet.devices Arreglo que contiene los id's de los dispositivos asociados a la flotilla
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"fleet":{"id":"11","name":"Nueva flota","devices":["46","45","47"]}}}
 * 
 * 
*/


/**
 * @api {delete} /fleets/:id Eliminar Flotilla
 * @apiName DeleteFleet
 * @apiGroup Flotillas
 * @apiDescription Elimina una flotilla
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la flotilla a eliminar
 * 
 * @apiUse SuccessOK
 * 
*/


/**
 * @api {put} /fleets/:id Actualizar Flotilla
 * @apiName PutFleets
 * @apiGroup Flotillas
 * @apiDescription Registra una nueva flotilla
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la flotilla a consultar
 * 
 * @apiParam {object} fleet Objeto que contiene la informacion de la nueva flotilla
 * @apiParam {string} [fleet.name] Nombre de la flotilla 
 * @apiParam {int[]} [fleet.devices] Arreglo de id´s de dispositivos que contendr la flotilla
 * 
 * @apiParamExample {json} Request-Example:
 * {"fleet":{"name":"Nueva flota","devices":[46,47]}}
 * 
 *  * @apiParamExample {json} Request-Example 2:
 * {"fleet":{"name":"Nueva flota"}}
 * 
 *  * @apiParamExample {json} Request-Example 3:
 * {"fleet":{"devices":[46,47]}}
 * 
 * @apiUse SuccessOK
 * 
 * 
*/