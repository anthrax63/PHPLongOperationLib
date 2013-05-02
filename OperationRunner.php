<?php

require_once('Runnable.php');

class OperationRunner implements Runnable {
	private $object = null;
	private $method = null;
	private $arguments = null;

	function __construct($object, $method, $arguments) {
		$this->object = $object;
		$this->method = $method;
		$this->arguments = $arguments;
	}

	public function run() {
		$method = $this->method;
		return call_user_func_array(array($this->object, $method), $this->arguments);
	}

}

?>