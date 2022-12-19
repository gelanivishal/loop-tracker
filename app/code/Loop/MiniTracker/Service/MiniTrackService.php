<?php

namespace Loop\MiniTracker\Service;

use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Zend\Http\ClientFactory;
use Zend\Http\Response;

class MiniTrackService
{
    /**
     * Tracking URL
     */
    const TRACKING_URL = 'https://supertracking.view.agentur-loop.com/trackme';

    private Json $json;
    private ClientFactory $httpClientFactory;

    /**
     * @param ClientFactory $httpClientFactory
     * @param Json $json
     */
    public function __construct(ClientFactory $httpClientFactory, Json $json)
    {
        $this->httpClientFactory = $httpClientFactory;
        $this->json = $json;
    }

    /**
     * @param $requestPayload
     * @return array
     */
    public function trackMe($requestPayload): array
    {
        $client = $this->httpClientFactory->create();
        $headers = [
            'Content-Type: application/json'
        ];
        $client->setHeaders($headers);
        $client->setMethod('POST');
        $client->setRawBody($this->json->serialize($requestPayload));
        $client->setUri(self::TRACKING_URL);

        try {
            $response = $client->send();
            $responseBody = $response->getBody();
            $trackingInfo = $this->json->unserialize($responseBody);
            return array_merge($requestPayload, $trackingInfo);
        } catch (\Exception $e) {
            return [];
        }
    }
}
