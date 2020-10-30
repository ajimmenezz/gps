<?php


  echo $_POST['img'];


    
// $file = $_FILES['img']; //Asignamos el contenido del parametro a una variable para su mejor manejo
		
// $temName = $file['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
// $fileName = $file['name']; //Obtenemos el nombre del archivo
// $filesize = $file["size"]; //tamaño
// $fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.
// // $nombreArchivo=$_FILES['logo']['type'];


// if  ($fileExtension =='png' ){ 
//     $mime = 'image/png';

//     if(filesize<=2000000){ //menos igual a 2 mb

//         $dir='../../img/storage/Distribuidores/'.$cliente."/logotipo";
//         echo $dir;
//         $nombreArchivo=$_FILES['logo']['name'];
        
//         // Si no existe el directorio lo creas
        
//         if ( !is_dir( $dir ) ){
//           mkdir($dir);
//         }


        
//         // Ahora puedes mover la imagen al directorio
        
//         if (!move_uploaded_file($_FILES['foto']['tmp_name'],$dir)){
//         echo "nombre: " .$_FILES['foto']['name']."<br>";
//         echo "ruta temporal: ".$_FILES['foto']['tmp_name']."<br>";
//         echo "tipo archivo: ".$_FILES['foto']['type']."<br>";
//         echo "tamaño: ".$_FILES['foto']['size']."<br>";
//         echo "errores: ".$_FILES['foto']['error']."<br>";
//             echo "error en la subida de la foto<br>";
//             echo "<a href='../views/empleadoAltaFormulario.php'>Volver</a>";
//             exit;
//         }

//     }
//  }



?>