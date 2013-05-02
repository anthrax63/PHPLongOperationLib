<?php

require_once('StateManager.php');

class FileStateManager extends StateManager {
	private $dir = "/tmp";

	function __construct($dir = "/tmp") {
		$this->dir = $dir;
	}	

	private function getStateFile($key) {
		return $this->dir."/".$key.".state";
	}

	private function getResultFile($key) {
		return $this->dir."/".$key.".result";
	}

	public function getState($key) {
		$data = file_get_contents($this->getStateFile($key));
		return unserialize($data);
	}

	public function setState($key, $value) {
		file_put_contents($this->getStateFile($key), serialize($value));
	}

	public function getResult($key) {
		$data = file_get_contents($this->getResultFile($key));
		return unserialize($data);
	}

	public function setResult($key, $value) {
		file_put_contents($this->getResultFile($key), serialize($value));
	}

	public function clear($key) {
		unlink($this->getStateFile($key));
		unlink($this->getResultFile($key));
	}
}
?>