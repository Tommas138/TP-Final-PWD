<?php

include_once '../CONTROL/Session.php';
require_once "../UTILS/MailSender.php";

$session = new Session();
if(!$session->getIDSesionActual()){
    header("Location: ../index.php");

}else{
    require_once __DIR__ . '/../UTILS/funciones.php';
    include_once 'ACCION/ESTRUCTURA/reusables/header.php';
}
$datos = data_submitted();
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
require __DIR__ . '/../vendor/autoload.php';

// Set access token (server-side)
MercadoPagoConfig::setAccessToken("APP_USR-2331238961937089-111917-a69aa1e19611c49ec6c811a883136dac-3001373608");

// Cargar controladores locales (funciones.php ya incluye muchos, esto asegura disponibilidad)
require_once __DIR__ . '/../CONTROL/AbmProducto.php';
require_once __DIR__ . '/../CONTROL/AbmCompraItem.php';
require_once __DIR__ . '/../CONTROL/ControlVerificarCarritoCliente.php';
require_once __DIR__ . '/../CONTROL/Session.php';

// Preparar variables comunes
$imgWebBase = '../uploads/img/';
$defaultImg = $imgWebBase . 'default.jpg';


// aceptar idproducto (GET/POST) o idcompra (POST)
$idProducto = null;
$idCompra = null;
if (!empty($_POST['idcompra'])) {
    $idCompra = intval($_POST['idcompra']);
} elseif (!empty($_GET['id'])) {
    $idProducto = intval($_GET['id']);
} elseif (!empty($_POST['id'])) {
    $idProducto = intval($_POST['id']);
} elseif (!empty($_POST['idproducto'])) {
    $idProducto = intval($_POST['idproducto']);
}

$itemsForPreference = [];
$displayItems = [];
$session = new Session();

if ($idCompra) {
    // construir preferencia desde el carrito
    $abmItems = new AbmCompraItem();
    $compraItems = $abmItems->buscar(['idcompra' => $idCompra]);
    if (empty($compraItems)) {
        header('Location: carrito.php?message=' . urlencode('El carrito está vacío.'));
        exit;
    }
    foreach ($compraItems as $ci) {
        $producto = $ci->getIdProducto();
        if (!$producto) continue;
        $qty = max(1, (int)$ci->getCiCantidad());
        $price = (float)$producto->getProPrecio();
        $itemsForPreference[] = [
            'id' => (string)$producto->getIdProducto(),
            'title' => $producto->getProNombre(),
            'quantity' => $qty,
            'unit_price' => $price,
        ];
        $displayItems[] = ['producto' => $producto, 'quantity' => $qty];
    }
    $externalRef = 'CART_' . $idCompra . '_' . time();
} elseif ($idProducto) {
    // compra directa de 1 producto
    $abmProd = new AbmProducto();
    $lista = $abmProd->buscar(['idproducto' => $idProducto]);
    if (!isset($lista[0])) {
        header('Location: listadoProductos.php?message=' . urlencode("Producto no encontrado (id={$idProducto})."));
        exit;
    }
    $producto = $lista[0];
    $itemsForPreference[] = [
        'id' => (string)$producto->getIdProducto(),
        'title' => $producto->getProNombre(),
        'quantity' => 1,
        'unit_price' => (float)$producto->getProPrecio(),
    ];
    $displayItems[] = ['producto' => $producto, 'quantity' => 1];
    $externalRef = 'CDP' . $producto->getIdProducto();
} else {
    header('Location: carrito.php?message=' . urlencode('Seleccione productos en el carrito o pase ?id=ID en la URL.'));
    exit;
}

// crear preferencia
$client = new PreferenceClient();
try {
    $preference = $client->create([
        'items' => $itemsForPreference,
        'statement_descriptor' => 'MiTienda',
        'external_reference' => $externalRef,
    ]);
} catch (Throwable $e) {
    header('Location: listadoProductos.php?message=' . urlencode('Error creando preferencia de pago.'));
    exit;
}

// totales para mostrar
$totalAmount = 0.0;
foreach ($displayItems as $it) {
    $p = $it['producto'];
    $q = (int)$it['quantity'];
    $totalAmount += ((float)$p->getProPrecio()) * $q;
}
$exito = false;
$abmCompraEstado = new AbmCompraEstado();
$arrayCarrito = ['idcompra' => $datos['idcompra'], 'idcompraestadotipo' => 1];
$exito = $abmCompraEstado->buscar($arrayCarrito);
$usuarioAbm = new AbmUsuario();
$usuario = $usuarioAbm->buscar($datos)[0];

$abmCompraEstado->modificarEstado($datos);

if ($exito) {

    $message = 'Se envio el carrito correctamente';
    $compraItem = new CompraItem();   
    $compraItem->setIdCompra($datos['idcompra']); 
    $items = $compraItem->listar("idcompra = ". $datos['idcompra']);
    
    $i = 0;
    $gastoTotal = 0;
    $productos = array();
    foreach ($items as $item) {
        $objProd = $item->getIdProducto();
        $stock = $item->getCiCantidad();
        $prod = New Producto();
        $prod->setIdProducto( $objProd->getIdProducto());
        $prod->cargar();
        $nuevoStock = $prod->getProcantstock() - $stock;
        $prod->setProcantstock($nuevoStock);
        $prod->modificar();
        $gastoTotal += $prod->getProPrecio();
        array_push($productos,$prod);
    }

    // 2. Recopilas los datos para el mail
    $datosParaMail = [
        'id_pedido' => $datos["idcompra"], // El ID que acabas de generar
        'total' => $gastoTotal,
        'items' => $productos
    ];
}
    $notificador = new MailSender();
    $resultadoMail = $notificador->enviarConfirmacionCompra($usuario->getUsMail(), $usuario->getUsNombre(), $datosParaMail);
                
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Finalizar compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
<div class="container py-4">
    <h3>Resumen de compra</h3>

    <div class="card mb-3">
        <div class="card-body">
            <?php foreach ($displayItems as $it):
                $prod = $it['producto'];
                $qty = (int)$it['quantity'];
                $subtotal = (float)$prod->getProPrecio() * $qty;

                // intentar detectar imagen (md5 o producto{id})
                $imgFolder = realpath(__DIR__ . '/../uploads/img/');
                $imgFile = null;
                $idHashImg = strtolower(md5($prod->getIdProducto()));
                $idPlain = 'producto' . intval($prod->getIdProducto());
                $exts = ['jpg','jpeg','png','webp','gif'];
                if ($imgFolder) {
                    foreach ($exts as $ext) {
                        if (file_exists($imgFolder . DIRECTORY_SEPARATOR . $idHashImg . '.' . $ext)) { $imgFile = $idHashImg . '.' . $ext; break; }
                        if (file_exists($imgFolder . DIRECTORY_SEPARATOR . $idPlain . '.' . $ext)) { $imgFile = $idPlain . '.' . $ext; break; }
                    }
                }
                $imgSrc = $imgFile ? $imgWebBase . $imgFile : $defaultImg;
            ?>
            <div class="d-flex align-items-center mb-3">
                <img src="<?php echo htmlspecialchars($imgSrc, ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($prod->getProNombre(), ENT_QUOTES); ?>" style="width:80px;height:80px;object-fit:cover;margin-right:12px;">
                <div class="flex-grow-1">
                    <strong><?php echo htmlspecialchars($prod->getProNombre(), ENT_QUOTES); ?></strong>
                    <div class="small text-muted">Cantidad: <?php echo $qty; ?></div>
                </div>
                <div class="text-end">
                    <div>$<?php echo number_format((float)$prod->getProPrecio(),2); ?></div>
                    <div class="small text-muted">Subtotal: $<?php echo number_format($subtotal,2); ?></div>
                </div>
            </div>
            <?php endforeach; ?>

            <hr>
            <div class="d-flex justify-content-between">
                <div>Total</div>
                <div><strong>$<?php echo number_format($totalAmount,2); ?></strong></div>
            </div>

            <div class="mt-3" id="wallet_container"></div>
        </div>
    </div>
</div>
<?php $paymentId = $_GET['payment_id'] ?? null;
    
    if ($paymentId) {
        // 3. Consultar el pago usando el SDK
        $payment = \MercadoPago\Payment::find_by_id($paymentId);

        // 4. Verificar el estado
        if ($payment && ($payment->status === 'approved' || $payment->status === 'settled')) {
            // **Aquí es donde sabes que la compra es exitosa.**
            // Puedes devolver TRUE o ejecutar la lógica de tu negocio.
            echo "¡Compra Aprobada! ID: " . $payment->id;
        } else {
            // El estado es 'pending', 'in_process', 'rejected', etc.
            echo "El pago está en estado: " . $payment->status;
        }
    } ?>
    <script>
        // Inicializa el objeto MercadoPago con el PUBLIC_KEY
        const mp = new MercadoPago('APP_USR-d6361bb6-836a-48d3-8faa-21744020faf9');

        // Crea un componente de billetera de MercadoPago en el contenedor con id "wallet_container"
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: '<?php echo $preference->id; ?>',
                redirectMode: 'self'  //Lo abre en una pestaña flotante, no funciona si hay una cuenta propia abierta en el navegador
            },
            customization: {
                texts: {
                    action: "pay",
                    valueProp: 'security_details',
                },
            },
        });
    </script>
</body>
</html>