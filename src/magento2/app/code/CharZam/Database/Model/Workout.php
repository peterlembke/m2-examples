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
namespace CharZam\Database\Model;
use CharZam\Database\Api\Data\WorkoutInterface;

class Workout extends \Magento\Framework\Model\AbstractModel implements WorkoutInterface
{
    protected function _construct()
    {
        $resourceModelName = \CharZam\Database\Model\ResourceModel\Workout::class;
        $this->_init($resourceModelName);
    }

    public function getDate(): string {
        return $this->getData('date');
    }

    public function setDate($date = '') {
        return $this->setData('date', $date);
    }

    public function getTime(): string {
        return $this->getData('time');
    }

    public function setTime($time = '') {
        return $this->setData('time', $time);
    }

    public function getDistance(): string {
        return $this->getData('distance');
    }

    public function setDistance($meter = 0) {
        return $this->setData('distance', $meter);
    }

    public function getNote(): string {
        return $this->getData('note');
    }

    public function setNote($note = '') {
        return $this->setData('note', $note);
    }

    public function getWhere(): string {
        return $this->getData('where');
    }

    public function setWhere($where = '') {
        return $this->setData('where', $where);
    }

    public function getIndoor(): bool {
        return $this->getData('indoor');
    }

    public function setIndoor($indoor = false) {
        return $this->setData('indoor', $indoor);
    }

    public function getCompetition(): bool {
        return $this->getData('competition');
    }

    public function setCompetition($competition = false) {
        return $this->setData('competition', $competition);
    }

    /**
     * Calculates the speed meter/second
     * @return float
     */
    public function getSpeedms(): float {
        $meter = $this->getDistance();
        $time = $this->getTime();
        $seconds = $this->timeToSeconds($time);
        $speedms = $meter / $seconds;
        return $speedms;
    }

    /**
     * Calculates the speed Km/h
     * @return float
     */
    public function getSpeedKmh(): float {
        $speedms = $this->getSpeedms();
        $kmh = $speedms * 3.6;
        return $kmh;
    }

    /**
     * Calculates the speed min/Km
     * @return string
     */
    public function getSpeedMinKm(): string {
        $speedms = $this->getSpeedms();
        $seconds = 1000.0 / $speedms;
        $minutes = (int) $seconds / 60.0;
        $secondsLeft = $seconds - $minutes * 60;
        $secondsLeft = str_pad($secondsLeft, $digits = 2, $padding = '0', STR_PAD_LEFT);
        $row = $minutes . ':' . $secondsLeft;
        return $row;
    }

    /**
     * Convert a time in format HH:MM:SS, MM:SS, M:SS to seconds
     * @source https://stackoverflow.com/questions/4834202/convert-time-in-hhmmss-format-to-seconds-only
     * @param string $time
     * @return mixed
     */
    protected function timeToSeconds($time = ''): int {
        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        if (isset($seconds) === true) {
            $result = $hours * 3600 + $minutes * 60 + $seconds;
        } else {
            $result = $hours * 60 + $minutes;
        }
        return $result;
    }
}
