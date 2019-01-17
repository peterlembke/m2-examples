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

class Araw extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_rawFactory;

    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    protected $moduleReader;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $_file;

    /**
     * @param Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $rawFactory
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem\Driver\File $file
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\RawFactory $rawFactory,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem\Driver\File $file
    )
    {
        $this->_rawFactory = $rawFactory;
        $this->moduleReader = $moduleReader;
        $this->_file = $file;
        parent::__construct($context);
    }

    /**
     * With Raw you output raw data or binary files you want to download etc.
     * In this example we will read the README.md file and output the content on screen.
     * http://local.mydomain.se/charzam_controller/cname/araw
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $filePath = $this->getModuleDir('/README.md');
        $fileData = $this->_file->fileGetContents($filePath);
        $result = $this->_rawFactory->create();
        $result->setContents($fileData);
        return $result;
    }

    public function getModuleDir($file = ''): string
    {
        $moduleDirectory = $this->moduleReader->getModuleDir($type = '', $moduleName = 'CharZam_Layout');
        return $moduleDirectory . $file;
    }
}
