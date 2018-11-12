<?php

namespace CharZam\Config\Block\Adminhtml\Config;

class Demo extends \Magento\Config\Block\System\Config\Form\Field
{

    /**
     * Unset some non-related element parameters.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return string
     */
    public function render(
        \Magento\Framework\Data\Form\Element\AbstractElement $element
    ) {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * @return $this
     */
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('config/demo.phtml');
        }

        return $this;
    }

    public function getLink() {
        return $this->getUrl('charzam_config/test/index');
    }

    /**
     * Get the button and scripts contents.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return string
     */
    public function _getElementHtml(
        \Magento\Framework\Data\Form\Element\AbstractElement $element
    ) {
        $url = $this->_urlBuilder->getUrl('dotdigitalgroup_email/addressbook/save');
        $this->addData(
            [
                'button_label' => "My button label",
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $url,
            ]
        );

        return $this->_toHtml();
    }

}
