<?php
/**
 * @api {post} /users Registrar usuario
 * @apiName PostUsers
 * @apiGroup Usuarios
 * @apiDescription Registra un nuevo usuario de tipo asociado en la plataforma
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {object} user Objeto que contiene la informacion del nuevo usuario
 * @apiParam {int=2} user.userType tipo de usuario
 * @apiParam {int} user.timezone ID del timezone que regira al usuario 
 * @apiParam {string} user.username Nombre del usuario 
 * @apiParam {string} user.email Correo electronico del usuario
 * @apiParam {string} user.notes Notas adicionales. 
 * @apiParam {string} user.name Nombre del usuario. 
 * @apiParam {string} user.paternalSurname Apellido Paterno del usuario. 
 * @apiParam {string} user.maternalSurname Apellido Materno del usuario. 
 * @apiParam {string} user.phone Telefono del usuario. 
 * @apiParam {string} user.address Direccion del usuario.
 * @apiParam {int[]} user.permissions Arreglo que contiene los ID de permisos extra con los que contara el usuario 
 * @apiParam {int[]} devices Arreglo que contiene los ID de dispositivos que se asociaran a la cuenta
 * 
 * @apiParamExample {json} Request-Example:
 * {"user":{"userType":"2","timezone":"14","username":"ejimenez3","email":"ejimenez@globalgps.com.mx","name":"Esme","paternalSurname":"Jimenez","maternalSurname":"pepino","phone":"777123456","address":"alguna direccion","notes":"alguna nota","permissions":[1,2]},"devices":[45,46,47,48]}
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":201,"data":{"userID":"86"}}
 * 
 * 
*/

/**
 * @api {get} /users/:id Informacion de usuario
 * @apiName GetUser
 * @apiGroup Usuarios
 * @apiDescription Obtiene la informacion de un usuario
 * 
 * @apiUse RequireAuth
 * @apiParam {int} id ID del usuario a consultar
 * 
 * @apiSuccess {object} user Objeto que contiene la informacion del usuario
 * @apiSuccess {int} user.id ID del usuario 
 * @apiSuccess {int} user.userType tipo de usuario
 * @apiSuccess {int} user.timezone ID del timezone del usuario 
 * @apiSuccess {string} user.username Nombre del usuario 
 * @apiSuccess {string} user.email Correo electronico del usuario
 * @apiSuccess {string} user.name Nombre del usuario
 * @apiSuccess {string} user.paternalSurname Apellido paterno del usuario
 * @apiSuccess {string} user.maternalSurname Apellido materno del usuario
 * @apiSuccess {string} user.phone Telefono del usuario
 * @apiSuccess {string} user.address Direccion del usuario
 * @apiSuccess {int} user.creationTimestamp Timestamp en la que se creo el usuario
 * @apiSuccess {string} user.notes Notas adicionales. 
 * @apiSuccess {Object[]} user.permissions Arreglo que contiene los permisos con los que cuenta el usuario 
 * @apiSuccess {Object} user.permissions.permission Objecto que contiene la informacion de un permiso
 * @apiSuccess {int} user.permissions.permission.id ID del usuario 
 * @apiSuccess {string} user.permissions.permission.code Codigo del permiso 
 * @apiSuccess {Object[]} devices Arreglo que contiene los ID de dispositivos que se asociaran a la cuenta
 * @apiSuccess {object} devices.device Objeto que contiene la informacion de un dispositivo 
 * @apiSuccess {int} devices.device.id ID del dispositivo 
 * @apiSuccess {int} devices.device.distributorID ID del distribuidor del dispositivo 
 * @apiSuccess {int} devices.device.clientID ID del cliente del dispositivo
 * @apiSuccess {int} devices.device.imei Imei del dispositivo
 * @apiSuccess {int} devices.device.alias Alias del dispositivo
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"user":{"id":"89","userType":"2","timezoneID":"14","username":"ejimenez3","email":"ejimenez@globalgps.com.mx","creationTimestamp":"4294967295","notes":"alguna nota","name":"Esme","paternalSurname":"Jimenez","maternalSurname":"pepino","phone":"777123456","address":"alguna direccion","permissions":[{"id":"1","code":"SLOC"},{"id":"2","code":"SREP"},{"id":"3","code":"SALT"}]},"devices":[{"id":"45","distributorID":"17","clientID":"70","imei":"0001","alias":"Disp Prueba"},{"id":"46","distributorID":"17","clientID":"42","imei":"008748872","alias":"Laboratorio Siccob"},{"id":"47","distributorID":"17","clientID":"71","imei":"0002","alias":"Disp Prueba 2"},{"id":"48","distributorID":"17","clientID":"70","imei":"0003","alias":"Disp Prueba 3"}]}}
 * 
 * 
*/

/**
 * @api {get} /users Lista de usuarios
 * @apiName GetUsers
 * @apiGroup Usuarios
 * @apiDescription Obtiene la lista de usuarios de un cliente o distribuidor
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {object[]} users Objeto que contiene la informacion de los usuarios
 * @apiSuccess {object} user Objeto que contiene la informacion del usuario
 * @apiSuccess {int} user.id ID del usuario 
 * @apiSuccess {int} user.userType tipo de usuario
 * @apiSuccess {string} user.username Nombre del usuario 
 * @apiSuccess {string} user.email Correo electronico del usuario
 * @apiSuccess {string} user.name Nombre del usuario
 * @apiSuccess {string} user.paternalSurname Apellido Paterno usuario
 * @apiSuccess {int} user.creationTimestamp Timestamp en la que se creo el usuario 
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"","next":"","prev":""},"data":{"users":[{"id":"84","userType":"2","username":"omartinez","email":"omartinez@globalgps.com.mx","creationTimestamp":"4294967295","name":"Omar","paternalSurname":"Martinez"},{"id":"86","userType":"2","username":"ejimenez","email":"ejimenez@globalgps.com.mx","creationTimestamp":"4294967295","name":"Esme","paternalSurname":"Jimenez"}]}}
 * 
 * 
*/


/**
 * @api {delete} /users/:userID Eliminar usuario
 * @apiName DeleteUser
 * @apiGroup Usuarios
 * @apiDescription Elimina un usuario de la plataforma
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} userID Id del usuario a eliminar
 * 
 * @apiUse SuccessOK
 * 
*/

/**
 * @api {put} /users/:userID Actualizar datos de usuario
 * @apiName UpdateUser
 * @apiGroup Usuarios
 * @apiDescription Actualiza los datos de un usuario
 * 
 * @apiUse RequireAuth
 *
 * @apiParam {int} userID Id del usuario a actualizar
 * @apiParam {object} user Objeto que contiene la informacion del nuevo usuario
 * @apiParam {int} [user.timezone] ID del timezone que regira al usuario 
 * @apiParam {string} [user.username] Nombre del usuario 
 * @apiParam {string} [user.email] Correo electronico del usuario
 * @apiParam {string} [user.notes] Notas adicionales. 
 * @apiParam {string} [user.name] Nombre del usuario. 
 * @apiParam {string} [user.paternalSurname] Apellido Paterno del usuario. 
 * @apiParam {string} [user.maternalSurname] Apellido Materno del usuario. 
 * @apiParam {string} [user.phone] Telefono del usuario. 
 * @apiParam {string} [user.address] Direccion del usuario.
 * @apiParam {int[]}  [user.permissions] Arreglo que contiene los ID de permisos extra con los que contara el usuario  
 * 
 * @apiParamExample {json} Request-Example1:
 * {"user":{"username":"esme5","timezone":16,"notes":"nueva nota","name":"nuev Esme","paternalSurname":"nuev Jimenez","maternalSurname":"nuev pepino","phone":"1777123456","address":"n","permissions":[1,2]}}
 * 
 * @apiParamExample {json} Request-Example2:
 * {"user":{"username":"newName","email":"newName@mail.com"}}
 * 
 * @apiParamExample {json} Request-Example3:
 * {"user":{"name":"nuev Esme","paternalSurname":"nuev Jimenez","maternalSurname":"nuev pepino"}}
 * 
 * @apiUse SuccessOK
 * 
*/


/**
 * @api {post} /users/:userID/devices Agregar dispositivos al usuario
 * @apiName SuscribeUserToDevices
 * @apiGroup Usuarios
 * @apiDescription Vincula dispositivos a un usuario para que pueda monitorearlos e interactuar con ellos
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} userID Id del usuario 
 * @apiParam {int[]} devices Arreglo de id's de dispositivos a vincular
 * 
 * @apiParamExample {json} Request-Example:
 * {"devices":[46,47,48]}
 * 
 * @apiUse SuccessOK
 * 
*/

/**
 * @api {delete} /users/:userID/devices/:deviceID Quitar dispositivo al usuario
 * @apiName UnscribeUserFromoDevices
 * @apiGroup Usuarios
 * @apiDescription Elimina la relacion entre un dispositivo y un usuario (el usuario ya no podra monitorear ni interactuar con el dispositivo)
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} userID ID del usuario 
 * @apiParam {int} deviceID ID del dispositivo
 *  
 * 
 * @apiUse SuccessOK
 * 
*/

/**
 * @api {put} /users/:id/status Suspender Usuario
 * @apiName PutUserStatus
 * @apiGroup Usuarios
 * @apiDescription Actualiza el estado del usuario (suspender)
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} id ID del usuario a suspender
 * @apiParam {bool} status Indica estado del usuario <br> True = Usuario activo <br> False = Usuario suspendido
 * @apiParamExample Ejemplo
 * {"status":false}
 * 
 * @apiUse SuccessOK
 */