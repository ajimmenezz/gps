# ModalParoMotor

Modal para realizar paro de motor

## Events

<!-- @vuese:ModalParoMotor:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|SET_MARKER_ICON|-|-|

<!-- @vuese:ModalParoMotor:events:end -->


## Methods

<!-- @vuese:ModalParoMotor:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|confirmModal|Si confirma el paro de motor, verifica que exista una contraseña, que no este expirada y sea correcta si esto es correcto madna a realizar el paro|-|
|WS_SET_IGNITION|Manda a realizar el paro de motor por webSocket|-|
|isPassword|Valida la contraseña de paro de motor|-|
|passwordExist|Valida si existe contraseña de paro de motor|-|
|passwordExpired|Valida si no ha expirado la contraseña de paro de motor|-|

<!-- @vuese:ModalParoMotor:methods:end -->


## MixIns

<!-- @vuese:ModalParoMotor:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:ModalParoMotor:mixIns:end -->


