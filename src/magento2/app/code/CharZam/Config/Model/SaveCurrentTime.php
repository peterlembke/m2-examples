<?php
declare(strict_types=1);
/**
 * CharZam_Config
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
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
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */

namespace CharZam\Crontab\Model;
use CharZam\Crontab\Api\SaveCurrentTimeInterface;

class SaveCurrentTime implements SaveCurrentTimeInterface
{
    protected $directoryList;

    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->directoryList = $directoryList;
    }

    CONST FILENAME = 'charzam_crontab_example.txt';

    public function execute($addedBy = 'unknown') {
        $currentTime = $this->_TimeStamp();
        $fileContents = $this->getFileContents();

        $addThis = $currentTime . ' - Added by: ' . $addedBy;

        $newFileContents = $this->addToString($fileContents, $addThis);
        $this->writeFileContents($newFileContents);
    }

    /**
     * Return current time stamp as a string in the format "yyyy-mm-dd hh:mm:ss"
     * Give 'c' to also get the time zone offset.
     * @param string $in
     * @return string
     */
    final protected function _TimeStamp(string $in = ''): string
    {
        if ($in === 'c') {
            return date('c');
        }
        return date('Y-m-d H:i:s');
    }

    /**
     * Get the full path to the file we will use
     * @return string
     */
    protected function getPath(): string
    {
        $path = $this->directoryList->getPath('var');
        $path = $path . '/' . self::FILENAME;
        return $path;
    }

    /**
     * Get file contents from the file we use in this example
     * @return string
     */
    public function getFileContents(): string
    {
        $path = $this->getPath();
        $fileContents = '';
        if (file_exists($path) === true) {
            $fileContents = file_get_contents($path);
        }
        return $fileContents;
    }

    /**
     * Put strings together and truncate
     * @param string $currentString
     * @param string $toAdd
     * @return string
     */
    protected function addToString(string $currentString = '', string $toAdd = ''): string
    {
        $newString = $toAdd . "\n" . $currentString;
        $newString = substr($newString, 0, 200);
        return $newString;
    }

    /**
     * Write to the file we use in this example module
     * @param string $fileContents
     * @return bool
     */
    protected function writeFileContents(string $fileContents = ''): bool
    {
        $path = $this->getPath();
        $result = file_put_contents($path, $fileContents);

        if ($result !== false) {
            $result = true;
        }

        return $result;
    }

}