<?php

namespace App\Console;

use App\Commands\CommandInterface;

class ScheduledRecurringTask
{
    protected CommandInterface $command;

    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    public function run()
    {
        $this->command->execute();
    }
}
