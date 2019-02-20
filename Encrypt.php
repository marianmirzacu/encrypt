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

        if(file_exists(self::KEYS_FOLDER . '/' . $publicFile) || file_exists(self::KEYS_FOLDER . '/' . $privateFile)){
            return 'ERROR: Public or Private file already exists in "' . self::KEYS_FOLDER . '" folder.';
        }

        file_put_contents(self::KEYS_FOLDER . '/' . $publicFile, $publicKey);
        file_put_contents(self::KEYS_FOLDER . '/' . $privateFile, $privateKey);

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
}
