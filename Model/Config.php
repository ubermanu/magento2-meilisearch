<?php
declare(strict_types=1);

namespace Ubermanu\MeiliSearch\Model;

use Magento\AdvancedSearch\Model\Client\ClientOptionsInterface;
use Magento\AdvancedSearch\Model\Client\ClientResolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ClientOptionsInterface
{
    const ENGINE_NAME = 'meilisearch';

    const MEILISEARCH_DEFAULT_TIMEOUT = 15;

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @var string
     */
    private string $prefix;

    /**
     * @var ClientResolver
     */
    private ClientResolver $clientResolver;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ClientResolver $clientResolver
     * @param string|null $prefix
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ClientResolver $clientResolver,
        string $prefix = null,
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->clientResolver = $clientResolver;
        $this->prefix = $prefix ?: $this->clientResolver->getCurrentEngine();
    }

    /**
     * @inheritDoc
     */
    public function prepareClientOptions($options = [])
    {
        $defaultOptions = [
            'hostname' => $this->getMeilisearchConfigData('server_hostname'),
            'port' => $this->getMeilisearchConfigData('server_port'),
            'index' => $this->getMeilisearchConfigData('index_prefix'),
            'enableAuth' => $this->getMeilisearchConfigData('enable_auth'),
            'username' => $this->getMeilisearchConfigData('username'),
            'password' => $this->getMeilisearchConfigData('password'),
            'timeout' => $this->getMeilisearchConfigData('server_timeout') ?: self::MEILISEARCH_DEFAULT_TIMEOUT,
        ];

        $options = array_merge($defaultOptions, $options);
        $allowedOptions = array_merge(array_keys($defaultOptions), ['engine']);

        return array_filter(
            $options,
            function (string $key) use ($allowedOptions) {
                return in_array($key, $allowedOptions);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @param string $field
     * @param int $storeId
     * @return string|int
     */
    public function getMeilisearchConfigData($field, $storeId = null)
    {
        return $this->getSearchConfigData($this->prefix . '_' . $field, $storeId);
    }

    /**
     * @param string $field
     * @param int|null $storeId
     * @return string|int
     */
    public function getSearchConfigData($field, $storeId = null)
    {
        $path = 'catalog/search/' . $field;
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @return string
     */
    public function getIndexPrefix(): string
    {
        return $this->getMeilisearchConfigData('index_prefix');
    }
}
