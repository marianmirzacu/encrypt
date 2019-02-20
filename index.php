<?php

include 'Encrypt.php';

$enc = new Encrypt();

/**
 * You must run $enc->generateKeys() one time in order to generate
 * the public / private keys in the "keys" folder.
 */

echo $enc->encrypt('Test123 - 321Test');

echo '<br><br><br><br>';

echo $enc->decrypt('O36L3t7feAph3BnfnIl6ml4qZ4ikQqZIgA4Ec+h8+kmU+QsxroNcLxDyCWfn6NYfPsW0+Kdi4eFLOrYP1noxVwvhISgWf1+BNplRysP6tGJ5SUnNWgT5crm6tfeoiSYfgiqVvN+lq/spdV1zBxWwjg7S5fc5+bwdcgZ9OTnucEu0p3E1HSfPUZlfS9mSIZ3dsb9+M2Wh2Y98O0fy+DWKQcKRs9gK8uBGKSj+wvQO+48mwKcW3UBqWViNXeMonaLnneb8aMxdhDl2jVeT0JICzqjDyDldk7zlArHkLvvV3o0YKTOsSij9jjKU4LtjO4mHW7yKP4XS2h1wEZ1aeNBsEcCYmRlrDWOkEhiNY7QCKni8u4GIU1bH/dR6KQqVCvbLHp/OW4tbV9iTcULVIWcTHq0fJvo5nQz2lckuVa+iDYAG/GuYXvuaXuvPEmP/3s4q2Phn8NGgu3o0Ruk2gqj8GmldlGvMSvaf/0B7kqMxV5QYBBcT1XdVmkfd9PYKEA0laY3n6fr2PnCe9TQfhGnpzgPvXI9czQVGXjpvvwZu/7nBrIelk18i9//bKFGzG2b8tb8gu7PbZbOj/3LgDNZn+/RMIH1BlI650/jeylyKqqJwsStZej6kaCUg6DBmIb6l7b8qW4pRQDto/erdV77p8IA6ZnspnZo+fJ4lCE6j2pY=');
