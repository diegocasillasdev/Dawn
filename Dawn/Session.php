<?php

namespace Dawn;

use \Firebase\JWT\JWT;
use Dawn\Routing\Response;

class Session
{
    private $app;
    private $config = 'cookie';
    private $token;
    private $expires;
    private $tokenKey = 'access_token';

    public function __construct($app, $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function start()
    {
        $this->loadToken();
    }

    public function destroy()
    {
        $this->token = null;
        $this->app->deleteCookie($this->tokenKey);
        $this->app->deleteSession($this->tokenKey);
    }

    public function setUser($userId)
    {
        switch ($this->config['mode']) {
            case 'cookie':
                header("Set-Cookie: $this->tokenKey=$userId; HttpOnly");
                break;
            case 'session':
                $_SESSION[$this->tokenKey] = $userId;
                break;
            case 'local storage':
                (new Response([$this->tokenKey => $userId, 'expires' => $this->getExpires()]))->json()->send();
                die();
                break;
        }
    }

    public function getExpires()
    {
        return $this->expires;
    }

    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    public function loadToken()
    {
        switch ($this->config['mode']) {
            case 'cookie':
                $this->token = $this->app->cookie($this->tokenKey);
                break;
            case 'session':
                $this->token = $this->app->session($this->tokenKey);
                break;
            case 'local storage':
                if (array_key_exists('Authorization', getallheaders())) {
                    $this->token = substr(getallheaders()['Authorization'], strlen('Bearer '));
                }
                break;
        }
    }
    public function getConfig()
    {
        return $this->config;
    }
    public function getToken()
    {
        return $this->token;
    }
}