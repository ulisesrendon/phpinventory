<?php
namespace Lib\Database;

interface DatabaseSendCommand
{
    public function sendCommand(string $command, array $params = []);

}