<?php

namespace modules;

use config\registry;

class telegram extends base
{
    private string $TOKEN;
    private string $CHAT_ID;
    protected function __construct()
    {
        $this->TOKEN = registry::get('TG_TOKEN');
        $this->CHAT_ID = registry::get('TG_CHAT_ID');
        parent::__construct();
    }

    public function notify(): void
    {
        if($this->getHostHeader() !== registry::get('HOST'))
            die();
        $q = $this->getQueryString();

        $message = "〽️*Host*: `" . $this->getHostHeader() . "`\n\n〽️*IP\-Address*: ||" . $this->escapeChar('.',$this->getUserIpAddr()) . "||" . ((!is_null($this->getReferer())) ? "\n\n〽️*Referer*: `" . mdEscape($this->getReferer()) . "`" : '') . "\n\n〽️*User\-Agent*: `" . mdEscape($this->getUserAgent()) . "`\n
〽️*Query String*:
```QueryString
GET: " . $q['GET'] . "
" . ((!is_null($q['POST'])) ? "POST: ". mdEscape($q['POST']) : "") . "
```" . "\n 〽️*headers* \n```\n" . mdEscape(getHeadersText()) . "```";
        if (strlen($message) > 4000) {
            // Message is too long; send as a file
            $tempFile = tempnam(sys_get_temp_dir(), 'tg_message_');
            file_put_contents($tempFile, $message);

            $this->sendFile($tempFile, 'message.txt');
            unlink($tempFile); // Clean up temp file
        }else{
            $sendMessageArray = [
                'chat_id' => $this->CHAT_ID,
                'text' => $message,
                'parse_mode' => 'markdownv2'
            ];
            if(registry::get('THREAD_ID') !== ''){
                $sendMessageArray['message_thread_id'] = registry::get('THREAD_ID');
            }
            $this->sendMessage($sendMessageArray);
        }
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

    private function sendFile($filePath, $fileName): void
    {
        $url = "https://api.telegram.org/bot" . $this->TOKEN . "/sendDocument";
        $cfile = curl_file_create($filePath, 'text/plain', $fileName);

        $params = [
            'chat_id' => $this->CHAT_ID,
            'document' => $cfile
        ];

        if (registry::get('THREAD_ID') !== '') {
            $params['message_thread_id'] = registry::get('THREAD_ID');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
