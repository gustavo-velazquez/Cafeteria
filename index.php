<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Cafeteria - Log In</title>
</head>

<body>

    <form action="" class="form">
        <ul>
            <li class="titulo">
                <h2>Log In</h2>
                <div class="img-log" ><img src="img/log-cafe.png" alt=""></div>
            </li>
            
            <li>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usr" id="usuario" placeholder="Usuario"  />
                
            </li>
            <li>
                <label for="pass">Password:</label>
                <input type="password" name="pass" id="password" placeholder="Password"  />
            </li>
            <li>
                <img id="img_cap" src="captcha/captcha.php" >
                <input type="text" name="captcha_txt" id="captcha" required>
                
            </li>
            <li class="boton">
                <button class="btn" id="btn_log" type="button">Enviar</button>
            </li>

            <li >
                <p>¿No tienes una cuenta?<a href="php/registro.php">Registrate</a></p>
            </li>

        </ul>
    </form>



</body>

</html>

<script>
    $(document).ready(function() {

        $('#btn_log').click(function() {
            let pass = $('#password').val();
            let usr = $('#usuario').val();
            let cap = $('#captcha').val();

            $.post('php/modulo_BD.php', {
                accion: 'login',
                password: pass,
                usuario: usr,
                captcha: cap
            }, function(data) {

                console.log(data);
                
                switch(data){
                    case 'log_cliente':
                        location.href= 'php/inicio.php';
                    break;
                    case 'log_admin':
                        location.href= 'php/admin.php';
                    break;
                    case 'captchaError':
                        alert('Error, captcha incorrecto ');
                        location.href= 'index.php';
                    break;
                    case 'error':
                        alert('Error, Usuario Incorrecto ');
                        location.href= 'index.php';
                    break;
                    case 'vacio':
                        alert('Campos vacios!! ');
                    break;
                }

            })


        })



    });
</script>