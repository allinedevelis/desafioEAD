<?php
if (!defined("ROOT"))
	exit();

spl_autoload_register(function ($className){
	$sufixo = substr($className, -3);
	if ($sufixo == "Dao")
		$folder = "dao";
	elseif ($sufixo == "Lib")
		$folder = "libs";
	elseif (substr_count($className, "Model") > 0)
		$folder = "models";
	elseif (substr_count($className, "Controller") > 0)
		$folder = "controllers";	
	else
		$folder = 'config';	

	if (!empty($folder)){
		if (is_file(ROOT."{$folder}/{$className}.php")){
			//echo "INCLUIU: {$folder}/{$className}.php<br/><br/>";
			require_once(ROOT."{$folder}/{$className}.php");
		}else{
			echo ("Arquivo não existente! => ".ROOT."{$folder}/{$className}.php");
		}
	}
});
require_once("loader.php");
?>