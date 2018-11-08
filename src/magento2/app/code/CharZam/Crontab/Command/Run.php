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
use CharZam\Crontab\Api\SaveCurrentTimeInterface;

/**
 * Class Run
 * @package CharZam\Crontab\Command
 * In this test I am using Class1 and MyObject1. See di.xml
 * RUN:
 * magento charzam:class2test
 * RESULT:
 * function_foo="original text is all lower case"; class_foo="New DI foo 1"; class_name="CharZam\DiExample\Model\Class1";
 * start_value="58"; my_object_class="CharZam\DiExample\Model\MyObject1";
 */
class Run extends Command
{
    protected $saveCurrentTime;

    public function __construct(
        SaveCurrentTimeInterface $saveCurrentTimeInterface,
        $name = null
    )
    {
        $this->saveCurrentTime = $saveCurrentTimeInterface;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:crontab:run');
        $this->setDescription('Test plugins');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->saveCurrentTime->execute($addedBy = 'console command');
        $fileContents = $this->saveCurrentTime->getFileContents();
        $output->writeln($fileContents);
    }
}