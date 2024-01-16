<?php
namespace App\Http\Services;

 // Inserire commenti
class SecurityPassword
{
    public function encryptData($data, $key) {
        $cipher = "aes-256-cbc";
        $fixedIV = "0123456789012345"; // IV fisso, modifica secondo le tue esigenze
        $ciphertext_raw = openssl_encrypt($data, $cipher, $key, $options=OPENSSL_RAW_DATA, $fixedIV);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode($fixedIV . $hmac . $ciphertext_raw);
        return $ciphertext;
    }
    
    public function decryptData($data, $key) {
        $cipher = "aes-256-cbc";
        $fixedIV = "0123456789012345"; // IV fisso, deve corrispondere a quello utilizzato per la crittografia
        $c = base64_decode($data);
        $ivlen = strlen($fixedIV);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $fixedIV);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
        return false;
    }
}

// $_ENV['MAIL_HOST'];