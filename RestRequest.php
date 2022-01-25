<?php

class RestRequest {
    protected $apiKey;
    protected $baseUrl;

    public function __construct(string $baseUrl){
        $this->apiKey = $_ENV['API_KEY'];
        $this->baseUrl = $_ENV['API_BASE_URL'] . '/' . $baseUrl;
    }

    public function send(string $endpoint){
        $url = sprintf(
            '%s%s%s',
            $this->baseUrl,
            $endpoint,
            '&key=' . $this->apiKey
        );

 // die($url);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "content-type: application/json",
        ]);

        $response = curl_exec($ch);
        //var_dump($response);
        if($response == false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        // var_dump($response);
        $response = json_decode($response, true);

        return $response;
    }
}
