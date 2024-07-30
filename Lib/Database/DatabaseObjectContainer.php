<?php
namespace Lib\Database;

interface DatabaseObjectContainer
{
    /**
     * Returns a database access object
     * @return object
     */
    public function get(): object;
}