<?php

    session_start();

    /*if(!isset($_SESSION['nombre_usr']))
    {
    header('Location: http://localhost/Empresa');
    }*/



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    
    <title>Empresa</title>
</head>
<body>
<header>
        <?php include 'menu.php'?>
</header>
    
    <main class="cont">
    
    <form action="" class="form">
        <ul>
            <li class="titulo">
                <h2>Reservar Mesa</h2>
            </li>
            
            <li>
                <label for="Nombre" >Nombre:</label>
                <input type="text" name="nom" id="id_nombre" value="<?php echo $_SESSION['nombre_usr'] ?>" disabled/>
                
            </li>
            <li>
                <label for="Apellido">Apellido:</label>
                <input type="text" name="ape" id="id_apellido" value="<?php echo $_SESSION['apellido_usr'] ?>" disabled/>
            </li>

            <li>
                <label for="fecha">Fecha:</label>
                <input type="datetime-local" name="fe" id="id_fecha" />
            </li>

            <li>
                <label for="">Mesa: </label>
                <select name="select_mesa" id="mesa">
                    <?php 
                    include ('conexion_BD.php');

                    $consulta = "SELECT * FROM mesas";
                    $resultado = mysqli_query($conexion,$consulta);
                    
                    foreach ($resultado as $res):
                    ?>

                    <option value=" <?php echo $res['id_mesa'] ?>"><?php echo $res['id_mesa'] ?></option> 

                    <?php endforeach ?>

                </select>
            </li>

            <li class="boton">
                <button class="btn" id="btn_reserva" type="button">Reserevar</button>
                <button class="btn btn_cancelar" id="btn_cancelar" type="button">Mis reservas</button>
            </li>
        </ul>
    </form>
    
    <div id="mostrar"></div>
        
    </main>

    <?php include 'footer.php'?>



</body>
</html>

<script>
$(document).ready(function() {

    $('#btn_reserva').click(function() {
        let fecha = $('#id_fecha').val();
        let mesa = $('#mesa').val();

        $.post('modulo_BD.php', {
            accion: 'reserva',
            fecha_reserva: fecha,
            mesa: mesa

        }, function(data) {

            console.log(data);
            
            switch(data){
                case 'succes':
                    alert('Reserva exitosa!!!!!!');
                    location.href= 'form_reserva.php';
                break;
                case 'error':
                    alert('Error');
                break;
            }
        })
    })

    $('#btn_cancelar').click(function(){
      $('#mostrar').load('modulo_BD.php', {accion:'mostrar'});
    });

    $(document).on('click','.btn_eliminar',function(){
	let id = $(this).data('id');

        $.post('modulo_BD.php',{accion:'eliminar_reserva',reserva:id},function(data) {

            console.log(data);

            switch(data){
                case 'succes':
                    alert('Eliminacion exitosa!!!!!!');
                break;
                case 'error':
                    alert('Error');
                break;
            }
        })
    })

});

</script>