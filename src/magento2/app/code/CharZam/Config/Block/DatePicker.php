<?php
/**
 * CharZam_Config
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2019  Improove
 *
 * CharZam_Config is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Config is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_Config.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Config
 * @copyright   Copyright (C) 2019 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */

namespace CharZam\Config\Block;

use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;

// Code from: https://webkul.com/blog/add-date-picker-magento2-configuration-section-using-system-xml/

class DatePicker extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var  Registry
     */
    protected $_coreRegistry;

    /**
     * @param Context  $context
     * @param Registry $coreRegistry
     * @param array    $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Date format "dd/mm/yy"
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        //get configuration element
        $html = $element->getElementHtml();
        //check datepicker set or not
        if (!$this->_coreRegistry->registry('datepicker_loaded')) {
            $this->_coreRegistry->registry('datepicker_loaded', 1);
        }
        //add icon on datepicker
        $html .= '<button type="button" style="display:none;" class="ui-datepicker-trigger '
            .'v-middle"><span>Select Date</span></button>';
        // add datepicker with element by jquery
        $html .= '<script type="text/javascript">
            require(["jquery", "jquery/ui"], function (jq) {
                jq(document).ready(function () {
                    jq("#' . $element->getHtmlId() . '").datepicker( { dateFormat: "yy-mm-dd" } );
                    jq(".ui-datepicker-trigger").removeAttr("style");
                    jq(".ui-datepicker-trigger").click(function(){
                        jq("#' . $element->getHtmlId() . '").focus();
                    });
                });
            });
            </script>';
        // return datepicker element
        return $html;
    }
}