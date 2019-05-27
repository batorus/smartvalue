<?php
namespace Smartvalue\ApiControllers;

interface ApiEvaluator
{
    public function evaluate(string $method, array $arguments = []);
}