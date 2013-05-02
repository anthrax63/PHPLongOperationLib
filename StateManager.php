<?php
abstract class StateManager {
	abstract public function getState($key);
	abstract public function setState($key, $value);
	abstract public function getResult($key);
	abstract public function setResult($key, $value);
	abstract public function clear($key);
}
?>