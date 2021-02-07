<?php
	$assignedUHF = array(); //array that stores all already assigned frequencies, both for stations+ils and radiomap.

	function contains($arr, $n) // if $n is found in $arr, return true
	{
		$found = false;

		foreach($arr as $e)
		{
			if($e == $n)
				$found = true;
		}

		return $found;
	}

	function stationsils($file)
	{
		// min 225.00 - max 399.95 / GUARD 243.00
		$lines = explode("\n", file_get_contents($file));

		$output = "";

		$to_assign = array(6, 12, 13, 14); // randomly assign 6, 12, 13, 14; TwrU/OpsU/GndU/AppU
		global $assignedUHF;

		foreach($lines as $line)
		{
			$el = explode(" ", $line);
			if(substr($line, 0, 1) != "#" && $line != "\r" && !empty($line)) // Exclude line conditions
			{
				foreach($to_assign as $n)
				{
					do {
						$el[$n] = rand(225000, 399750);
					} while($el[$n] % 25 != 0 || contains($assignedUHF, $el[$n]) || $el[$n] == 243000); // repeat if not a 25kHz step, frequency already used or is GUARD
					array_push($assignedUHF, $el[$n]);
				}
				$tmpOut = "";
				foreach($el as $e) // Combine modified line elements to a single line for output
				{
					if(empty($tmpOut))
						$tmpOut = $e;
					else
						$tmpOut = $tmpOut." ".$e;
				}

				$output = $output.$tmpOut;
			}
			else // if the line is excluded
			{
				$output = $output.$line."\n";
			}
		}

		return $output;
	}

	/*function radiomap($file) //Future stuff
	{
		;
	}*/
?>