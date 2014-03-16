<?php
switch ($DATA[version]){
	case '3.0.1':
		unlink('success.php');
		$api->update_data('version', '3.0.2');
		$api->logs($TEXT['Your system has been upgraded']);
}
?>