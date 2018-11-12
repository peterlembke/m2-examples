<?php

namespace CharZam\Config\Block\Adminhtml\Config;

class Button extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Retrieve element HTML markup
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        /** @var \Magento\Backend\Block\Widget\Button $buttonBlock  */
        $buttonBlock = $this->getForm()->getLayout()->createBlock(\Magento\Backend\Block\Widget\Button::class);

        $data = [
            'id' => 'charzam_config_block_adminhtml_config_button',
            'label' => 'Demo button',
            'onclick' => "setLocation('" . $this->getUrl('charzam_config/test/index') . "')",
        ];

        $html = $buttonBlock->setData($data)->toHtml();
        return $html;
    }

}
