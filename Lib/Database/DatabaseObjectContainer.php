<?php

namespace Lib\Database;

interface DatabaseObjectContainer
{
    /**
     * Returns a database access object
     */
    public function get(): object;
}
