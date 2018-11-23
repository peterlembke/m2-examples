<?php
/**
 * CharZam_Controller
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Controller is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Controller is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_Controller.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Controller
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Controller\Controller\Cname;

use Magento\Framework\App\Action\Context;

class Ajson extends \Magento\Framework\App\Action\Action
{
    protected $_resultJsonFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * Put a string in my_parameter. Get a json with the string reversed
     * http://local.mydomain.se/charzam_controller/cname/ajson/my_parameter/helloworld
     * Result: {"input":"helloworld","output":"dlrowolleh"}
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

        $result = $this->_resultJsonFactory->create();
        $result->setData($out);
        return $result;
    }

}
