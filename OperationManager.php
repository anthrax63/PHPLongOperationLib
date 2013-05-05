<?php

require_once('Thread.php');
require_once('OperationRunner.php');

class OperationManager {
	private $object = null;
	private $stateManager = null;
	private $nextId = null;

	function __construct($object, $stateManager) {
		$this->object = $object;
		$this->stateManager = $stateManager;
	}

	function __call($method, $arguments) {
		if ($method == "pregenerateId") 
			return $this->pregenerateId();
		$thread = new Thread(new OperationRunner($this->object, $method, $arguments));
		if ($this->nextId == null)
			$this->nextId = $this->generateId();
		$result = $thread->start($this->stateManager, $this->nextId);
		$this->nextId = null;
		return $result;
	}

	function generateId() {
		return md5(uniqid(rand(), true));
	}

	public function pregenerateId() {
		$this->nextId = $this->generateId();
		return $this->nextId;
	}
}
?>

