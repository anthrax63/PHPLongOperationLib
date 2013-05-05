<?php
class Thread {
	public $runnable = null;

	function __construct($runnable) {
		$this->runnable = $runnable;
	}

	function start($state_manager, $operation_id) {
		$state_manager->setState($operation_id, "process");
		$pid = pcntl_fork();
		if ($pid == -1)
			return false;
		if (!$pid) {
			$result = null;
			try {
				$result = $this->runnable->run();
				$state_manager->setResult($operation_id, $result);
				$state_manager->setState($operation_id, "done");
			} catch (Exception $e) {
				$state_manager->setResult($operation_id, $e);
				$state_manager->setState($operation_id, "error");
			}
			exit(0);
		} else {
			return $operation_id;
		}
	}

}
?>