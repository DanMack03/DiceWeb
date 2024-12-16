<?php
session_start();

function navegacion()
{
    if (isset($_SESSION['usuario'])) {
        include("views/viewnavegadorsesion.php");
    } else {
        include("views/viewnavegadorsinsesion.php");
    }
}

function seleccionarcontenido()
{
    if (isset($_GET['viewinstrucciones'])) {
        include("../views/viewinstrucciones.php");
    }
    if (isset($_GET['viewjugar'])) {
        include("../views/viewjugar.php");
    }
    if (isset($_GET['viewiniciarsesion'])) {
        include("../views/viewiniciarsesion.php");
    }
    if (isset($_GET['iniciarsesion'])) {
        iniciarsesion($texto);
    }
    if (isset($_GET['cerrarsesion'])) {
        cerrarsesion($texto);
    }
    if (isset($_GET['jugar'])) {
        jugar();
    }
    if (isset($_GET['terminarjuego'])) {
        terminarjuego();
    }
    if (isset($_GET['puntuacionmaxima'])) {
        puntuacionmaxima();
    }
    if (isset($texto))
        echo $texto;
}

function jugar()
{
    if (!isset($_COOKIE['puntos'])) {
        $puntos = 0;
    } else {
        $puntos = $_COOKIE['puntos'];
    }
    if (!isset($_COOKIE['puntosmax'])) {
        $puntosmax = 0;
    } else {
        $puntosmax = $_COOKIE['puntosmax'];
    }
    $resultado=0;
    $dado1 = rand(1, 6);
    $dado2 = rand(1, 6);
    echo "<p>Los dados lanzados han sido $dado1 y $dado2</p>";
    if ($dado1 == $dado2) {
        $resultado = $dado1*5;
    } else {
        $resultado=$dado1+$dado2;
    }
    $puntos = $resultado + $puntos;
    if ($puntos > $puntosmax) {
        if ($puntos < 61) {
            $puntosmax = $puntos;
        }
    }
    setcookie('puntos', $puntos, time() + 3600);
    setcookie('puntosmax', $puntosmax, time() + 3600);
    if ($puntos > 60) {
        echo "<p>¡Te has pasado de puntos! Llevas $puntos</p>";
        echo "<p>Has perdido, dale al botón para jugar de nuevo</p>";
        echo "<a href='../include/principal.php?jugar'><button>Jugar de nuevo</button></a>";
        $puntos = 0;
        setcookie('puntos', $puntos, time() + 3600);
    } else if ($puntos > 50 && $puntos < 60) {
        echo "<p>¡Has ganado el juego! Ahora mismo tienes $puntos puntos</p>";
        echo "<p>¿Deseas arriesgarte y jugar de nuevo, o echarte para atrás con tu puntuación actual?</p>";
        echo "<a href='../include/principal.php?jugar'><button>Jugar de nuevo</button></a>";
        echo "<a href='../include/principal.php?terminarjuego'><button>Terminar</button></a>";
    } else if ($puntos == 60) {
        echo "<p>¡Has ganado por completo! Has obtenido la puntuación máxima de $puntos puntos</p>";
        echo "<a href='../include/principal.php?terminarjuego'><button>Terminar</button></a>";
    } else {
        echo "<p>Ahora mismo tienes $puntos puntos</p>";
        echo "<p>¿Deseas jugar de nuevo?</p>";
        echo "<a href='../include/principal.php?jugar'><button>Jugar de nuevo</button></a>";
    }
}

function iniciarsesion(&$texto)
{
    $_SESSION['usuario'] = $_POST['usuario'];
    $texto = "Sesion iniciada por " . $_SESSION['usuario'];
}

function cerrarsesion(&$texto)
{
    session_destroy();
    $texto = "Sesion finalizada";
}

function terminarjuego()
{
    $puntos = $_COOKIE['puntos'];
    echo "<p>Juego finalizado con $puntos puntos</p>";
    $puntos = 0;
    setcookie('puntos', $puntos, time() + 3600);
    echo "<a href='../index.php'><button>Volver a la pantalla principal</button></a>";
}

function puntuacionmaxima()
{
    if (!isset($_COOKIE['puntosmax'])) {
        echo "<p>Aún no se ha iniciado una partida como para tener puntos máximos</p>";
    } else {
        $puntosmax = $_COOKIE['puntosmax'];
        echo "<p>La puntuación máxima obtenida es de $puntosmax</p>";
    }
}
