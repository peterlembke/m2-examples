<?php
/**
 * CharZam_Layout
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Layout is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Layout is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_Layout.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Layout
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Layout\Controller\Cname;

use Magento\Framework\App\Action\Context;

class Aforward extends \Magento\Framework\App\Action\Action
{
    protected $_forwardFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
    )
    {
        $this->_forwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    /**
     * Forwards the request to another module, controller action. Also sets the parameter
     * The visible request URL will never change in the browser
     * We forward to Ajson in this module. Result would be:
     * {"input":"Forwarded!!","output":"!!dedrawroF"}
     * http://local.mydomain.se/charzam_controller/cname/aforward
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $myParameter = $this->getRequest()->getParam('my_parameter', 'foobar');
        $revertedString = strrev($myParameter);

        $out = array(
            'input' => $myParameter,
            'output' => $revertedString
        );

        $result = $this->_forwardFactory->create();
        $result->setModule('charzam_controller');
        $result->setController('cname');
        $result->setParams(array(
            'my_parameter' => 'Forwarded!!'
        ));
        $result->forward('Ajson');
        return $result;
    }

}
