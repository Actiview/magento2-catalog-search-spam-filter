<?php

declare(strict_types=1);

namespace Actiview\CatalogSearchSpamFilter\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 *
 */
class Configuration
{
    const XML_PATH_ENABLE = 'catalog/catalog_search_spam_filter/enable';
    const XML_PATH_WORDS = 'catalog/catalog_search_spam_filter/words';

    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled($scopeType = 'store', $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE, $scopeType, $scopeCode);
    }

    public function getWords($scopeType = 'store', $scopeCode = null): array
    {
        $words = json_decode(
            $this->scopeConfig->getValue(self::XML_PATH_WORDS, $scopeType, $scopeCode) ?? '',
            true
        ) ?? [];

        return array_map(function ($item) {
            return $item['word'];
        }, $words);
    }
}
