<?php

namespace ThePB\Library {

    final class API
    {
        /**
         * Base end point for all API requests
         * @var string
         */
        private $baseUrl = 'https://api.thepb.in/v1';

        /**
         * Key used for identifying with the API
         * @var string
         */
        private $key;

        /**
         * cURL handle
         * @var resource
         */
        private $ch;

        /**
         * Results from cURL requests
         * @var mixed
         */
        private $results;

        /**
         * Define the key used for identifying with the API
         * @param string $key Key used for identifying with the API
         */
        final public function setkey($key)
        {
            if (!Key::validate($key)) {
                throw new Exception("Invalid API key exception");
            }
            $this->key = $key;
        }

        /**
         * Send an HTTP GET request to the API end point
         * @param string $url API end point to send an HTTP GET request
         * @return object
         */
        final public function get($url)
        {
            $this->ch = curl_init();
            $this->setGlobalOptions();

            curl_setopt($this->ch, CURLOPT_URL, $this->baseUrl . $url);

            $this->results = curl_exec($this->ch);
            $this->results = json_decode($this->results);

            $this->validate();
            curl_close($this->ch);

            return $this->results;
        }

        /**
         * Send an HTTP POST request to the API end point
         * @param string $url API end point to send an HTTP POST request
         * @param array $params Array to be encoded and sent as the POST data
         * @return objct
         */
        final public function post($url, $params)
        {
            $this->ch = curl_init();
            $this->setGlobalOptions();

            $postFields = http_build_query($params);

            curl_setopt($this->ch, CURLOPT_URL, $this->baseUrl . $url);
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postFields);

            $this->results = curl_exec($this->ch);
            $this->results = json_decode($this->results);

            $this->validate();
            curl_close($this->ch);

            return $this->results;
        }

        /**
         * Set cURL options to be used globally
         */
        final private function setGlobalOptions()
        {
            $headers = array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json');
            if ($this->key) {
                $headers[] = 'X-ThePB-Key: ' . $this->key;
            }

            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt($this->ch, CURLOPT_TIMEOUT, 20);
        }

        /**
         * Perform a series ofchecks to ensure validity of this cURL request
         * @throws Exception If any checks are not passed
         */
        final private function validate()
        {
            if (curl_errno($this->ch)) {
                throw new Exception(curl_error($this->ch));
            }

            $httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
            switch ($httpCode) {
                case 200:
                case 201:
                    // Successful API HTTP response codes
                    break;
                case 400:
                case 401:
                case 403:
                case 404:
                case 429:
                case 500:
                case 503:
                    // Failed
                    $statusCode   = $this->results->statusCode;
                    $error        = $this->results->error;
                    $message      = $this->results->message;
                    $effectiveUrl = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
                    throw new \Exception("[ $effectiveUrl ] ($statusCode) $error - $message");
                    break;
                default:
                    throw new \Exception("Uh-oh... An unexpected error has occurred (HTTP $httpCode).");
                    break;
            }
        }

    }
}
