<?php
// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';

// Helper urlbase
$urlbase = 'https://' . $_SERVER['HTTP_HOST'];

// Agrega credenciales
// Produccion
MercadoPago\SDK::setAccessToken('TEST-436706753064257-012815-fd26983b9dc64514f89886ba9caff9fd-423390757');
//MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->id = '1234';
$item->title = $_POST['title'];
$item->currency_id = 'ARS';
$item->description = 'Dispositivo móvil de Tienda e-commerce';
$item->picture_url = $urlbase . '/' . str_replace('./', '', $_POST['img']);
$item->quantity = 1;
$item->unit_price = floatval($_POST['price']);

$preference->items = array($item);

// Crea payer
$payer = new MercadoPago\Payer();
$payer->name = 'Lalo';
$payer->surname = 'Landa';
$payer->identification = array(
    'type' => 'DNI',
    'number' => '22.333.444'
);
$payer->email = 'test_user_63274575@testuser.com';
$payer->phone = array(
    'area_code' => '011',
    'number' => '22223333'
);
$payer->address = array(
    'street_name' => 'Falsa',
    'street_number' => 123,
    'zip_code' => '1111'
);

$preference->payer = $payer;

// Quitar Amex y ATM como medios de pago
$preference->payment_methods = array(
    'excluded_payment_methods' => array(
        array('id' => 'amex')
    ),
    'excluded_payment_types' => array(
        array('id' => 'atm')
    ),
    'installments' => 6
);

// Urls de retorno
$preference->back_urls = array(
    'success' => "$urlbase/pago-exitoso.php",
    'failure' => "$urlbase/pago-rechazado.php",
    'pending' => "$urlbase/pago-pendiente.php"
);

// Configuraciones post retorno
$preference->external_reference = 'ABCD1234';
$preference->auto_return = 'approved';
$preference->notification_url = "$urlbase/notificaciones.php";

$preference->save();
?>