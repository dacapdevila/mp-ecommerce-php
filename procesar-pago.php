<?php

require __DIR__ .  '/vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-090914-5c508e1b02a34fcce879a999574cf5c9-469485398');

if ( $_POST['payment_status'] == 'approved') {
    $payment = MercadoPago\Payment::find_by_id($_POST['payment_id']);
    //var_dump($payment);

    $_POST['datos_compra'] = $payment;
}

//var_dump($_POST);

header('location: ' . $_POST['back_url']);
