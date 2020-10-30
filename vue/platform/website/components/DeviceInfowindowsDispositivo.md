# DeviceInfowindowsDispositivo

Deviceinfowindows de los datos de dipositivo

## Events

<!-- @vuese:DeviceInfowindowsDispositivo:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|closeList|manda a cerrar el panel|-|

<!-- @vuese:DeviceInfowindowsDispositivo:events:end -->


## Methods

<!-- @vuese:DeviceInfowindowsDispositivo:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|onWindowResizeInfo|Manda a llamar la funcion para calcular los tamaños de pantalla|-|
|resizeDraggableInfo|Se obtiene el alto y ancho de pantalla total y se estable el tamaño y posicion del panel de dispositivos restandole los valores de head y footer para establecer el scroll del contenido|-|
|closeList|Cierra el panel|-|
|clearDevices|Limpia valores y store de dispositivos|-|
|loadInfo|Se obtiene la informacion del dispositivo a consultar|-|
|interval|Ejecuta la funcion `updateString` cada 10 segundos|-|
|updateString|Obtiene la fecha y tiempo transcurrido en que reporto el dispositivo|-|
|localizar|Manda a localizar dispositivo mediente webSocket|-|
|showStreetView|Manda a abrir street view de la posicion del dispositivo|-|

<!-- @vuese:DeviceInfowindowsDispositivo:methods:end -->


## Computed

<!-- @vuese:DeviceInfowindowsDispositivo:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|permission_paroMotor|-|Obtiene si tiene permiso para realizar paro de motor|No|
|StringLat|-|Crea string de latitud|No|
|StringLng|-|Crea string de longitud|No|
|stringSpeed|-|Crea string de velocidad|No|

<!-- @vuese:DeviceInfowindowsDispositivo:computed:end -->


## MixIns

<!-- @vuese:DeviceInfowindowsDispositivo:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:DeviceInfowindowsDispositivo:mixIns:end -->


