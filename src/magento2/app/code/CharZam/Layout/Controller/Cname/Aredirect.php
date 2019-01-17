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

class Aredirect extends \Magento\Framework\App\Action\Action
{
    protected $_redirectFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    )
    {
        $this->_redirectFactory = $redirectFactory;
        parent::__construct($context);
    }

    /**
     * Redirect the request to another url. Also sets the parameter
     * The visible request URL will change in the browser
     * http://local.mydomain.se/charzam_controller/cname/aredirect/my_parameter/my_redirect
     * We forward to Ajson in this module. Result would be:
     * http://local.mydomain.se/charzam_controller/cname/ajson/my_parameter/my_redirect/
     * {"input":"my_redirect","output":"tcerider_ym"}
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $myParameter = $this->getRequest()->getParam('my_parameter', 'Redirected!!');

        $result = $this->_redirectFactory->create();
        $result->setPath('charzam_controller/cname/ajson', array(
            'my_parameter' => $myParameter
        ));
        return $result;
    }

}
