<?php
/**
 * @api {get} /geofences Obtener Lista de Geocercas
 * @apiName GetGeofences
 * @apiGroup Geocercas
 * @apiDescription Obtiene la lista de geocercas o puntos de interes
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int=1,2} geofenceType Tipo de geocercas a obtener<br>
 * 1 = Normal <br>
 * 2 = Puntos de interes 
 * 
 * @apiSuccessExample Success
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"geofences":[{"id":"14","geofenceType":"1","behavior":"1","figureType":"1","name":"Circular 441"},{"id":"17","geofenceType":"1","behavior":"1","figureType":"2","name":"Circular 441"},{"id":"18","geofenceType":"1","behavior":"1","figureType":"2","name":"Circular 441"}]}}
 */

 /**
 * @api {get} /geofences/:id Informacion de Geocerca
 * @apiName GetGeofence
 * @apiGroup Geocercas
 * @apiDescription Obtiene la informacion de una geocerca o punto de interes
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID de la geocerca
 * 
 * @apiSuccessExample Success-Circular Geofence
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"geofence":{"id":"14","userID":"70","geofenceType":"1","behavior":"1","figureType":"1","name":"Circular 441","timestampCreation":"1561685480","coords":[{"lat":"18.968009","lng":"-99.240219"}],"radio":"150"}}}
 * 
 * @apiSuccessExample Success-Polygonal Geofence
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"geofence":{"id":"19","userID":"70","geofenceType":"1","behavior":"1","figureType":"2","name":"Circular 441","timestampCreation":"1562007287","coords":[{"lat":"18.968009","lng":"-99.240219"},{"lat":"18.968009","lng":"-99.240219"},{"lat":"18.968009","lng":"-99.240219"}]}}}
 * 
 * 
*/

/**
 * @api {post} /geofences Crear Geocerca
 * @apiName PostGeofences
 * @apiGroup Geocercas
 * @apiDescription Crea un nuevo registro de geocerca o punto de interes
 * 
 * @apiUse RequireAuth
 * @apiUse GeofenceDataParam
 *  
 * @apiUse SuccessCreated
*/
 
/**
 * @api {put} /geofences/:id Editar Geocerca
 * @apiName PutGeofences
 * @apiGroup Geocercas
 * @apiDescription Edita un registro de geocerca o punto de interes
 * 
 * @apiUse RequireAuth
 * @apiParam {json} geofence objeto que contiene la informacion de la geocerca <br><br>
 * <b style="color:red">Importante</b>: El objeto debe ser proporcionado en el body / data de la peticion y no como un parametro 
 * <br><b style="color:blue">Nota</b>: El objeto debe ser proporcionado con todos los valores incluyendo los que no fueron modificados, es decir
 * si, por ejemplo, el parametro geofence.behavior no fue modificado, esté debera ir con el valor actual.
 * 
 * @apiParam {int} id ID de la geocerca
 * @apiParam {int=1,2,3} geofence.behavior Comportamiento para la geocerca <br>
 * 1 = Entradas <br>
 * 2 = Salidas <br>
 * 3 = Ambos 
 * @apiParam {string} geofence.name Nombre que llevara la geocerca
 * @apiParam {int} geofence.radio Radio de la geocerca (en metros)
 * @apiParam {array} geofence.coords Conjunto de coordenadas que definen al objeto (para la geocerca circular solo es requerido un item en el arreglo) 
 * 
 * @apiParamExample {json} Ejemplo-Circular
 * {"behavior":1,"name":"Geocerca 1","radio":10,"coords":[{"lat":123,"lng":456}]}
 * 
 * @apiParamExample {json} Ejemplo-Polygon
 * {"behavior":3,"name":"Geocerca Polygon 1","coords":[{"lat":123,"lng":456},{"lat":123,"lng":789},{"lat":123,"lng":12345},{"lat":789,"lng":456}]}
 *
 * @apiUse SuccessOK
*/

/**
 * @api {delete} /geofences/:id Eliminar Geocerca
 * @apiName DeleteGeofences
 * @apiGroup Geocercas
 * @apiDescription elimina (de forma logica) un registro de geocerca o punto de interes asi como correos electronicos suscritos 
 * y dispositivos vinculados a la misma
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiUse SuccessOK
*/

/**
 * @apiDefine GeofenceDataParam
 * @apiParam {json} geofence objeto que contiene la informacion de la geocerca <br><br>
 * <b style="color:red">Importante</b>: El objeto debe ser proporcionado en el body / data de la peticion y no como un parametro 
 * @apiParam {int=1,2} geofence.geofenceType Tipo de geocerca a registrar: <br>
 * 1 = Geocerca <br>
 * 2 = Punto de interes
 * @apiParam {int=1,2} geofence.figureType Tipo de figura a registrar: <br>
 * 1 = Circular <br>
 * 2 = Poligonal 
 * @apiParam {int=1,2,3} geofence.behavior Comportamiento para la geocerca <br>
 * 1 = Entradas <br>
 * 2 = Salidas <br>
 * 3 = Ambos 
 * @apiParam {string} geofence.name Nombre que llevara la geocerca
 * @apiParam {int} geofence.radio Radio de la geocerca (en metros)
 * @apiParam {array} geofence.coords Conjunto de coordenadas que definen al objeto (para la geocerca circular solo es requerido un item en el arreglo) 
 * 
 * @apiParamExample {json} Ejemplo-Circular
 * {"geofenceType":1,"figureType":1,"behavior":1,"name":"Geocerca 1","radio":10,"coords":[{"lat":123,"lng":456}]}
 * 
 * @apiParamExample {json} Ejemplo-Polygon
 * {"geofenceType":1,"figureType":2,"behavior":3,"name":"Geocerca Polygon 1","coords":[{"lat":123,"lng":456},{"lat":123,"lng":789},{"lat":123,"lng":12345},{"lat":789,"lng":456}]}
*/

/**
 * @api {get} /geofences/:id/devices/near Dispositivos Cercanos a POI
 * @apiName GetGeofencesDevicesNear
 * @apiGroup Geocercas
 * @apiDescription Obtiene los dispositivos cercanos a un punto de interes
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiParam {int} maxDistance Distancia maxima en metros, entre un dispositivo y el centro del punto de interes
 *  
 * @apiSuccess {object} position Contiene las coordenas del punto de interes
 * @apiSuccess {double} position.lat latitud del punto de interes
 * @apiSuccess {double} position.lng longitud del punto de interes
 * @apiSuccess {array} devices Arreglo que contiene objetos dispositivo 
 * @apiSuccess {int} device.id ID del dispositivo
 * @apiSuccess {int} device.clientID ID del usuario al que pertenece el dispositivo
 * @apiSuccess {int} device.markerType ID del tipo de marcador
 * @apiSuccess {int} device.distance Distancia en metros entre la ubicacion del dispositivo y el punto de interes
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"position":{"lat":"19.36253536792485","lng":"-99.18309526237994"},"devices":[{"id":"19","clientID":"42","markerType":"4","markerName":"DIGGER","imei":"008703929","alias":"KZ-47-945","lat":"19.356496","lng":"-99.156372","address":"Privada Corina 35, Del Carmen, Coyoacan, Ciudad de Mexico, 04100, MEX","timestampReport":"1550386668","distance":2882.78},{"id":"46","clientID":"42","markerType":"1","markerName":"DEFAULT","imei":"008748872","alias":"Laboratorio Siccob","lat":"19.36233","lng":"-99.183401","address":"","timestampReport":"1557957660","distance":39.37}]}}
*/
 

/**
 * @api {put} /geofences/:id/behavior/:behavior Actualizar comportamiento de geocerca
 * @apiName PutGeofenceBehavior
 * @apiGroup Geocercas
 * @apiDescription Actualiza el comportamiento de una geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiParam {int=1,2,3} behavior tipo de comportamiento
 *  
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":[]}
*/

/**
 * @api {post} /geofences/:id/devices/:deviceID Vincular dispositivo a geocerca
 * @apiName PostDeviceToGeofence
 * @apiGroup Geocercas
 * @apiDescription Vincula un dispositivo gps con una geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiParam {int} deviceID id del dispositivo gps a vincular
 *  
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":201,"data":[]}
*/

/**
 * @api {delete} /geofences/:id/devices/:deviceID desVincular dispositivo de geocerca
 * @apiName DeleteDeviceFromGeofence
 * @apiGroup Geocercas
 * @apiDescription Elimina el vinculo de dispositivo gps con una geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiParam {int} deviceID id del dispositivo gps a vincular
 *  
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"data":[]}
*/

/**
 * @api {get} /geofences/:id/devices Dispositivos de la geocerca
 * @apiName GetGeofenceDevices
 * @apiGroup Geocercas
 * @apiDescription Obtiene la lista de dispositivos de la geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 *  
 * @apiSuccess {array} devices[] arreglo que contiene objetos con la informacion del dispositivo
 * @apiSuccess {int} device.geofenceID ID de la geocerca
 * @apiSuccess {int} device.deviceID ID del dispositivo
 * @apiSuccess {string} device.deviceImei Imei del dispositivo
 * @apiSuccess {string} device.deviceAlias Alias del dispositivo
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"devices":[{"geofenceID":"53","deviceID":"48","deviceImei":"0003","deviceAlias":"Disp Prueba 3"},{"geofenceID":"53","deviceID":"45","deviceImei":"0001","deviceAlias":"Disp Prueba"}]}}
*/


/**
 * @api {get} /geofences/:id/subscribers/emails Correos suscritos a la geocerca
 * @apiName GetGeofenceEmailSubscribers
 * @apiGroup Geocercas
 * @apiDescription Obtiene la lista de correos electronicos suscritos a las notificaciones de la geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 *  
 * @apiSuccess {int} geofenceID ID de la geocerca
 * @apiSuccess {array} emailSubscribers[] arreglo que contiene los correos suscritos a la geocerca
 * @apiSuccess {int} email.id ID del correo suscrito a la geocerca
 * @apiSuccess {string} email.correo correo electronico suscrito a la geocerca
 * 
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"geofenceID":"51","emailSubscribers":[{"id":"2","correo":"naviles@globalgps.com.mx"},{"id":"9","correo":"juan.perez@ejemplo.com"},{"id":"10","correo":"ejimenez@globalgps.com.mx"},{"id":"11","correo":"martinez@ejemplo.com"}]}}
*/

/**
 * @api {post} /geofences/:id/subscribers/emails Agregar correo suscriptor a la geocerca
 * @apiName PostGeofenceEmailSubscriber
 * @apiGroup Geocercas
 * @apiDescription Agrega un correo suscriptor a las notificaciones de la geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiParam {string} email correo que se suscribira a las notificaciones de la geocerca
 *  
 * @apiSuccess {int} emailID ID del correo suscrito a la geocerca
 * @apiSuccess {string} email correo suscrito a la geocerca
 * 
 * @apiParamExample {json} Request-Example:
 * {"email": "martinez@ejemplo.com" }
 * 
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":201,"data":{"email":"martinez@ejemplo.com","emailID":"12"}}
*/

/**
 * @api {delete} /geofences/:id/subscribers/emails/:emailID Eliminar correo suscriptor de la geocerca
 * @apiName DeleteGeofenceEmailSubscriber
 * @apiGroup Geocercas
 * @apiDescription Eliminar el correo suscrito a las notificaciones de la geocerca
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID de la geocerca
 * @apiParam {int} emailID ID del correo suscrito
 *  
 * @apiSuccessExample SuccessExample
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":[]}
*/
