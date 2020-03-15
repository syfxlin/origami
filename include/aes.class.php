<?php
class Aes
{
  protected $method;
  protected $secret_key;
  protected $iv;
  protected $options;
  public function __construct(
    $key,
    $method = 'AES-128-ECB',
    $iv = '',
    $options = 0
  ) {
    $this->secret_key = isset($key) ? $key : 'morefun';
    $this->method = $method;
    $this->iv = $iv;
    $this->options = $options;
  }
  public function encrypt($data)
  {
    return openssl_encrypt(
      $data,
      $this->method,
      $this->secret_key,
      $this->options,
      $this->iv
    );
  }
  public function decrypt($data)
  {
    return openssl_decrypt(
      $data,
      $this->method,
      $this->secret_key,
      $this->options,
      $this->iv
    );
  }
}
