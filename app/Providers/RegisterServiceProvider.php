<?php
namespace Smartvalue\Providers;
use Smartvalue\Database\PDOConnection;


class RegisterServiceProvider extends ServiceProvider{
            
	public function __construct(){
            parent::__construct('PDOConnection');
	    //$this->register('PDOConnection');

	}

}
