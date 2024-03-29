<?php

namespace App\Services\Api;

use GuzzleHttp\ClientInterface;
use Kilik\TableBundle\Api\ApiInterface;
use Kilik\TableBundle\Api\StandardResult;
use Kilik\TableBundle\Components\TableInterface;

class UserService implements ApiInterface
{
    /**
     * @var ClientInterface
     */
    private $apiClient;

    /**
     * ContractService constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->apiClient = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function load(TableInterface $table, $filters, $orderBy = [], $page = null, $limit = null)
    {
        // make your own API logic

        $params = [];
        $body = \json_encode($params);

        $jsonResult = \json_decode($this->apiClient->request('GET', '/api/users', ['body' => $body])->getBody(), true);

        $result = new StandardResult();
        $result->setNbTotalRows($jsonResult['total']);
        $result->setNbFilteredRows($jsonResult['total']);

        // build your response mapping
        foreach ($jsonResult['data'] as $row) {
            // you can map data here, or create cool objects
            $result->addRow($row);
        }

        // and return the result
        return $result;
    }
}
