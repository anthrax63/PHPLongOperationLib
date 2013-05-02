<?php

require_once('StateManager.php');

class MemcacheStateManager extends StateManager {
	private $memcache = null;
	private $prefix = "MemcacheStateManager/";

	function __construct($host, $port = 11211) {
		$this->memcache = new Memcache();
		$this->memcache->connect($host, $port);
	}	

	private function getMemcacheStateKey($key) {
		return $this->prefix.$key.".state";
	}

	private function getMemcacheResultKey($key) {
		return $this->prefix.$key.".result";
	}

	public function getState($key) {
		$data = $this->memcache->get($this->getMemcacheStateKey($key));
		return unserialize($data);
	}

	public function setState($key, $value) {
		$this->memcache->set($this->getMemcacheStateKey($key), serialize($value), 0, 0);
	}

	public function getResult($key) {
		$data = $this->memcache->get($this->getMemcacheResultKey($key));
		return unserialize($data);
	}

	public function setResult($key, $value) {
		$this->memcache->set($this->getMemcacheResultKey($key), serialize($value), 0, 0);
	}

	public function clear($key) {
		$this->memcache->delete($this->getMemcacheStateKey($key));
		$this->memcache->delete($this->getMemcacheResultKey($key));
	}
}
?>