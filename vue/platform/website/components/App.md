# App

Cotenedor principal de todos los conponentes: `cargando`, `bloqueo`, `modal`, `contenedor principal`, `menu y menu movil`, `mensaje de servidor fuera de linea`

## Methods

<!-- @vuese:App:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|setDraggablePositionMenu|Obtiene tamaño de la pantalla para establecer el tamaño del contenedor del contenido|-|
|loadStore|Cuando se recarga la pagina vuelve a inicializar el store|-|
|getDevices|Obtiene lista de dispositivos|-|
|getFleets|Obtiene lista de flotilla|-|
|getPermissions|Obtiene lista de permisos|-|
|updateInactiveTime|Actualiza ultima inactividad|-|
|checkInactiveTime|Checa cuanto tiempo tiene inactivo el cliente sin hacer nada en el sistema y procede a las acciones correspondientes|-|

<!-- @vuese:App:methods:end -->


## Computed

<!-- @vuese:App:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|showMenu|-|Obtiene si se muestra el menu o no|Yes|
|loginFirst|-|Obtiene si es la primera vez que ingresa al sistema|Yes|
|isVisible|-|Obtiene si se muestra o no el modal|Yes|
|nameComponent|-|Obtiene componente modal|Yes|

<!-- @vuese:App:computed:end -->


## MixIns

<!-- @vuese:App:mixIns:start -->
|MixIn|
|---|
|SecureStorage|
|API|

<!-- @vuese:App:mixIns:end -->


