<?php
declare(strict_types=1);

namespace Ubermanu\MeiliSearch\Model\Client;

use Magento\AdvancedSearch\Model\Client\ClientInterface;
use MeiliSearch\Client;

class MeiliSearch implements ClientInterface
{
    protected Client $client;

    public function __construct($options = [])
    {
        // TODO: Get hostname, username and password from config
        $this->client = new Client('http://localhost:7700');
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function testConnection(): bool
    {
        try {
            $this->getClient()->version();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
