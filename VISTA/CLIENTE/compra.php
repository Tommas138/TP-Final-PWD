<?php

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
require '../../vendor/autoload.php';

// Set access token (server-side)
MercadoPagoConfig::setAccessToken("APP_USR-2331238961937089-111917-a69aa1e19611c49ec6c811a883136dac-3001373608");

// Carga producto real según id pasado por GET 
require_once __DIR__ . '/../../CONTROL/AbmProducto.php';
require_once __DIR__ . '/../../MODELO/Producto.php';

$idProducto = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$idProducto) {
    // Si no llega id, mostrar mensaje y detener 
    echo "<p>Producto no especificado. Pasa ?id=ID_DEL_PRODUCTO en la URL.</p>";
    exit;
}

$abmProd = new AbmProducto();
$lista = $abmProd->buscar(['idproducto' => $idProducto]);
if (!isset($lista[0])) {
    echo "<p>Producto no encontrado (id={$idProducto}).</p>";
    exit;
}

$producto = $lista[0];

// Preparamos la preferencia con los datos del producto
$client = new PreferenceClient();
$preference = $client->create([
    'items' => [
        [
            'id' => $producto->getIdProducto(),
            'title' => $producto->getProNombre(),
            'quantity' => 1,
            'unit_price' => (float) $producto->getProPrecio(),
        ]
    ],
    'statement_descriptor' => 'Dunder Mifflin Store',
    'external_reference' => 'CDP' . $producto->getIdProducto(),
]);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Pago Checkout Pro</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- SDK MercadoPago.js -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <section class="py-2">
        <div class="container px-4 px-lg-5 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="images/balon.jpg" alt="Balón" /></div>
                <div class="col-md-6">
                    <div class="small mb-1">SKU: DEP-0001</div>
                    <h1 class="display-5 fw-bolder">Balón de Futbol</h1> //aca va el nombre del producto
                    <div class="fs-5 mb-5">
                        <span>$550.00</span>
                    </div>
                    <p class="lead">Elaborado con altos estándares de calidad, 4 capas que permite mayor duración.</p>
                    <div class="d-flex">
                        <!-- Contenedor del botón -->
                        <div id="wallet_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Inicializa el objeto MercadoPago con el PUBLIC_KEY
        const mp = new MercadoPago('APP_USR-d6361bb6-836a-48d3-8faa-21744020faf9', {
            locale: 'es-MX'
        });

        // Crea un componente de billetera de MercadoPago en el contenedor con id "wallet_container"
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: '<?php echo $preference->id; ?>',
                redirectMode: 'self'
            },
            customization: {
                texts: {
                    action: "pay",
                    valueProp: 'security_safety',
                },
            },
        });
    </script>
</body>

</html>