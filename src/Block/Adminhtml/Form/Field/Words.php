<?php

declare(strict_types=1);

namespace Actiview\CatalogSearchSpamFilter\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Words extends AbstractFieldArray
{
    /** @inheritDoc */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'word',
            [
                'label' => __('Word / character'),
                'class' => 'required-entry'
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
