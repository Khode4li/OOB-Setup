<?php

namespace modules;

use config\registry;

class discord extends base
{
    private string $WEBHOOK_URL;

    protected function __construct()
    {
        $this->WEBHOOK_URL = registry::get('DC_WEBHOOK_URL');
        parent::__construct();
    }

    public function notify(): void
    {
        if($this->getHostHeader() !== registry::get('HOST'))
            die();
        $q = $this->getQueryString();
        $params = [
            "embeds" => [
                [
                    "title" => "New Request " . date("Y-m-d H:i"),
                    "color" => "16062488",
                    "fields" => [
                        [
                            "name" => "Host",
                            "value" => $this->getHostHeader()
                        ],
                        [
                            "name" => "User IP Address",
                            "value" => $this->getUserIpAddr()
                        ],
                        [
                            "name" => "User Agent",
                            "value" => $this->getUserAgent()
                        ]
                    ]
                ]
            ]
        ];

        if (!is_null($this->getReferer()))
            $params["embeds"][0]["fields"][] = ["name" => "Referer", "value" => $this->getReferer()];

        if (!is_null($q["POST"])) {
            $params["embeds"][0]["fields"][] = ["name" => "Query String", "value" => "GET: ```" . $q["GET"] . "```\nPOST: ```" . $q["POST"] . "```"];
        }else{
            $params["embeds"][0]["fields"][] = ["name" => "Query String", "value" => "GET: ```" . $q["GET"] . "```"];
        }
        $this->sendMessage($params);
    }

    public function sendMessage(array $params)
    {
        $params = json_encode($params);

        $url = $this->WEBHOOK_URL;

        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}