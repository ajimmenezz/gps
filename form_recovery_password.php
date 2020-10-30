<!DOCTYPE html>
<html lang="en">

<head>
    <title>Datta Able - Form elements</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <!-- Favicon icon -->
    <link rel="icon" href="public/assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="public/assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="public/assets/plugins/animation/css/animate.min.css">
     <!-- notification css -->
     <link rel="stylesheet" href="public/assets/plugins/notification/css/notification.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="public/assets/css/style.css">

</head>

<body>
    

      <!-- [ Main Content ] start -->
     
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                   
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                              
                                <!-- start -->
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Recuperar contraseña</h5>
                                        </div>

                                        <div class="card-body">
                                        <form action="recover_password.php"  method="post" autocomplete="off">
                                    
                                            <div class="row">
                                                <div class="offset-md-* col-12 col-md-4"></div>
                                                
                                                <div class="col-12 col-md-4">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label for="passw" >Contraseña nueva</label>
                                                            <input class="form-control" type="password" id="passw" name="passw" required>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label for="confirmPassw" >Confirma contraseña</label>
                                                            <input class="form-control" type="password" id="confirmPassw" name="confirmPassw" required>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-md-12">
                                                        <input type="hidden" id="idUser" name="idUser" value="<?php if(isset($_GET['iduser'])){ echo $_GET['iduser'];} ?>">
                                                        <input type="hidden" id="emailUser" name="emailUser" value="correo">
                                                        <button type="submit" class="btn btn-primary shadow-2 mb-4 float-right">GUARDAR</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="offset-md-* col-12 col-md-4"></div>
                                            </div>
                                            

                                        </form>
                                        </div>
                                       
                                    </div>
                                      
                                </div>
                                <!-- end -->

                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <!-- [ Main Content ] end -->



    <!-- Required Js -->
    <script src="public/assets/js/vendor-all.min.js"></script>
    <script src="public/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="public/assets/js/pcoded.min.js"></script>

    <!-- notification Js -->
    <script src="public/assets/plugins/notification/js/bootstrap-growl.min.js"></script>
    <script src="public/assets/js/pages/ac-notification.js"></script>
    
    
</body>
</html>

<?php 
if(isset($_GET['band'])){

    if($_GET['band']==1){ //exito
       // notify('Contraseña cambiada exitosamente', ,'success');
       ?>
       <script> 
       notify('<b>excelente! </b> ','Contraseña cambiada exitosamente','top', 'right', 'success'); 
      

    </script>
       <?php
    }
}

  

?>
