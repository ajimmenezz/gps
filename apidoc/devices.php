<?php
/**
 * @api {put} /devices/:id Actualizar informacion de dispositivo
 * @apiName PutDevices
 * @apiGroup Dispositivos
 * @apiDescription Actualiza la informacion de un dispositivo
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID del dispositivo a actualizar
 * 
 * @apiParam {object} [device] Objeto que contiene la informacion del dispositivo
 * @apiParam {int} [device.marker] ID del usuario 
 * @apiParam {string} [device.alias] Alias del dispositivo
 * @apiParam {string} [device.notes] Notas adicionales 
 * 
 * @apiParam {object} [vehicle] Objeto que contiene la informacion del vehiculo 
 * @apiParam {string} [vehicle.brand] Marca del vehiculo
 * @apiParam {string} [vehicle.model] Modelo del vehiculo
 * @apiParam {string} [vehicle.year] Año del vehiculo
 * @apiParam {string} [vehicle.vin] Serie identificador del motor
 * @apiParam {string} [vehicle.colour] Color del vehiculo
 * @apiParam {string} [vehicle.carPlate] Placas del vehiculo
 * @apiParam {string} [vehicle.country] Pais de las placas
 * @apiParam {string} [vehicle.region] Ciudad o region de las placas
 * @apiParam {string} [vehicle.insurance] Seguro del vehiculo
 * @apiParam {string} [vehicle.insuranceID] Numero de Seguro del vehiculo
 * @apiParam {string} [vehicle.notes] Notas adicionales
 * 
 * @apiParam {object} [driver] Objeto que contiene la informacion del conductor
 * @apiParam {string} [driver.name] Nombre del conductor
 * @apiParam {string} [driver.phone] Telefono del conductor
 * 
 * @apiParamExample {json} Request-Example 1:
 * {"device":{"marker":2,"alias":"DELTA PEREZ","notes":""},"vehicle":{"brand":"FORD","model":"FOCUS","year":"2013","vin":"ADG5168ER","colour":"ROJO","carPlate":"DS-FRG-S","country":"MEXICO","region":"CDMX","insurance":"NO","insuranceID":"","notes":"Vehiculo nuevo"},"driver":{"name":"MARCO PEREZ","phone":"777123456"}}
 * 
 * @apiParamExample {json} Request-Example 2:
 * {"device":{"marker":2},"driver":{"phone":"777123456"}}
 * 
 * @apiParamExample {json} Request-Example 3:
 * {"vehicle":{"brand":"FORD","model":"FOCUS","year":"2013","vin":"ADG5168ER","colour":"ROJO","carPlate":"DS-FRG-S","country":"MEXICO","region":"CDMX","insurance":"NO","insuranceID":"","notes":"Vehiculo nuevo"},"driver":{"name":"MARCO PEREZ","phone":"777123456"}}
 * 
 * @apiParamExample {json} Request-Example 4:
 * {"vehicle":{"brand":"FORD","model":"FOCUS","year":"2013","vin":"ADG5168ER","colour":"ROJO","carPlate":"DS-FRG-S","country":"MEXICO","region":"CDMX","insurance":"NO","insuranceID":"","notes":"Vehiculo nuevo"}}
 * 
 * @apiUse SuccessOK
*/


/**
 * @api {put} /devices/:id/fleets Actualizar Flotilla de un dispositivo
 * @apiName PutDevicesFleet
 * @apiGroup Dispositivos
 * @apiDescription Cambia la flotilla a la que pertenece un dispositivo 
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID del dispositivo 
 * 
 * @apiParam {int} [fleetID] ID de la flotilla a la que pertenecera.<br>
 * <b>Nota: </b>Si no se proporciona este campo o se manda vacio, el dispositivo sera retirado de la flotilla actual y se mandara a "sin asignar"
 * 
 * @apiParamExample {json} Request-Example 1:
 * {"fleetID":6}
 * 
 * * @apiParamExample {json} Request-Example 2:
 * {"fleetID":""}
 * 
 * @apiParamExample {json} Request-Example 3:
 * {}
 * 
 * @apiUse SuccessOK
*/
