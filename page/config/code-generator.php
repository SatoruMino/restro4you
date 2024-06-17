<?php

//---------Password Reset Token generator-------------------------------------------//
$length = 30;
$tk = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"), 1, $length);

//------------Dummy Password Generator----------------------------------------------//
$length = 10;
$rc = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"), 1, $length);


//----------System Generated Numbers------------------------------------------//
$length = 2;
$alpha = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM"), 1, $length);
$ln = 2;
$beta = substr(str_shuffle("1234567890"), 1, $length);

function generateShortUUID($length = 6)
{
    // Character set to use in the short UUID
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $shortUUID = '';

    // Generate a random string of the specified length
    for ($i = 0; $i < $length; $i++) {
        $shortUUID .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $shortUUID;
}


$checksum = bin2hex(random_bytes('12'));
$operation_id = bin2hex(random_bytes('4'));
$prod_id  = bin2hex(random_bytes('4'));
$orderid = bin2hex(random_bytes('4'));
$payid = bin2hex(random_bytes('4'));
$uniqueId = substr(bin2hex(random_bytes(3)), 0, 6);

$length = 10;
$mpesaCode = substr(str_shuffle("Q1W2E3R4T5Y6U7I8O9PLKJHGFDSAZXCVBNM"), 1, $length);
