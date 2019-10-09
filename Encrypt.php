<?php

class Encrypt
{
    const KEYS_FOLDER = 'keys';

    private $resource;

    public function __construct()
    {
        $this->resource = openssl_pkey_new([
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);
    }

    public function generateKeys($publicFile = 'public.key', $privateFile = 'private.key')
    {
        openssl_pkey_export($this->resource, $privateKey);

        $publicKey = openssl_pkey_get_details($this->resource)["key"];

        if( ! file_exists(self::KEYS_FOLDER)){
            mkdir(self::KEYS_FOLDER);
        }

        $publicFile = self::KEYS_FOLDER . '/' . $publicFile;
        $privateFile = self::KEYS_FOLDER . '/' . $privateFile;

        if(file_exists($publicFile) || file_exists($privateFile)){
            return 'ERROR: Public or Private file already exists in "' . self::KEYS_FOLDER . '" folder.';
        }

        file_put_contents($publicFile, $publicKey);
        file_put_contents($privateFile, $privateKey);

        return 'Both keys have been generated and saved in "' . self::KEYS_FOLDER . '" folder.';
    }

    public function encrypt($text, $publicFile = 'public.key')
    {
        openssl_public_encrypt($text, $result, file_get_contents(self::KEYS_FOLDER . '/' . $publicFile));

        return base64_encode($result);
    }

    public function decrypt($text, $privateFile = 'private.key')
    {
        openssl_private_decrypt(base64_decode($text), $result, file_get_contents(self::KEYS_FOLDER . '/' . $privateFile));

        return $result;
    }

    public function encryptLongString($text, $publicFile = 'public.key')
    {
        $env_keys = [];

        $fp = fopen("keys/" . $publicFile, "r");
        $cert = fread($fp, 8192);
        fclose($fp);
        $publicKey = openssl_get_publickey($cert);
        $iv = openssl_random_pseudo_bytes(32);

        openssl_seal($text, $sealed, $env_keys, [$publicKey], 'AES256', $iv);

        openssl_free_key($publicKey);

        return [
            'sealed' => base64_encode($sealed),
            'env_key' => base64_encode($env_keys[0]),
            'id' => base64_encode($iv),
        ];
    }

    public function decryptLongString($text, $env_key, $privateFile = 'private.key')
    {
        $fp = fopen("keys/" . $privateFile, "r");
        $cert = fread($fp, 8192);
        fclose($fp);
        $privateKey = openssl_get_privatekey($certc);

        if (openssl_open(base64_decode($text), $open, base64_decode($env_key), $privateKey)) {
            openssl_free_key($privateKey);

            return $open;
        }

        openssl_free_key($privateKey);

        return '-';
    }
}
