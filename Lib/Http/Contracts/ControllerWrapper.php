<?php
namespace Lib\Http\Contracts;

interface ControllerWrapper
{
    public function get();

    public function execute();
}