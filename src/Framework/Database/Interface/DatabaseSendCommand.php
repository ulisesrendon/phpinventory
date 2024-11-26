<?php

namespace Stradow\Framework\Database\Interface;

interface DatabaseSendCommand
{
    public function command(string $command, array $params = []);
}
