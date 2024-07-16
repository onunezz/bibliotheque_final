<?php 
# AUTOCARGADOR DE CONTROLADORES Y MODELOS
spl_autoload_register(function($class){
	if (strpos($class, "Controller")) {
		require_once '../controllers/'.$class.'.php';
	}
	if (strpos($class, "Model")) {
		require_once '../models/'.$class.'.php';
	};
});

# CARGO LA PLANTILLA PRINCIPAL
$index = new IndexController;
$index -> run();