<?php

namespace Lib\Http\Interface;

interface ControllerWrapper
{
    public function getResponse(): ?ResponseState;
}
