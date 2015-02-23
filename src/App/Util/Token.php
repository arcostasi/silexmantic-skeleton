<?php

namespace App\Util;

/**
 * Classe utilizada para gerar o código de autenticação de mensagem 
 * no formato HMAC-SHA512 (128 bits)
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class Token {

    private $token;
    private $salt = "a2b9c66a21d27ab117c77ff2c8ae05100f6498b9";
    private $number;
    private $mktime;

    /**
     * Constructor da classe
     *
     * @param (String) $number, time() $mktime
     *
     * $number: (String) Número do destinatário
     * $mktime: (String) Data e hora da requisição no formato timestamp
     */
    public function __construct($number, $mktime) 
    {
        // Cria o código de autenticação
        $this->setToken($number, $mktime);
    }

    /**
     * Obtém o token HMAC-SHA512 (128 bits)
     *
     * @return (String) $this->token
     */
    public function getToken() 
    {
        // Retorna o código de autenticação
        return $this->token;
    }

    /**
     * Seta o token HMAC-SHA512 (128 bits)
     *
     * @param (String), time()
     */
    public function setToken($number, $mktime) 
    {
        // Seta o número do destinatário
        $this->setNumber($number);

        // Seta a data e hora da requisição (timestamp)
        $this->setMktime($mktime);

        // Salt encriptado com md5
        $salt = md5($this->getSalt());

        // Encriptação com HMAC-SHA512 (128 bits)
        // Gera o hash do número concatenado com o timestamp baseado no salt já definido
        $hash = hash_hmac('sha512', $this->getNumber() . $this->getMktime(), $salt);

        // Seta o código de autenticação
        $this->token = $hash;
    }

    /**
     * Seta o Salt utilizado na criptografia
     *
     * @param (String)
     */
    private function getSalt() 
    {
        // Retorna o salt
        return $this->salt;
    }

    /**
     * Obtém o número do destinatário
     *
     * @return (String)
     */
    public function getNumber() 
    {
        // Retorna o número do destinatário
        return $this->number;
    }

    /**
     * Seta o número do destinatário
     *
     * @param (String)
     */
    public function setNumber($number) 
    {
        // Seta o número do destinatário
        $this->number = $number;
    }

    /**
     * Obtém a data e hora da requisição
     *
     * @return time()
     */
    public function getMktime() 
    {
        // Retorna a data e hora da requisição (timestamp)
        return $this->mktime;
    }

    /**
     * Seta a data e hora da requisição
     *
     * @param time()
     */
    public function setMktime($mktime) 
    {
        // Seta a data e hora da requisição (timestamp)
        $this->mktime = $mktime;
    }

}
