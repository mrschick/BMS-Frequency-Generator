<!DOCTYPE html>
<html>
	<head>
		<title>BMS Freq. Generator</title>
		<link rel="stylesheet" type="text/css" href="main.css">
		<script type="text/javascript" src="functions.js"></script>
		<?php include "functions.php"; ?>
	</head>
	<body>
		<h1>Falcon BMS 4.35 Frequency generator script:</h1><br>
		<table border="1">
			<tr>
				<td class="box">
					<form action="" method="POST" enctype="multipart/form-data">
						<b>How it works:</b><br><br>
						<ul>
							<li>
								This script processes the <span class="path">Data\Campaign\stations+ils.dat</span><!--and <span class="path">Data\Campaign\radiomap.dat</span>--> file that contains all Airbase Navaid settings and ATC frequencies for your Falcon BMS 4.35 Theater;
							</li><br>
							<li>
								It will ignore commented (starting with #) and empty lines; active lines will be edited, and the relative fields for OPS, GND, TWR and APP UHF frequencies changed to a random band;
							</li><br>
							<li>
								Radio Band generation follows BMS 4.35 rules: UHF frequencies are separated by 25 kHz intervals and in the 225.000-399.950 MHz range;
							</li><br>
							<li>
								The random generator is coded to never assign the same frequency more than once during a single execution, and to never assign the UHF-GUARD channel (or any other Common UHF channels if you also uploaded the radiomap file);
							</li><br>
							<li>
								You can choose if you want to upload your theater's <span class="path">Data\Campaign\radiomap.dat</span> file, which defines the frequencies used by flights, in order to avoid conflicts with those as well;<br>
								<label class="checkbox"><input type="checkbox" id="mode1" name="radmap" value="1" onchange="setFields()"><label for="mode1">Load "radiomap.dat"</label></label>
							</li><br>
							<li>
								You can also choose between overwriting existing OPS/GND/TWR/APP frequencies (default), or only filling empty ATC entities;<br>
								<label class="checkbox"><input type="checkbox" id="mode2" name="ovrwrt" value="1"><label for="mode2">Keep existing frequencies</label></label>
							</li><br>
						</ul><br>
						<p id="radmap-input" style="display:none;">Attach your <span class="path">radiomap.dat</span> file: <input type="file" id="rd" name="radiomap"><br><br></p>
						Attach your <span class="path">stations+ils.dat</span> file: <input type="file" name="stationsils" required><br><br>
						<input type="submit" value="Send Files"> <input type="reset" value="Reset Files">
					</form>
				</td>
				<td class="wrap">
					<?php
						if(!isset($_FILES["stationsils"]))
						{
							?><center><i>Nothing here yet, time to do something...</i></center><?php
						}
						else
						{
							if(!isset($_POST["radmap"]))
								$mode1 = false;
							else
								$mode1 = true;

							if(!isset($_POST["ovrwrt"]))
								$mode2 = false;
							else
								$mode2 = true;

							execute($mode1, $mode2);
						}
					?>
				</td>
			</tr>
		</table><br><br>
		<center><a class="footer" href="https://github.com/RUSHER0600/BMS-Frequency-Generator" target="_blank">GitHub Repository</a></center><br>
	</body>
</html>