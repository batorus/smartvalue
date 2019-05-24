<?php
namespace Smartvalue\RPC;

interface Evaluator
{
    public function evaluate($method, $arguments);
}