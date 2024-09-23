<?php

namespace App\Shared\Database;

interface DatabaseSendCommand
{
    public function sendCommand(string $command, array $params = []);
}
