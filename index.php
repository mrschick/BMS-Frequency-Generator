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
							<li>This script processes the <span class="path">Data\Campaign\stations+ils.dat</span><!--and <span class="path">Data\Campaign\radiomap.dat</span>--> file that contains all Airbase Navaid settings and ATC frequencies for your Falcon BMS 4.35 Theater;</li><br>
							<li>It will ignore commented (starting with #) and empty lines; active lines will be edited, and the relative fields for OPS, GND, TWR and APP UHF frequencies changed to a random band;</li><br>
							<li>Radio Band generation follows BMS 4.35 rules: UHF frequencies are separated by 25 kHz intervals and in the 225.000-399.950 MHz range;</li><br>
							<li>The random generator is coded to never assign the same frequency more than once during a single execution, and to never assign the UHF-GUARD channel (243.000 MHz);</li><br>
						</ul><br>
						Attach your <span class="path">stations+ils.dat</span> file: <input type="file" name="stationsils" required><br><br>
						<!--Attach your <span class="path">radiomap.dat</span> file: <input type="file" name="radiomap" required><br><br>-->
						<input type="submit" value="Send Files"><br><br>
						<input type="reset" value="Reset Files">
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
							echo "<textarea rows='25' readonly>".stationsils($_FILES["stationsils"]["tmp_name"])."</textarea>";
						}
					?>
				</td>
			</tr>
		</table><br><br>
		<center><a class="footer" href="https://github.com/RUSHER0600/BMS-Frequency-Generator" target="_blank">GitHub Repository</a></center><br>
	</body>
</html>