<?php
declare(strict_types=1);
/**
 * CharZam_Database
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Database is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Database is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_UseProxy.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Database
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Database\Api\Data;

/**
 * Work out Interface
 */
interface WorkoutInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    public function getDate(): string;
    public function setDate($date = '');

    public function getTime(): string;
    public function setTime($time = '');

    public function getDistance(): string;
    public function setDistance($meter = 0);

    public function getNote(): string;
    public function setNote($note = '');

    public function getWhere(): string;
    public function setWhere($where = '');

    public function getIndoor(): bool;
    public function setIndoor($indoor = false);

    public function getCompetition(): bool;
    public function setCompetition($competition = false);
}
