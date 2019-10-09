<?php

require 'Encrypt.php';

$enc = new Encrypt();

/**
 * You must run $enc->generateKeys() one time in order to generate
 * the public / private keys in the "keys" folder.
 */

var_dump($enc->encryptLongString('Test123 - 321Test'));

echo '<br><br><br><br>';

//echo $enc->decrypt('g0qtsQ3EKxVkuKdOeAKWZjY=');
