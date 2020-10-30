# infowindoswDispositivo

infowindows con datos del dispositivo

## Props

<!-- @vuese:infowindoswDispositivo:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|deviceID|-|—|`false`|-|
|no|-|—|`false`|-|
|deviceImei|-|—|`false`|-|

<!-- @vuese:infowindoswDispositivo:props:end -->


## Events

<!-- @vuese:infowindoswDispositivo:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|onShowStreetView|-|-|

<!-- @vuese:infowindoswDispositivo:events:end -->


## Methods

<!-- @vuese:infowindoswDispositivo:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|loadInfo|Se obtiene la informacion del dispositivo a consultar|-|
|interval|Ejecuta la funcion `updateString` cada 10 segundos|-|
|updateString|Obtiene la fecha y tiempo transcurrido en que reporto el dispositivo|-|
|deviceParoMotor|Manda datos y abrir modal para realizar paro de motor|-|
|localizar|Manda a localizar dispositivo mediente webSocket|-|
|showStreetView|Manda a abrir street view de la posicion del dispositivo|-|

<!-- @vuese:infowindoswDispositivo:methods:end -->


## Computed

<!-- @vuese:infowindoswDispositivo:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|permission_paroMotor|-|Obtiene si tiene permiso para realizar paro de motor|No|
|StringLat|-|Crea string de latitud|No|
|StringLng|-|Crea string de longitud|No|
|stringSpeed|-|Crea string de velocidad|No|

<!-- @vuese:infowindoswDispositivo:computed:end -->


## MixIns

<!-- @vuese:infowindoswDispositivo:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:infowindoswDispositivo:mixIns:end -->


