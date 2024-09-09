<?php
function mdEscape($string) {
    $specialChars = [
        '_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'
    ];
    foreach ($specialChars as $char) {
        $string = str_replace($char, '\\' . $char, $string);
    }
    return $string;
}

function gah() { //short for getAllHeaders
    if (function_exists('getallheaders')) {
        return getallheaders();
    }

    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headerName = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
            $headers[$headerName] = $value;
        }
    }
    return $headers;
}

function getHeadersText(){
    $headers = gah();
    $text = '';
    foreach ($headers as $name => $value){
        $text .= $name . ' : ' . $value . "\n";
    }
    return $text;
}

function blockBots(){
    $UserAgents = [
        'Googlebot',
        'TelegramBot'
    ];
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $UA = $_SERVER['HTTP_USER_AGENT'];
        foreach ($UserAgents as $userAgent) {
            // Check if the bot's name exists in the referrer header
            if (stripos($UA, $userAgent) !== false) {
                // Block the bot by returning a 403 Forbidden status
                header('HTTP/1.0 403 Forbidden');
                exit("Access denied for bots");
            }
        }
    }
}