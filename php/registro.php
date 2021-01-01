<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Cafeteria - Registro</title>
</head>

<body>

    <form action="" class="form">
        <ul>
            <li class="titulo">
                <h2>Registro</h2>
                <div class="img-log" ><img src="../img/log-cafe.png" alt=""></div>
            </li>    
            <li>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nom" id="nombre" placeholder="Nombre"  required/>
                
            </li>
            <li>
                <label for="apellido">Apellido:</label>
                <input type="text" name="ape" id="apellido" placeholder="Apellido"  required/>
                
            </li>
            <li>
                <label for="telefono">Telefono:</label>
                <input type="number" name="tel" id="telefono" required/>
                
            </li>
            <li>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usr" id="usuario" placeholder="Usuario"  required/>
                
            </li>
            <li>
                <label for="pass">Password:</label>
                <input type="password" name="pass" id="password" placeholder="Password" requiered />
            </li>
            <li class="boton">
                <button class="btn" id="btn_reg" type="button">Enviar</button>
            </li>


        </ul>
    </form>



</body>

</html>

<script>
    $(document).ready(function() {

        $('#btn_reg').click(function() {
            let nom = $('#nombre').val();
            let ape = $('#apellido').val();
            let tel = $('#telefono').val();
            let pass = $('#password').val();
            let usr = $('#usuario').val();
            

            $.post('modulo_BD.php', {
                accion: 'registro',
                nombre: nom,
                apellido: ape,
                telefono: tel,
                password: pass,
                usuario: usr
                
            }, function(data) {

                console.log(data);
                
                switch(data){
                case 'succes':
                    alert('Bienvenido!!!!!!');
                    location.href= '../index.php';
                break;
                case 'error':
                    alert('Error');
                break;
                }

            })


        })



    });
</script>