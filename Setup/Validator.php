<?php
declare(strict_types=1);

namespace Ubermanu\MeiliSearch\Setup;

use Magento\AdvancedSearch\Model\Client\ClientResolver;
use Magento\Search\Model\SearchEngine\ValidatorInterface;

class Validator implements ValidatorInterface
{
    /**
     * @var ClientResolver
     */
    private ClientResolver $clientResolver;

    public function __construct(ClientResolver $clientResolver)
    {
        $this->clientResolver = $clientResolver;
    }

    /**
     * @inheritdoc
     */
    public function validate(): array
    {
        $errors = [];
        try {
            $client = $this->clientResolver->create();
            if (!$client->testConnection()) {
                $engine = $this->clientResolver->getCurrentEngine();
                $errors[] = "Could not validate a connection to the Search engine: $engine."
                    . ' Verify that the host and port are configured correctly.';
            }
        } catch (\Exception $e) {
            $errors[] = 'Could not validate a connection to MeiliSearch. ' . $e->getMessage();
        }
        return $errors;
    }
}
