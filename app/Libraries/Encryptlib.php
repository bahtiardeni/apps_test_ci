<?php
namespace App\Libraries;
use Config\Encryption;

class Encryptlib extends Encryption
{
    protected $encryptionKey;

    public function __construct()
    {
        $this->set_encryption();

        $this->encryptionKey    = "64c70b0b8d45b80b9eba60b8b3c8a34d0193223d20fea46f8644b848bf7ce67f";
    }

    protected function set_encryption()
    {
        $config         = new Encryption();
        $config->driver = 'OpenSSL';

        $config->key = hex2bin('64c70b0b8d45b80b9eba60b8b3c8a34d0193223d20fea46f8644b848bf7ce67f');
        $config->cipher = 'AES-128-CBC';

        $config->rawData        = false;
        $config->encryptKeyInfo = 'encryption';
        $config->authKeyInfo    = 'authentication';

        $this->encrypter    = service('encrypter', $config);
    }
    public function encode($text)
    {
        if (!empty($text)){
            return base64_encode(base64_encode($text));
        }

        return false;
    }
    public function decode($text)
    {
        if (!empty($text)){
            return base64_decode(base64_decode($text));
        }

        return false;
    }
}
