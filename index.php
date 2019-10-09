<?php

require 'Encrypt.php';

$enc = new Encrypt();

/**
 * You must run $enc->generateKeys() one time in order to generate
 * the public / private keys in the "keys" folder.
 */

$enc->encrypt('Test123 - 321Test');

echo '<br><br><br><br>';

echo $enc->decrypt('g0qtsQ3EKxVkuKdOeAKWZjY=');
