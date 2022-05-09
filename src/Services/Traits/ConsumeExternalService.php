<?php

namespace Gustavohmbarbosa\MicroservicesCommon\Services\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

trait ConsumeExternalService
{
    /**
     * API key
     * 
     * @var string
     */
    public string $key;

    /**
     * API url
     * 
     * @var string
     */
    public string $url;

    /**
     * @param array $headers
     * 
     * @return array
     */
    protected function headers(array $headers): array
    {
        $headers = array_merge([
            'content_type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => $this->key
        ], $headers);

        return $headers;
    }

    /**
     * @param string $endpoint
     * 
     * @return string
     */
    protected function url(string $endpoint): string
    {
        $endpoint = strpos($endpoint, '/') === 0 ? $endpoint : "/{$endpoint}";

        return $this->url . $endpoint;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @param array $headers
     * 
     * @return Response
     */
    public function request(
        string $method,
        string $endpoint,
        array $data = [],
        array $headers = []
    ): Response {
        return Http::withHeaders($this->headers($headers))->$method($this->url($endpoint), $data);
    }
}
