<?php
/**
 * CharZam_Crontab
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Crontab is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Crontab is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_Crontab.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Crontab
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */

namespace CharZam\Crontab\Cron;
use CharZam\Crontab\Api\SaveCurrentTimeInterface;

class SaveCurrentTime
{

    protected $saveCurrentTime;

    public function __construct(
        SaveCurrentTimeInterface $saveCurrentTime
    ) {
        $this->saveCurrentTime = $saveCurrentTime;
    }

    public function execute() {

        // Do not put business logic in here. Instead inject classes and use them.
        // I named the class and function the same as the Cron class, sorry about that. You can of course have any name.

        $this->saveCurrentTime->execute($addedBy = 'Cron');
    }
}