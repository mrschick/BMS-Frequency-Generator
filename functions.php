<?php
	$assignedUHF = array(); // array that stores all already assigned frequencies, both for stations+ils and radiomap.

	function execute($mode1, $mode2) // master function that defines which work functions get called based on what the User wants to do.
	{
		if($mode1)
		{
			radiomap($_FILES["radiomap"]["tmp_name"]);
			$ret = stationsils($_FILES["stationsils"]["tmp_name"], $mode2);
		}
		else
		{
			$ret = stationsils($_FILES["stationsils"]["tmp_name"], $mode2);
		}

		echo "<textarea rows='35' readonly>".$ret."</textarea>";
	}

	function radiomap($file)
	{
		global $assignedUHF;

		$lines = explode("\n", file_get_contents($file));

		foreach($lines as $line)
		{
			if(substr($line, 0, 2) != "//" && $line != "\r" && !empty($line))
			{
				$el = explode(", ", $line);
				if(is_numeric($el[1]))
					array_push($assignedUHF, $el[1]);
			}
		}
	}

	function stationsils($file, $mode)
	{
		// min 225.00 - max 399.95 / GUARD 243.00
		$lines = explode("\n", file_get_contents($file));

		$output = "";

		$to_assign = array(6, 12, 13, 14); // randomly assign 6, 12, 13, 14; TwrU/OpsU/GndU/AppU
		global $assignedUHF;

		if($mode) // if the user wants to keep already assigned ATC frequencies.
		{
			foreach($lines as $line)
			{
				$el = explode(" ", $line);
				if(substr($line, 0, 1) != "#" && $line != "\r" && !empty($line))
				{
					foreach($to_assign as $n)
					{
						if($el[$n] != 0)
							array_push($assignedUHF, $el[$n]);
					}
				}
			}
		}

		foreach($lines as $line)
		{
			$el = explode(" ", $line);
			if(substr($line, 0, 1) != "#" && $line != "\r" && !empty($line)) // Exclude line conditions
			{
				if($mode) // if the user wants to keep already assigned ATC frequencies.
				{
					foreach($to_assign as $n)
					{
						if($el[$n] == 0) // only generate frequencies for unassigned slots
						{
							do {
								$el[$n] = rand(225000, 399750);
							} while($el[$n] % 25 != 0 || in_array($el[$n], $assignedUHF) || $el[$n] == 243000); // repeat if not a 25kHz step, frequency already used or is GUARD
							array_push($assignedUHF, $el[$n]);
						}
					}
				}
				else // if the user doesn't care about keeping already assigned ATC frequencies.
				{
					foreach($to_assign as $n)
					{
						do {
							$el[$n] = rand(225000, 399750);
						} while($el[$n] % 25 != 0 || in_array($el[$n], $assignedUHF) || $el[$n] == 243000); // repeat if not a 25kHz step, frequency already used or is GUARD
						array_push($assignedUHF, $el[$n]);
					}
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
?>