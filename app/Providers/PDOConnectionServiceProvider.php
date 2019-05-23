<?php
namespace Smartvalue\Providers;
use Smartvalue\Database\PDOConnection;


class PDOConnectionServiceProvider extends ServiceProvider{
            
	public function __construct(){

		$this->register('PDOConnection', function(){			 
			return new PDOConnection;			
		});

	}

}
