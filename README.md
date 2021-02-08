# Falcon BMS Frequency Generator
Falcon BMS Theaters use "stations+ils.dat" files to define the frequency/band of each ATC station and Navaid on each airbase across the theater.

## Why?
Frequencies overlap in newly created "stations+ils.dat" files, which increases comm-clutter on ATC frequencies.
This script will read an uploaded stations file and procedurally generate individual UHF frequencies for the Ground, Tower and Departure/Approach ATC entities on each airbase.

## To-do:
"radiomap.dat" files assign frequencies to individual aircraft callsigns, handling of this file by the script would be a useful addition.

The latest version is always ready for use [here](http://fabioschick.altervista.org/tools/BMS-Frequency-Generator/)
