<?php
class Thread {
	public $runnable = null;

	function __construct($runnable) {
		$this->runnable = $runnable;
	}

	function start($state_manager) {
		$pid = pcntl_fork();
		if ($pid == -1)
			return false;
		if (!$pid) {
			$result = null;
			try {
				$result = $this->runnable->run();
				$state_manager->setResult(getmypid(), $result);
				$state_manager->setState(getmypid(), "done");
			} catch (Exception $e) {
				$state_manager->setResult(getmypid(), $e);
				$state_manager->setState(getmypid(), "error");
			}
			exit(0);
		} else {
			$state_manager->setState($pid, "process");
			return $pid;
		}
	}

}
?>