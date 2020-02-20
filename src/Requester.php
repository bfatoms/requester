<?php

namespace BfAtoms\Requester;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Requester
{
    protected $data = [];
    protected $response = [];
    protected $silent = true;

    public function __construct($silent = true)
    {
        $this->silent = $silent;
    }

    public function __call($method, $arguments)
    {
        if (in_array($method, ['put', 'post', 'get', 'delete'])) {
            return $this->json(strtoupper($method), $arguments[0], $arguments[1] ?? [], $arguments[2] ?? [], false);
        }
        return response("method doesn't exist");
    }

    public function setDefaultHeaders($headers, $json)
    {
        if ($json === true) {
            $headers['Content-Type'] = 'application/json';
            $headers['Accept'] = 'application/json';
        }
        $this->data['headers'] = $headers;
    }

    public function setDataByHeaders($type, $options, $json)
    {
        if ($json === true) {
            $this->data['json'] = $options;
        } else {
            if (strtoupper($type) === 'GET') {
                $this->data['query'] = $options;
            } else {
                $this->data['form_params'] = $options;
            }
        }
    }

    public function json($type, $url, $options = [], $headers = [], $json = true)
    {
        $this->data = [];
        $client = new Client();
        $this->setDefaultHeaders($headers, $json);
        $this->setDataByHeaders($type, $options, $json);
        try {
            $this->response = $client->request($type, $url, $this->data);
            return $json === true ? response()->json(json_decode($this->response->getBody()))
                : $this->response->getBody()->getContents();
        } catch (ClientException $ex) {
            if ($this->silent == true) {
                return $json == true ? response()->json([
                    "message" => [
                        "short" => $ex->getMessage(),
                        "full" => json_decode($this->getErrorMessage($ex))
                    ]
                ], $ex->getCode()) : $ex->getMessage();
            }
            throw new \Exception("Client Error: " . $this->getErrorMessage($ex), $ex->getCode());
        } catch (ServerException $ex) {
            if ($this->silent == true) {
                return $json == true ? response()->json([
                    "message" => [
                        "short" => $ex->getMessage(),
                        "full" => json_decode($this->getErrorMessage($ex))
                    ]
                ], $ex->getCode()) : $ex->getMessage();
            }
            throw new \Exception("Server Error: " . $this->getErrorMessage($ex), $ex->getCode());
        } catch (\Exception $ex) {
            if ($this->silent == true) {
                return $json == true ? response()->json([
                    "message" => $ex->getMessage()
                ], $ex->getCode()) : $ex->getMessage();
            }
            throw new \Exception("Exception Error: " . $ex, $ex->getCode());
        }
    }

    public function getHeader($key = "Location")
    {
        try {
            return $this->response->getHeader($key);
        } catch (\Exception $ex) {
            if ($this->silent == true) {
                return response()->json([
                    "message" => $ex->getMessage()
                ], $ex->getCode());
            }
            throw new \Exception($ex->getMessage());
        }
    }

    public function getErrorMessage($ex)
    {
        $guzzle = [
            "GuzzleHttp\Exception\ServerException",
            "GuzzleHttp\Exception\ClientException"
        ];

        $className = get_class($ex);
        
        if (in_array($className, $guzzle)) {
            return
             $ex->getResponse()->getBody()->getContents();
        }
        return $ex->getMessage();
    }
}
