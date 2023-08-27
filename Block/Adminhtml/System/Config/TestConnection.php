<?php
declare(strict_types=1);

namespace Ubermanu\MeiliSearch\Block\Adminhtml\System\Config;

class TestConnection extends \Magento\AdvancedSearch\Block\Adminhtml\System\Config\TestConnection
{
    /**
     * @inheritdoc
     */
    protected function _getFieldMapping(): array
    {
        $fields = [
            'hostname' => 'catalog_search_meilisearch_server_hostname',
            'port' => 'catalog_search_meilisearch_server_port',
            'index' => 'catalog_search_meilisearch_index_prefix',
            'enableAuth' => 'catalog_search_meilisearch_enable_auth',
            'username' => 'catalog_search_meilisearch_username',
            'password' => 'catalog_search_meilisearch_password',
            'timeout' => 'catalog_search_meilisearch_server_timeout',
        ];

        return array_merge(parent::_getFieldMapping(), $fields);
    }
}
