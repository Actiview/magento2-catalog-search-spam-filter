<?php

declare(strict_types=1);

namespace Actiview\CatalogSearchSpamFilter\Observer;

use Actiview\CatalogSearchSpamFilter\Model\Configuration;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Filter catalog search for specific words or characters
 */
class ControllerActionPredispatchObserver implements ObserverInterface
{
    /** @var Configuration */
    protected $configuration;

    /** @var ForwardFactory */
    protected $forwardFactory;

    public function __construct(
        Configuration $configuration,
        ForwardFactory $forwardFactory
    ) {
        $this->configuration = $configuration;
        $this->forwardFactory = $forwardFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var RequestInterface $request */
        $request = $observer->getEvent()->getData('request');

        if (!$this->shouldFilter($request)) {
            return null;
        }

        $words = $this->configuration->getWords();
        $q = $request->getParam('q');

        foreach ($words as $word) {
            if (strpos($q, $word) !== false) {
                return $this->forwardFactory->create()->forward('noroute');
            }
        }
    }

    private function shouldFilter(RequestInterface $request): bool
    {
        if (!$this->configuration->isEnabled()) {
            return false;
        }

        if ($request->getFullActionName() !== 'catalogsearch_result_index') {
            return false;
        }

        return true;
    }
}
