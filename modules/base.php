<?php

namespace modules;
abstract class base
{
    private static $instance = null;

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            $self = get_called_class();
            self::$instance = new $self;
        }
        return self::$instance;
    }

    abstract public function notify(): void;

    protected function getHostHeader(): string
    {
        return $this->getHeader('Host');
    }

    protected function getQueryString(): array
    {
        $data = [
            'GET' => $_SERVER['REQUEST_URI'],
        ];

        if (!empty(file_get_contents("php://input")))
            $data['POST'] = file_get_contents("php://input");
        else
            $data['POST'] = null;

        return $data;
    }

    protected function getUserIpAddr(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    protected function getReferer(): ?string
    {
        return $this->getHeader('Referer');
    }

    protected function getUserAgent(): string
    {
        return $this->getHeader('User-Agent');
    }

    protected function getHeader(string $name): ?string
    {
        return (isset($_SERVER['HTTP_' . strtoupper(str_replace('-', '_', $name))])) ? $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', $name))] : null;
    }

    protected function escapeChar(string|array $char, string $text)
    {
        if (gettype($char) == 'string')
            return str_replace($char, "\\" . $char, $text);
        else
            foreach ($char as $c){
                $text = str_replace($c, "\\" . $c, $text);
            }
        return $text;
    }
}