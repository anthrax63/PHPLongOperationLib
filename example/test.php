<?

require_once('../OperationManager.php');
require_once('../MemcacheStateManager.php');
require_once('../FileStateManager.php');

class Service {
	public function longOperation($a, $b) {
		sleep(2);
		return $a + $b;
	}
}

$stateManager = new MemcacheStateManager('localhost');
//$stateManager = new FileStateManager('/tmp');

$manager = new OperationManager(new Service(), $stateManager);

$opid = $manager->longOperation(5, 6);

echo "Operation ID = ", $opid, "\n";



while (($state = $stateManager->getState($opid)) == "process") {
	echo "State = ", $state, "\n";
	sleep(1);
}

if ($state == "done")
	echo "Result = ", $stateManager->getResult($opid), "\n";

if ($state == "error")
	echo "Error = ", $stateManager->getResult($opid), "\n";

$stateManager->clear($opid);


?>
