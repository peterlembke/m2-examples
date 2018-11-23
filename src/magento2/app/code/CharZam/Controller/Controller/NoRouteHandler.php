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
namespace CharZam\Controller\Controller;

/**
 * A global request handler that trigger when none of the normal handlers can resolve the request
 * Class NoRouteHandler
 * @package CharZam\Controller\Controller
 */
class NoRouteHandler implements \Magento\Framework\App\Router\NoRouteHandlerInterface
{
    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\App\Route\ConfigInterface
     */
    protected $routeConfig;

    /**
     * @param \Magento\Backend\Helper\Data $helper
     * @param \Magento\Framework\App\Route\ConfigInterface $routeConfig
     */
    public function __construct(
        \Magento\Backend\Helper\Data $helper,
        \Magento\Framework\App\Route\ConfigInterface $routeConfig
    ) {
        $this->helper = $helper;
        $this->routeConfig = $routeConfig;
    }

    /**
     * Check and process no route request
     * http://local.mydomain.se/charzam_controller/cnamefoobar/ajson/my_parameter/helloworld
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function process(\Magento\Framework\App\RequestInterface $request)
    {
        $requestPathParams = explode('/', trim($request->getPathInfo(), '/'));
        $areaFrontName = array_shift($requestPathParams);

        if ($areaFrontName === 'charzam_controller') {
            $request->setModuleName('charzam_controller');
            $request->setControllerName('Cname'); // Not part of the Interface. That is a bug.
            $request->setActionName('Ajson');
            $request->setParams(array(
                    'my_parameter' => 'Noroute!!!'
            ));
            return true;
        }
        return false;
    }
}
