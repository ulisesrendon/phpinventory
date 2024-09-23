<?php

namespace App\Framework\Database\Intertface;

interface DatabaseSendCommand
{
    public function command(string $command, array $params = []);
}
