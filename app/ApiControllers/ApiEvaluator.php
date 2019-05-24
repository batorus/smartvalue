<?php
namespace Smartvalue\ApiControllers;

interface ApiEvaluator
{
    public function evaluate($method, $arguments = []);
}