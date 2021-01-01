<?php
    $accion=$_POST['accion'];

    include('conexion_BD.php');

    switch($accion){

        case 'login':

            //$dni= $_POST['dni'];
            $usr = strip_tags(addslashes($_POST['usuario']));
            $password =strip_tags(addslashes($_POST['password']));
            $captcha = strip_tags(addslashes($_POST['captcha']));

            session_start();

            if($captcha==$_SESSION['txt']){
                

                $consulta = "SELECT pass,nombre,apellido,idUsuario,tipo_usuario from usuarios where usuario='".$usr."'";
                $resultado = mysqli_query($conexion,$consulta);
                $res = mysqli_fetch_array($resultado);

                if(password_verify($password,$res['pass'])){
                    //session_start();
                    $_SESSION['nombre_usr'] = $res['nombre'];
                    $_SESSION['apellido_usr'] = $res['apellido'];
                    $_SESSION['id_usr'] = $res['idUsuario'];

                    if($res['tipo_usuario']=='admin')
                        echo 'log_admin';
                    else
                        echo 'log_cliente';

                }else
                {
                    echo 'error';
                }
            }
            else{
                echo 'captchaError';
            }
        break;

        case 'registro':

            $opciones = [
                'cost' => 12,
            ];
            $pass=password_hash(strip_tags(addslashes($_POST['password'])), PASSWORD_BCRYPT, $opciones);

            $nombre = strip_tags(addslashes($_POST['nombre']));
            $apellido = strip_tags(addslashes($_POST['apellido']));
            $telefono =strip_tags(addslashes( $_POST['telefono']));
            $usuario =strip_tags(addslashes( $_POST['usuario']));
            //$pass = $_POST['password'];
            $tipo_usr = 'cliente';


            $consulta = "INSERT INTO `usuarios`( `nombre`, `apellido`, `Telefono`, `usuario`, `pass`, `tipo_usuario`)  
                          VALUES ('".$nombre."', '".$apellido."', ".$telefono.", '".$usuario."','".$pass."','".$tipo_usr."')";

            $resultado = mysqli_query($conexion, $consulta);
      
            if ($resultado)
            {
              echo 'succes';
            } else {
              echo 'error';
            }
      
          break;

          case 'reserva':

            session_start();

            $id_usr = $_SESSION['id_usr'];
            $mesa = $_POST['mesa'];
            $fecha = $_POST['fecha_reserva'];


            $consulta = "INSERT INTO `reserva`(`fecha_reserva`, `id_mesa`, `idUsuario`)
                          VALUES ('".$fecha."',".$mesa.",".$id_usr." )";

            
            $resultado = mysqli_query($conexion, $consulta);
      
            if ($resultado)
            {
              echo 'succes';
              $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Nueva Reserva')";
              $resultado = mysqli_query($conexion, $consulta);
            } else {
              echo 'error';
            }
      
          break;

          case 'mostrar':

            session_start();

            $id_usr = $_SESSION['id_usr'];

            $consulta = "SELECT * FROM reserva where idUsuario = '".$id_usr."' limit 8" ;
            $resultado = mysqli_query($conexion, $consulta);

            echo "<h1>Mis Reservas</h1><center>
            <table class='tablita'>
            <tr class='tablita'>
              <th>ID Reserva</th>
              <th>Fecha</th>
              <th>Mesa</th>
              <th>Id Usuario</th>
              <th>Cancelar</th>
            </tr>";
      
            while ($fila = mysqli_fetch_array($resultado)) {
              echo "<tr class='tablita'>
                      <td>".$fila['id_reserva']."</td>
                      <td>".$fila['fecha_reserva']."</td>
                      <td>".$fila['id_mesa']."</td>
                      <td>".$fila['idUsuario']."</td>
                      <td><button class='btn_eliminar' data-id=".$fila['id_reserva'].">X</button></td>
                    </tr>";
            }
            echo "</table></center>";
            break;


            case 'eliminar_reserva':

              session_start();

              $id_usr = $_SESSION['id_usr'];

              $reserva = $_POST['reserva'];

              $consulta = "DELETE FROM reserva WHERE id_reserva = '".$reserva."' ";
              $resultado = mysqli_query($conexion, $consulta);
              
              $error =  mysqli_error($conexion);

              if ($error == ''){
                echo 'succes';
                $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Cancelar Reserva')";
                $resultado = mysqli_query($conexion, $consulta);
                
              }else
              {
                echo 'error';
              }
              break;


              case 'mostrar_todo':

                $tabla = $_POST['usuario'];

                $consulta = "SELECT * FROM {$tabla} " ;
                $resultado = mysqli_query($conexion, $consulta);

              switch ($tabla){

                case 'productos':

                  echo "<h1>Productos</h1><center>
                        <table class='tablita'>
                        <tr class='tablita'>
                         
                          <th>Nombre</th>
                          <th>Precio</th>
                          <th>Eliminar</th>
                        </tr>";
      
                    while ($fila = mysqli_fetch_array($resultado)) {
                      echo "<tr class='tablita'>
                              <td>".$fila['nombre']."</td>
                              <td>".$fila['precio']."</td>
                              <td><button class='btn_eliminar btn_eliminar_pro' data-id=".$fila['id_producto'].">X</button></td>
                            </tr>";
                    }
                    echo "</table></center>";
                   

                  break;

                case 'usuarios':

                  echo "<h1>Usuarios</h1><center>
                        <table class='tablita'>
                        <tr class='tablita'>
                         
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Telefono</th>
                          <th>Usuario</th>
                          <th>Tipo Usuario</th>
                          <th>Eliminar</th>
                        </tr>";
      
                    while ($fila = mysqli_fetch_array($resultado)) {
                      echo "<tr class='tablita'>
                              <td>".$fila['nombre']."</td>
                              <td>".$fila['apellido']."</td>
                              <td>".$fila['Telefono']."</td>
                              <td>".$fila['usuario']."</td>
                              <td>".$fila['tipo_usuario']."</td>
                              <td><button class='btn_eliminar btn_eliminar_usuario' data-id=".$fila['idUsuario'].">X</button></td>
                            </tr>";
                    }
                    echo "</table></center>";

                  break;

                

                    case 'mesas':

                      echo "<h1>Mesas</h1><center>
                            <table class='tablita'>
                            <tr class='tablita'>
                              <th>Id Mesa</th>
                              <th>Detalle</th>
                              <th>Eliminar</th>

                            </tr>";
          
                        while ($fila = mysqli_fetch_array($resultado)) {
                          echo "<tr class='tablita'>
                                  <td>".$fila['id_mesa']."</td>
                                  <td>".$fila['detalle']."</td>   
                                  <td><button class='btn_eliminar btn_eliminar_mesa' data-id=".$fila['id_mesa'].">X</button></td>                              
                                </tr>";
                        }
                        echo "</table></center>";
                        
    
                      break;

              

                  case 'reserva':

                    echo "<h1>Reservas</h1><center>
                          <table class='tablita'>
                          <tr class='tablita'>
                            <th>Id Reserva</th>
                            <th>Fecha</th>
                            <th>Mesa</th>
                            <th>Id Usuario</th>
                            <th>Cancelar</th>
                          </tr>";
        
                      while ($fila = mysqli_fetch_array($resultado)) {
                        echo "<tr class='tablita'>
                                <td>".$fila['id_reserva']."</td>
                                <td>".$fila['fecha_reserva']."</td>
                                <td>".$fila['id_mesa']."</td>
                                <td>".$fila['idUsuario']."</td>
                                <td><button class='btn_eliminar btn_eliminar_reserva' data-id=".$fila['id_reserva'].">X</button></td>
                              </tr>";
                      }
                      echo "</table></center>";

                    break;

                    case 'historial_cambios':

                      echo "<h1>Historial de Cambios</h1><center>
                            <table class='tablita'>
                            <tr class='tablita'>
                              <th>Id historial</th>
                              <th>Id Usuario</th>
                              <th>Fecha</th>
                              <th>Detalle</th>
                              
                            </tr>";
          
                        while ($fila = mysqli_fetch_array($resultado)) {
                          echo "<tr class='tablita'>
                                  <td>".$fila['id']."</td>
                                  <td>".$fila['idUsuario']."</td>
                                  <td>".$fila['fecha']."</td>  
                                  <td>".$fila['detalle']."</td>                               
                                  
                                </tr>";
                        }
                        echo "</table></center>";

                      break;

              }

            break;

            case 'eliminar_mesa':

              session_start();

              $id_usr = $_SESSION['id_usr'];

              $id_mesa = $_POST['mesa'];

              $consulta = "DELETE FROM mesas WHERE id_mesa = '".$id_mesa."' ";
              $resultado = mysqli_query($conexion, $consulta);
              
              $error =  mysqli_error($conexion);

              if ($error == ''){
                echo 'ok';
                $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Eliminar mesa')";
                $resultado = mysqli_query($conexion, $consulta);
                
              }else
              {
                echo 'error';
              }
              break;


              case 'agregar_mesa':

                session_start();

              $id_usr = $_SESSION['id_usr'];

                $detalle = strip_tags(addslashes($_POST['detalle']));
                
    
    
                $consulta = "INSERT INTO `mesas`( `detalle`)
                              VALUES ('".$detalle."')";
    
                
                $resultado = mysqli_query($conexion, $consulta);
          
                if ($resultado)
                {
                  echo 'ok';
                  $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Mesa agregada')";
                  $resultado = mysqli_query($conexion, $consulta);
                } else {
                  echo 'error';
                }
          
              break;

              case 'agregar_producto':

                session_start();

              $id_usr = $_SESSION['id_usr'];

                $nombre = strip_tags(addslashes($_POST['nombre']));
                $precio = strip_tags(addslashes($_POST['precio']));
                
    
    
                $consulta = "INSERT INTO `productos`(`nombre`, `precio`)
                 VALUES ('".$nombre."','".$precio."')";
    
                
                $resultado = mysqli_query($conexion, $consulta);
          
                if ($resultado)
                {
                  echo 'ok';
                  $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Producto agregada')";
                  $resultado = mysqli_query($conexion, $consulta);
                } else {
                  echo 'error';
                }
          
              break;

              case 'eliminar_producto':

                session_start();
  
                $id_usr = $_SESSION['id_usr'];
  
                $idpro = $_POST['producto'];
  
                $consulta = "DELETE FROM productos WHERE id_producto = '".$idpro."' ";
                $resultado = mysqli_query($conexion, $consulta);
                
                $error =  mysqli_error($conexion);
  
                if ($error == ''){
                  echo 'ok';
                  $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Eliminar producto')";
                  $resultado = mysqli_query($conexion, $consulta);
                  
                }else
                {
                  echo 'error';
                }
                break;

              case 'eliminar_usuario':

                session_start();
  
                $id_usr = $_SESSION['id_usr'];
  
                $id_usuario = $_POST['usuario'];
  
                $consulta = "DELETE FROM usuarios WHERE idUsuario = '".$id_usuario."' ";
                $resultado = mysqli_query($conexion, $consulta);
                
                $error =  mysqli_error($conexion);
  
                if ($error == ''){
                  echo 'ok';
                  $consulta = "INSERT INTO `historial_cambios`(`idUsuario`, `fecha`, `detalle`) VALUES ('".$id_usr."',Now(),'Eliminar Usuario')";
                  $resultado = mysqli_query($conexion, $consulta);
                  
                }else
                {
                  echo 'error';
                }
                break;

      

    }

?>