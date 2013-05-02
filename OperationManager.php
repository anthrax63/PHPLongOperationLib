<?php

require_once('Thread.php');
require_once('OperationRunner.php');

class OperationManager {
	private $object = null;
	private $stateManager = null;

	function __construct($object, $stateManager) {
		$this->object = $object;
		$this->stateManager = $stateManager;
	}

	function __call($method, $arguments) {
		$thread = new Thread(new OperationRunner($this->object, $method, $arguments));
		return $thread->start($this->stateManager);
	}
}
?>

