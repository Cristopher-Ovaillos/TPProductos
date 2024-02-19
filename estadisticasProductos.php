<?php

function carga_ventas($prodMasVendido)
{
    $ventas = [];
    foreach ($prodMasVendido as $prod) {
        $precio = $prod["precioProd"];
        $cant = $prod["cantProd"];
        $ventas[] = monto_Venta($precio, $cant);
    }
    return $ventas;
}

function prodMasVendido()
{
    $prodMasVendido[0] = ["prod" => 'Heladera Gama', "precioProd" => 90, "cantProd" => 9];
    $prodMasVendido[1] = ["prod" => 'Microondas Samsung', "precioProd" => 75, "cantProd" => 12];
    $prodMasVendido[2] = ["prod" => 'TV Smart Samsung 32', "precioProd" => 150, "cantProd" => 8];
    $prodMasVendido[3] = ["prod" => 'Lavadora LG', "precioProd" => 200, "cantProd" => 5];
    $prodMasVendido[4] = ["prod" => 'Cafetera Philips', "precioProd" => 40, "cantProd" => 15];
    $prodMasVendido[5] = ["prod" => 'Aspiradora Dyson', "precioProd" => 180, "cantProd" => 7];
    $prodMasVendido[6] = ["prod" => 'Aire Acondicionado Panasonic', "precioProd" => 250, "cantProd" => 4];
    $prodMasVendido[7] = ["prod" => 'Licuadora Oster', "precioProd" => 50, "cantProd" => 10];
    $prodMasVendido[8] = ["prod" => 'Horno Black+Decker', "precioProd" => 120, "cantProd" => 6];
    $prodMasVendido[9] = ["prod" => 'Ventilador Honeywell', "precioProd" => 30, "cantProd" => 20];
    $prodMasVendido[10] = ["prod" => 'Secadora Whirlpool', "precioProd" => 180, "cantProd" => 5];
    $prodMasVendido[11] = ["prod" => 'Nevera Bosch', "precioProd" => 300, "cantProd" => 3];

    return $prodMasVendido;
}

function monto_Venta($precioP, $cantP)
{
    return $precioP * $cantP;
}
//Opcion Nº1
function insertarVenta(&$ventas, &$prodMasVendido)
{

    $mes = solicitarMes();
    $nombre = solicitar_Prod();
    $precio = solicitar_PrecioU();
    $cantidad = solicitar_Cantidad();
    $total = monto_Venta($precio, $cantidad);
    $ventas[$mes] += $total;
    $valorComparar = monto_Venta($prodMasVendido[$mes]["precioProd"], $prodMasVendido[$mes]["cantProd"]);

    // actualizar prodMasVendido
    if ($total > $valorComparar) {
        $prodMasVendido[$mes] = [
            "prod" => $nombre,
            "precioProd" => $precio,
            "cantProd" => $cantidad
        ];
        echo "Venta ingresada exitosamente y actualizada como producto mas vendido del mes.\n";
    } else {
        echo "Venta ingresada exitosamente.\n";
    }
}



function solicitar_Prod()
{
    echo "  Ingrese el producto: ";
    $nombre = trim(fgets((STDIN)));
    return $nombre;
}

function solicitar_PrecioU()
{
    echo "  Ingrese el VALOR del producto: ";
    $valor = trim(fgets((STDIN)));
    return $valor;
}

function solicitar_Cantidad()
{
    echo "  Ingrese la cantidad de producto vendido: ";
    $cant = trim(fgets((STDIN)));
    return $cant;
}

function indice_a_mes($index)
{
    $mes = "invalido";
    $meses[0] = "Enero";
    $meses[1] = "Febrero";
    $meses[2] = "Marzo";
    $meses[3] = "Abril";
    $meses[4] = "Mayo";
    $meses[5] = "Junio";
    $meses[6] = "Julio";
    $meses[7] = "Agosto";
    $meses[8] = "Septiembre";
    $meses[9] = "Octubre";
    $meses[10] = "Noviembre";
    $meses[11] = "Diciembre";
    if ($index >= 0 && $index <= 11) {
        $mes = $meses[$index];
    }
    return $mes;
}
//Opcion Nº2
function mesMayorVenta($ventas)
{
    $mesMayorIndex = obtenerIndiceMayorVenta($ventas);
    if ($mesMayorIndex !== -1) {
        $mes = indice_a_mes($mesMayorIndex);
        $monto = $ventas[$mesMayorIndex];
        echo "El mes con mayores ventas es $mes con un monto de $monto\n";
    } else {
        echo "No se encontró ningún mes con ventas registradas\n";
    }
}
function obtenerIndiceMayorVenta($ventas)
{
    $tamanio = count($ventas);
    $monto = 0;
    $mes = -1; //no se ha encontrado ningún mes con ventas aún

    for ($i = 0; $i < $tamanio; ++$i) {
        $var = $ventas[$i];
        if ($monto < $var) {
            $mes = $i;
            $monto = $var;
        }
    }

    return $mes;
}

//Opcion Nº3
function primerMesSuperaMonto($montoObjetivo, $ventas)
{
    $exito = true;
    $tamanio = count($ventas);
    $it = 0;
    $encontrado = -1;
    while ($exito && $it < $tamanio) {

        if ($ventas[$it] > $montoObjetivo) {
            $exito = false;
            $encontrado = $it; //entonces si el supera supera el monto la variable encontrado toma el valor del it
        } else {
            $it++;
        }
    }

    return $encontrado; //contiene el indice del mes que supera el monto si no -1
}

function solicitar_MontoObjetivo()
{
    echo "Ingrese el monto total de ventas objetivo: ";
    $monto = floatval(trim(fgets(STDIN)));
    return $monto;
}

//Opcion Nº4
function informacionMes($mes, $ventas, $prodMasVendido)
{

    if ($mes == -1) {
        echo (" El mes NO EXISTE \n");
    } else {
        $str = indice_a_mes($mes);
        echo "<", $str, "> \n";

        $cant = $prodMasVendido[$mes]["cantProd"];
        $precio = $prodMasVendido[$mes]["precioProd"];
        $total = monto_Venta($cant, $precio);
        echo "El producto con mayor monto de venta:", $prodMasVendido[$mes]["prod"], "\n";
        echo "Cantidad de Productos Vendidos:", $cant, "\n";
        echo "Precio Unitario: $", $precio, "\n";
        echo "Monto de venta del producto: $",  $total, "\n";
        echo "Monto acumulado de ventas del mes ",  $str, ": $", $ventas[$mes], "\n";
    }
}

//Opcion Nº5
//PRINT_R permite una visualizacion de una estructura de datos
//Propociona una salida legible y sea bastante comprensible.
//Muestra el indice y sus valores asociados a cada indice

function prodMasVendidoOrdenado($prodMasVendido)
{
    echo "PRODUCTO ORDENADO \n";
    $prodMasVendidoOrdenado = ordenarPorBurbuja($prodMasVendido);
    print_r($prodMasVendidoOrdenado);
}

function comparacion_Producto($primer_Prod,$segundo_Prod){
    //funcion para ver si es mayor una venta total que la otra
    
    $total_a=monto_Venta($primer_Prod["precioProd"],$primer_Prod["cantProd"]);
    $total_b=monto_Venta($segundo_Prod["precioProd"],$segundo_Prod["cantProd"]);;
return ($total_a < $total_b)?1:-1;
}

function ordenarPorBurbuja($arr)
{
    $n = count($arr);
    $arrOrdenado = $arr;

    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            $cant_1 = $arrOrdenado[$j]["cantProd"];
            $precio_1 = $arrOrdenado[$j]["precioProd"];
            $total_1 = monto_Venta($cant_1, $precio_1);

            $cant_2 = $arrOrdenado[$j + 1]["cantProd"];
            $precio_2 = $arrOrdenado[$j + 1]["precioProd"];
            $total_2 = monto_Venta($cant_2, $precio_2);

            if ($total_1 < $total_2) {
                // Intercambio
                $temp = $arrOrdenado[$j];
                $arrOrdenado[$j] = $arrOrdenado[$j + 1];
                $arrOrdenado[$j + 1] = $temp;
            }
        }
    }

    return $arrOrdenado;
}

//Menu
function indice_opcion(&$indice, &$ventas, &$prodMasVendido)
{
    switch ($indice) {
        case 1:
            insertarVenta($ventas, $prodMasVendido);
            break;
        case 2:
            $mesMayorIndex = obtenerIndiceMayorVenta($ventas);
            informacionMes($mesMayorIndex, $ventas, $prodMasVendido);
            break;
        case 3:
            $montoObjetivo = solicitar_MontoObjetivo();
            $indexMesSuperacion = primerMesSuperaMonto($montoObjetivo, $ventas);
            informacionMes($indexMesSuperacion, $ventas, $prodMasVendido);
            break;
        case 4:
            $mes = solicitarMes();
            informacionMes($mes, $ventas, $prodMasVendido);
            break;
        case 5:
            //prodMasVendidoOrdenado($prodMasVendido);
            
            uasort($prodMasVendido,'comparacion_Producto');
            print_r($prodMasVendido);

            break;
        case 6:
            echo "SALIENDO DEL MENU\n";
           
            break;
    }
}

function menu_opciones(&$ventas, &$prodMasVendido)
{


    do {


        echo "1) ingresar una venta\n";
        echo "2) Mes con mayor monto de ventas \n";
        echo "3) Primer mes que supera un  monto de ventas\n";
        echo "4) Informacion de un mes \n";
        echo "5) Producto mas vendido Ordenado \n";
        echo "6) FIN PROGRAMA \n";
        echo "ingrese una opcion:   ";
        $opcion = trim(fgets(STDIN)); //TRIM PARA ELIMINAR ESPACIOS 

        if ($opcion < 1 || $opcion > 6) {
            echo "OPCION INVALIDA! \n";
        } else {
            echo "\n";
            indice_opcion($opcion, $ventas, $prodMasVendido);
            echo "\n";
        }
    } while ($opcion != 6);
}

function solicitarMes()
{
    $meses = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    // Solicitar al usuario que ingrese un mes
    do {
        $input = readline("Ingrese el nombre del mes: ");
        $input = ucfirst(strtolower($input));
    } while (!in_array($input, $meses));

    // Obtener el num de la posicion de ese mes en el
    $indice = array_search($input, $meses);

    return $indice;
}

function main()
{


    $prodMasVendido = prodMasVendido();
    $ventas = carga_ventas($prodMasVendido);
    menu_opciones($ventas, $prodMasVendido);
}

main();

