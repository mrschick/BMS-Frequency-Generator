# Falcon BMS Frequency Generator
Falcon BMS Theaters use "stations+ils.dat" files to define the frequency/band of each ATC station and Navaid on each airbase across the theater, as well as "radiomap.dat" files to define the flight-frequency of each callsign.

## Why?
Frequencies may overlap in newly created "stations+ils.dat" files, which increases comm-clutter on ATC frequencies.
There is also a possibility of "radiomap.dat" frequencies overlapping with "stations+ils.dat" ones, albeit less severe.

The script will read a given stations file and procedurally generate individual UHF frequencies for the Ground, Tower and Departure/Approach ATC entities on each airbase.
If the user wants to they can also provide a radiomap file, the script will then record all UHF frequencies in that file, subsequent generation of new frequencies for the stations file will not output frequencies present in the radiomap file.

## The product

The latest version of the PHP written web-based script is always ready for use [here](http://fabioschick.altervista.org/tools/BMS-Frequency-Generator/).

A Python port of the same script is available for download [here](https://github.com/RUSHER0600/BMS-Frequency-Generator/raw/main/bms-freqgen.py), to run it you need to [download the Python interpreter](https://www.python.org/downloads/).
This version of the script works through the command line interface, more info via the "--help" command.