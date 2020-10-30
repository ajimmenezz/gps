<?php
/**
 * @api {get} /reports/historical Reporte Historico
 * @apiName GetReportHistorical
 * @apiGroup Reportes
 * @apiDescription Obtiene el reporte historico de una unidad
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} deviceID id del dispositivo
 * @apiParam {string=asc,desc} [order] orden de los resultados (ascendetes o descendentes) 
 * @apiParam {int} [limit=300] limite de resultados<br> <b>NOTA:</b> Si el valor es 0 entregara todos los resultados
 * @apiParam {int} [fromTimestamp="today midnight"] Fecha inicial del reporte, si no se proporciona
 * @apiParam {int} [tillTimestamp] Fecha final del reporte. 
 * @apiParam {string} [paginationToken] Token que sera utilizado para avanzar o retroseder en la paginacion. 
 * 
 * @apiSuccess {object[]} reports Arreglo que contiene reportes
 * @apiSuccess {object} report objeto que contiene la informacion de un reporte
 * @apiSuccess {int} report.timestamp Timestamp del reporte
 * @apiSuccess {int} report.reportTypeString Tipo de reporte en formato string
 * @apiSuccess {int} report.reportType Tipo de reporte
 * @apiSuccess {int} report.lat Latitud
 * @apiSuccess {int} report.lng Longitud
 * @apiSuccess {int} report.address Direccion 
 * @apiSuccess {int} report.speed Velocidad en km/hr
 * @apiSuccess {int} report.validPosition Indica si la posicion era valida
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"Tzo4OiJzdGRDbGFzcyI6Njp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY1MzkwMzMwIjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO3M6MzoiYXNjIjtzOjU6ImxpbWl0IjtzOjE6IjIiO3M6MTA6InBhZ2luYXRpb24iO2k6Njt9","next":"Tzo4OiJzdGRDbGFzcyI6Njp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY1MzkwMzMwIjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO3M6MzoiYXNjIjtzOjU6ImxpbWl0IjtzOjE6IjIiO3M6MTA6InBhZ2luYXRpb24iO2k6ODt9","prev":"Tzo4OiJzdGRDbGFzcyI6Njp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY1MzkwMzMwIjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO3M6MzoiYXNjIjtzOjU6ImxpbWl0IjtzOjE6IjIiO3M6MTA6InBhZ2luYXRpb24iO2k6NDt9"},"data":{"reports":[{"timestamp":"1565390347","reportTypeString":"Auto reporte","reportType":"1001","lat":"19.3764681768931","lng":"-99.1780579090118","address":"Metrobus 1, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX","speed":"0.296","validPosition":"0"},{"timestamp":"1565390348","reportTypeString":"Auto reporte","reportType":"1001","lat":"19.3760430882883","lng":"-99.1770601272583","address":"Manzanas, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX","speed":"0.296","validPosition":"0"}]}}
 * 
 * 
*/


/**
 * @api {get} /reports/geofences Reporte de Geocercas
 * @apiName GetGeofenceReport
 * @apiGroup Reportes
 * @apiDescription Obtiene el reporte de geocercas
 * 
 * @apiUse RequireAuth
 * 
 * @apiParam {int} deviceID id del dispositivo
 * @apiParam {string=asc,desc} [order] orden de los resultados (ascendetes o descendentes) 
 * @apiParam {int} [limit=300] limite de resultados<br> <b>NOTA:</b> Si el valor es 0 entregara todos los resultados
 * @apiParam {int} [fromTimestamp="today midnight"] Fecha inicial del reporte, si no se proporciona
 * @apiParam {int} [tillTimestamp] Fecha final del reporte. 
 * @apiParam {int=1,2} [behavior] Comportamiento. Filtro que permite obtener solo resultados de entradas o salidas.<br>
 * 1 = ENTRADAS<br>
 * 2 = SALIDAS
 * @apiParam {int} [geofenceID] ID de geocerca. Filtro que permite obtener solo reportes de una geocerca especifica. 
 * @apiParam {string} [paginationToken] Token que sera utilizado para avanzar o retroseder en la paginacion. 
 * 
 * @apiSuccess {object[]} reports Arreglo que contiene reportes
 * @apiSuccess {object} report objeto que contiene la informacion de un reporte
 * @apiSuccess {int} report.id ID de la notificacion
 * @apiSuccess {int} report.timestamp Timestamp de la notificacion
 * @apiSuccess {string} report.behaviorID Tipo de comportamiento
 * @apiSuccess {int} report.behaviorString Tipo de comportamiento en formato string
 * @apiSuccess {string} report.geofenceType Tipo (geocerca o punto de interes)
 * @apiSuccess {int} report.geofenceString Tipo (geocerca o punto de interes) en formato string
 * @apiSuccess {string} report.geofenceID ID de la geocerca
 * @apiSuccess {int} report.geofenceNamee Nombre de la geocerca
 * @apiSuccess {double} report.reportID ID del reporte (reporte del dispositivo) que activo la alerta
 * @apiSuccess {double} report.lat Latitud del dispositivo cuando se genero la notificacion
 * @apiSuccess {string} report.lng Longitud del dispositivo cuando se genero la notificacion
 * @apiSuccess {int} report.address Direccion donde se encontraba el dispositivo cuando se genero la notificacion
 * @apiSuccess {int} report.deviceID ID del dispositivo
 * @apiSuccess {string} report.deviceImei Imei del dispositivo
 * @apiSuccess {object} report.deviceAlias Alias del dispositivo
 * 
 * @apiSuccessExample Success-Example 
 * {"success":true,"statusCode":200,"pagination":{"self":"Tzo4OiJzdGRDbGFzcyI6ODp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY2NTg3MTU3IjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO047czo1OiJsaW1pdCI7aTozMDA7czo4OiJiZWhhdmlvciI7TjtzOjEwOiJnZW9mZW5jZUlEIjtzOjI6IjcxIjtzOjEwOiJwYWdpbmF0aW9uIjtpOjA7fQ==","next":"","prev":""},"data":{"reports":[{"id":"49","timestamp":"1566587167","behaviorID":"1","behaviorString":"IN","geofenceType":"1","geofenceTypeString":"GEOFENCE","geofenceID":"71","geofenceName":"Parque Hundido","reportID":"556731","lat":"19.378077430849","lng":"-99.1791200637817","address":"Avenida Insurgentes Sur, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX","deviceID":"45","imei":"0001","alias":"Disp Prueba"},{"id":"48","timestamp":"1566587161","behaviorID":"2","behaviorString":"OUT","geofenceType":"1","geofenceTypeString":"GEOFENCE","geofenceID":"71","geofenceName":"Parque Hundido","reportID":"556730","lat":"19.3761746634512","lng":"-99.1768455505371","address":"Magnolias, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX","deviceID":"45","imei":"0001","alias":"Disp Prueba"},{"id":"47","timestamp":"1566587157","behaviorID":"1","behaviorString":"IN","geofenceType":"1","geofenceTypeString":"GEOFENCE","geofenceID":"71","geofenceName":"Parque Hundido","reportID":"556729","lat":"19.3781583991814","lng":"-99.1786050796509","address":"Avenida Insurgentes Sur, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX","deviceID":"45","imei":"0001","alias":"Disp Prueba"}]}}
 * 
 * 
*/


