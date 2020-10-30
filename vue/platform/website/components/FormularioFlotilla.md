# FormularioFlotilla

formulario para crear, editar y consultar usuarios

## Methods

<!-- @vuese:FormularioFlotilla:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|getDevices|Obtiene el listado de dispositivos|-|
|register|Registra al usuario junto con todos sus datos|-|
|editar|Actualiza la informacion del usuario que se haya modificado|-|
|validar_email|verifica que el correo sea valido|`email` Correo electronico del usuario|
|getUser|Obtiene la informacion del usuario a consultar|`userID` Id de usuario|
|zonaHoraria|Obtiene catalogo de las zonas horarias|-|
|onKeyUp|convierte el valor del campo usuario todo a minusculas|`e` cadena del campo usuario|
|cancel|cancela el proceso y regresa a la tabla de usuarios|-|

<!-- @vuese:FormularioFlotilla:methods:end -->


## Computed

<!-- @vuese:FormularioFlotilla:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|listZonasHor|-|Obtiene listado de zonas horarias|No|
|listDEviceC|-|Obtiene listado de dispositivos|No|

<!-- @vuese:FormularioFlotilla:computed:end -->


## MixIns

<!-- @vuese:FormularioFlotilla:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:FormularioFlotilla:mixIns:end -->


