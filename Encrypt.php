<?php

class Encrypt
{
    const KEYS_FOLDER = 'keys';
    private $publicKey = self::KEYS_FOLDER . '/public.key';
    private $privateKey = self::KEYS_FOLDER . '/private.key';

    public function __construct(){}

    public function __destruct()
    {
        openssl_free_key($this->getPublicKey());
        openssl_free_key($this->getPrivateKey());
    }

    private function getPublicKey()
    {
        $fp = fopen($this->publicKey, "r");
        $cert = fread($fp, 8192);
        fclose($fp);

        return openssl_get_publickey($cert);
    }

    private function getPrivateKey()
    {
        $fp = fopen($this->privateKey, "r");
        $cert = fread($fp, 8192);
        fclose($fp);

        return openssl_get_privatekey($cert);
    }

    public function generateKeys()
    {
        $resource = openssl_pkey_new([
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ]);

        openssl_pkey_export($resource, $privateFile);

        $publicFile = openssl_pkey_get_details($resource)["key"];

        if( ! file_exists(self::KEYS_FOLDER)){
            mkdir(self::KEYS_FOLDER);
        }

        if(file_exists($this->publicKey) || file_exists($this->privateKey)){
            return 'ERROR: Public or Private file already exists in "' . self::KEYS_FOLDER . '" folder.';
        }

        file_put_contents($this->publicKey, $publicFile);
        file_put_contents($this->privateKey, $privateFile);

        return 'Both keys have been generated and saved in "' . self::KEYS_FOLDER . '" folder.';
    }

    public function encrypt($string)
    {
        openssl_public_encrypt($string, $result, $this->getPublicKey());

        return base64_encode($result);
    }

    public function decrypt($string)
    {
        openssl_private_decrypt(base64_decode($string), $result, $this->getPrivateKey());

        return $result;
    }

    public function encryptLongText($text)
    {
        $env_keys = [];
        $iv = openssl_random_pseudo_bytes(32);

        openssl_seal($text, $sealed, $env_keys, [$this->getPublicKey()], 'AES256', $iv);

        return [
            'sealed' => base64_encode($sealed),
            'env_key' => base64_encode($env_keys[0]),
            'id' => base64_encode($iv),
        ];
    }

    public function decryptLongText($text, $env_key, $iv)
    {
        if (openssl_open(base64_decode($text), $open, base64_decode($env_key), $this->getPrivateKey(), 'AES256', base64_decode($iv))) {
            return $open;
        }

        return NULL;
    }
}
