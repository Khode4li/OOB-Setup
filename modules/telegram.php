<?php

namespace modules;

use config\registry;

class telegram extends base
{
    private string $TOKEN;
    private string $CHAT_ID;
    private function __construct()
    {
        $this->TOKEN = registry::get('TG_TOKEN');
        $this->CHAT_ID = registry::get('TG_CHAT_ID');
        parent::__construct();
    }

    public function notify(): void
    {
        $q = $this->getQueryString();

        $message = "〽️*Host*: `" . $this->getHostHeader() . "`\n\n〽️*IP\-Address*: ||" . $this->escapeChar('.',$this->getUserIpAddr()) . "||" . ((!is_null($this->getReferer())) ? "\n\n〽️*Referer*: `" . $this->getReferer() . "`" : '') . "\n\n〽️*User\-Agent*: `" . $this->escapeChar(['.','-'],$this->getUserAgent()) . "`\n
〽️*Query String*:
```QueryString
GET: " . $q['GET'] . "
" . ((!is_null($q['POST'])) ? "POST: ".$q['POST'] : "") . "
```";

        $this->sendMessage([
            'chat_id' => $this->CHAT_ID,
            'text' => $message,
            'parse_mode' => 'markdownv2'
        ]);
    }
    private function sendMessage($params)
    {
        $url = "https://api.telegram.org/bot" . $this->TOKEN . "/sendMessage";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
