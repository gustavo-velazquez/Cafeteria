
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
<nav >
    <ul>
                    
                    <li><a class="btn_admin" href="cerrarSesion.php">Salir</a></li>
                    <li><button class="btn_admin" id="btn_pr" >Productos</button></li>
                    <li><button class="btn_admin" id="btn_res" >Reservas</button></li>
                    <li><button class="btn_admin" id="btn_mesa" >Mesas</button></li>
                    <li><button class="btn_admin" id="btn_his">Historial</button></li>
                    <li><button class="btn_admin" id="btn_usr">Usuarios</button></li>
                    
                    
                </ul>
    </nav>
</header>
    
    <main class="con_admin">

    
    <div id="mostrar_todo"></div>

    <div class="btn_a">

    <button class='btn_agregar' id='btn_agregar_mesa'>Agregar mesa</button>
        
    </div>

    <div class="btn_a">

    <button class='btn_agregar' id='btn_agregar_pro'>Agregar producto</button>
        
    </div>

    </main>


    <?php include 'footer.php'?>

</body>
</html>

<script>
$(document).ready(function() {

    $('#btn_agregar_mesa').hide();
    $('#btn_agregar_pro').hide();

    $('#btn_usr').click(function(){
        $('#btn_agregar_mesa').hide();
        $('#btn_agregar_pro').hide();
      $('#mostrar_todo').load('modulo_BD.php', {accion:'mostrar_todo',usuario:'usuarios'});
    });

    $('#btn_res').click(function(){
        $('#btn_agregar_mesa').hide();
        $('#btn_agregar_pro').hide();
        $('#mostrar_todo').load('modulo_BD.php', {accion:'mostrar_todo',usuario:'reserva'});
    });

    $('#btn_mesa').click(function(){
        $('#btn_agregar_mesa').show();
        $('#btn_agregar_pro').hide();

    $('#mostrar_todo').load('modulo_BD.php', {accion:'mostrar_todo',usuario:'mesas'});
    });

    $('#btn_his').click(function(){
        $('#btn_agregar_mesa').hide();
        $('#btn_agregar_pro').hide();
    $('#mostrar_todo').load('modulo_BD.php', {accion:'mostrar_todo',usuario:'historial_cambios'});
    });

    $('#btn_pr').click(function(){
        $('#btn_agregar_mesa').hide();
        $('#btn_agregar_pro').show();

    $('#mostrar_todo').load('modulo_BD.php', {accion:'mostrar_todo',usuario:'productos'});
    });

    //Eliminar mesa

    $(document).on('click','.btn_eliminar_mesa',function(){
	let id = $(this).data('id');

        $.post('modulo_BD.php',{accion:'eliminar_mesa',mesa:id},function(data) {

            console.log(data);

            switch(data){
                case 'ok':
                    alert('Eliminacion exitosa!!!!!!');
                    location.href= 'admin.php';
                break;
                case 'error':
                    alert('Error');
                break;
            }
        })
    })


    //Agregar mesa

    $(document).on('click','#btn_agregar_mesa',function(){

        
        let det = prompt("Ingrese un detalle para la mesa");

        if (det != undefined) {

            $.post('modulo_BD.php',{accion:'agregar_mesa',detalle:det},function(data) {

                console.log(data);

                switch(data){
                    case 'ok':
                        alert('Se agrego nueva mesa!!!!!!');
                        location.href= 'admin.php';
                    break;
                    case 'error':
                        alert('Error');
                    break;
                }
            })

        }
        else
            alert('Inserte un detalle por favor!!')
    })

    //eliminar reserva

    $(document).on('click','.btn_eliminar_reserva',function(){
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

    //Eliminar usuario
    $(document).on('click','.btn_eliminar_usuario',function(){
	let id = $(this).data('id');

        $.post('modulo_BD.php',{accion:'eliminar_usuario',usuario:id},function(data) {

            console.log(data);

            switch(data){
                case 'ok':
                    alert('Eliminacion exitosa!!!!!!');
                    location.href= 'admin.php';
                break;
                case 'error':
                    alert('Error');
                break;
            }
        })
    })

    //Agregar producto

    $(document).on('click','#btn_agregar_pro',function(){

    let nom = prompt("Ingrese nombre del producto");
    let precio = prompt("Ingrese precio del producto");

    if (nom != undefined) {

        $.post('modulo_BD.php',{accion:'agregar_producto',nombre:nom,precio:precio},function(data) {

            console.log(data);

            switch(data){
                case 'ok':
                    alert('Se agrego nuevo producto!!!!!!');
                    location.href= 'admin.php';
                break;
                case 'error':
                    alert('Error');
                break;
                }
        })

    }
    else
        alert('Inserte datos por favor!!')
    })

    //Eliminar producto

    $(document).on('click','.btn_eliminar_pro',function(){
	let id = $(this).data('id');

        $.post('modulo_BD.php',{accion:'eliminar_producto',producto:id},function(data) {

            console.log(data);

            switch(data){
                case 'ok':
                    alert('Eliminacion exitosa!!!!!!');
                    location.href= 'admin.php';
                break;
                case 'error':
                    alert('Error');
                break;
            }
        })
    })


});

</script>