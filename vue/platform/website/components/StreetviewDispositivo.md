# StreetviewDispositivo

StreetView de dirección de dispositivo

## Props

<!-- @vuese:StreetviewDispositivo:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|top|valor del top del componente|`Number`|`false`|-|
|left|valor a la derecha|`Number`|`false`|-|
|height|valor de alto del componente|`Number`|`true`|-|
|width|valor de ancho del componente|`Number`|`true`|-|
|deviceName|nombre del dipositivo|`String`|`false`|-|
|deviceImei|Imei del dispositivo|`String`|`false`|-|
|time|hora del dispositivo|`Number`|`false`|-|
|address|direccion del dispositivo|`String`|`false`|-|
|lat|latitud de la direccion de dispositivo|`Number`|`true`|-|
|lng|longitud de la direccion de dispositivo|`Number`|`true`|-|

<!-- @vuese:StreetviewDispositivo:props:end -->


## Events

<!-- @vuese:StreetviewDispositivo:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|onClose|-|-|

<!-- @vuese:StreetviewDispositivo:events:end -->


## Methods

<!-- @vuese:StreetviewDispositivo:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|customize|Estable si se muestra o no el panel de control de zoom del mapa|-|
|setDraggablePosition|Se obtiene el alto y ancho de pantalla total y se estable la posicion del componente.|-|
|close|Cierra el componente|-|

<!-- @vuese:StreetviewDispositivo:methods:end -->


## Watch

<!-- @vuese:StreetviewDispositivo:watch:start -->
|Name|Description|Parameters|
|---|---|---|
|height|Establece el valor de alto|-|
|width|Establece el valor de ancho|-|
|deviceName|Establece el valor de nombre de dispositivo|-|
|time|Establece el valor de nombre de hora|-|
|address|Establece el valor de nombre de direccion|-|
|lat|Establece el valor de latitud de dispositivo|-|
|lng|Establece el valor de longitud de dispositivo|-|

<!-- @vuese:StreetviewDispositivo:watch:end -->


