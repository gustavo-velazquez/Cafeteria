<?php 

include('conexion_BD.php');


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
        <div id="menu">
        
        <?php include 'menu.php'?>

            <div class="titulo">
                <h1>Café <br>Atlántico</h1>
            </div>
        </div>
    </header>
    
    <main>
        
        <section class="sn" id="SobreNosotros">
            <div class="sn_img"><img src="../img/cafe-icono.jpg" alt=""></div>
            <div class="sn_txt">
            <h1>Sobre Nosotros</h1>
            <p >Café con pasión Fundamos esta cafetería con una idea clara: Compartir nuestra gran pasión por el café. 
                <br><br><span>
                El Café Atlantico es el lugar perfecto para relajarse y charlar en buena compañía al calor de una 
                deliciosa taza de café, malta, té o cualquier otra infusión. En nuestras tiendas y cafeterías encontrarás 
                un clima cálido y familiar en el que poder disfrutar de los productos más selectos del mercado, 
                elaborados con una cuidada preparación que garantiza una frescura y aroma únicos.
                </span> </p>
            </div>
            
        </section>

        <section class="pr" id="productos">

        <div class="pr_menu" id="menu-productos">
            <div class="mimg"><img src="../img/co.png" alt=""></div>
            <div class="mleft">
                        <?php    
                        $consulta = "SELECT * FROM productos limit 5";
                        $resultado = mysqli_query($conexion, $consulta);
                        
                        while($fila = mysqli_fetch_array($resultado)){
                            echo '<div class="m1">
                            <div class="detalle"><h1>'.$fila['nombre'].'</h1></div>
                            <div class="precio"><p>$ '.$fila['precio'].
                            '</p></div>
                            </div>';
                        }
                        ?>
                        
            </div>

            <div class="mrigth">
            <?php     
                $consulta = "SELECT * FROM productos order by id_producto DESC limit 5";
                $resultado = mysqli_query($conexion, $consulta);

                        while($fila = mysqli_fetch_array($resultado)){
                            echo '<div class="m1">
                            <div class="detalle"><h1>'.$fila['nombre'].'</h1></div>
                            <div class="precio"><p>$ '.$fila['precio'].
                            '</p></div>
                            </div>';
                        }
            ?>
            </div>
            <div class="reserva"><button>  <a href="form_reserva.php">Reservar Mesa</a> </button></div>
                
        </div>

        </section>

        
    </main>

    <?php include 'footer.php'?>

</body>
</html>

