<?php
if(!defined('ROOT')) exit('No direct script access allowed');

if(!function_exists("runCmd")) {
    //Run actual commands
	function logiksRunCmd($command, $path) {
	    if(is_array($command)) {
	        $command = implode(";",$command);
	    }
	    if(strlen($command)<=0) return false;
	    $command .= ";";
	    
	    $command = "cd $path; {$command}";
	    
		$descriptorspec = array(
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);
		$pipes = array();
		$resource = proc_open($command, $descriptorspec, $pipes, $path);

		$stdout = stream_get_contents($pipes[1]);
		$stderr = stream_get_contents($pipes[2]);
		foreach ($pipes as $pipe) {
			fclose($pipe);
		}

		$status = trim(proc_close($resource));
		if ($status) {
		    return $stderr;
		}
		
		return $stdout;
	}
}
?>