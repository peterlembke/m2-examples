<?php
declare(strict_types=1);
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

namespace CharZam\Crontab\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use CharZam\Crontab\Cron\SaveCurrentTime;

/**
 * Class Run
 * @package CharZam\Crontab\Command
 * This command will just make sure that the cron class actually works
 * RUN:
 * magento charzam:crontab:cron
 * RESULT:
 *
 */
class Cron extends Command
{
    protected $saveCurrentTimeCron;

    public function __construct(
        SaveCurrentTime $saveCurrentTime,
        $name = null
    )
    {
        $this->saveCurrentTimeCron = $saveCurrentTime;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:crontab:cron');
        $this->setDescription('Test if the cron class works');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->saveCurrentTimeCron->execute();
        $output->writeln('Test of Cron class done');
    }
}