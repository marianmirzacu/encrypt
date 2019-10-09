<?php

require 'Encrypt.php';

$enc = new Encrypt();

/**
 * You must run $enc->generateKeys() one time in order to generate
 * the public / private keys in the "keys" folder.
 */

$encryptedString = $enc->encrypt('Test123 - 321Test');

echo $encryptedString . PHP_EOL;

echo $enc->decrypt($encryptedString) . PHP_EOL;
