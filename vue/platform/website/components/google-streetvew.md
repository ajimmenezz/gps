# google-streetvew

componente google street view

## Props

<!-- @vuese:google-streetvew:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|name|nombre|`String`|`true`|-|
|height|alto|`Number`|`false`|300|
|lat|latitud|`Number`|`true`|-|
|lng|longitud|`Number`|`true`|-|
|heading|titulo|`Number`|`false`|-|
|pitch|tono|`Number`|`false`|-|
|addressControl|control de direccion|`Boolean`|`false`|-|
|clickToGoControl|click al control|`Boolean`|`false`|-|
|closeButtonControl|boton de cerrar de control|`Boolean`|`false`|-|
|fullScreenControl|control de pantalla completa|`Boolean`|`false`|-|
|linksControl|control de link|`Boolean`|`false`|-|
|rotateControl|control de rotacion|PanControl|`false`|-|
|roadLabelsControl|control de etiquetas|`Boolean`|`false`|-|
|zoomControl|control de zoom|`Boolean`|`false`|-|

<!-- @vuese:google-streetvew:props:end -->


## Events

<!-- @vuese:google-streetvew:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|onPositionChanged|-|-|

<!-- @vuese:google-streetvew:events:end -->


## Methods

<!-- @vuese:google-streetvew:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|onPositionChanged|Cambio de posicion|`e` evento|
|center|Centrar|`lat` latitud `lng` longitud|

<!-- @vuese:google-streetvew:methods:end -->


## Watch

<!-- @vuese:google-streetvew:watch:start -->
|Name|Description|Parameters|
|---|---|---|
|height|Establece el alto|`value` valor|
|lat|Establece la latitud|`value` valor|
|lng|Establece longitud|`value` valor|
|heading|Establece titulo|`value` valor|
|pitch|Establece tono|`value` valor|
|addressControl|Establece control de direccion|`enabled` valor|
|clickToGoControl|Establece click control|`enabled` valor|
|closeButtonControl|Establece control de cerrar|`enabled` valor|
|fullScreenControl|Establece control pantalla completa|`enabled` valor|
|linksControl|Establece control de link|`enabled` valor|
|rotateControl|Establece control de rotacion|`enabled` valor|
|roadLabelsControl|Establece control de etiquetas|`enabled` valor|
|zoomControl|Establece control de zoom|`enabled` valor|

<!-- @vuese:google-streetvew:watch:end -->


