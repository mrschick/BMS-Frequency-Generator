import random
import sys

assignedUHF = []

def generateFreq():
	while True:
		ret = random.randrange(225000, 399750, 25)
		if ret not in assignedUHF and ret != 243000:
			return ret

def radiomap(file):
	lines = file.split("\n")
	for line in lines:
		if line[:2] != "//" and line != "\r" and line != "":
			el = line.split(", ")
			if el[1].isdecimal():
				assignedUHF.append(el[1])

def stationsils(file, mode):
	# min 225.00 - max 399.95 / GUARD 243.00
	lines = file.split("\n")
	output = ""

	to_assign = [6, 12, 13, 14] # randomly assign 6, 12, 13, 14; TwrU/OpsU/GndU/AppU

	if mode: # if the user wants to keep already assigned ATC frequencies.
		for line in lines:
			el = line.split(" ")
			if "#" not in line and line != "\r" and line != "":
				for n in to_assign:
					if el[n] != "0":
						assignedUHF.append(el[n])

	for line in lines:
		el = line.split(" ")
		if "#" not in line and line != "\r" and line != "": # Exclude line conditions
			if mode: # if the user wants to keep already assigned ATC frequencies.
				for n in to_assign:
					if el[n] == "0": # only generate frequencies for unassigned slots
						new = generateFreq()
						el[n] = new
						assignedUHF.append(new)
			else: # if the user doesn't care about keeping already assigned ATC frequencies.
				for n in to_assign:
					new = generateFreq()
					el[n] = new
					assignedUHF.append(new)

			tmpOut = ""
			for e in el:
				if tmpOut == "":
					tmpOut = e
				else:
					tmpOut = tmpOut + " " + str(e)
			output = output + tmpOut + "\n"
			
		else:
			output = output + line + "\n"

	return output

def writeOutput(output):
	fout = open("new_stations+ils.dat", "w")
	fout.write(output)
	fout.close()


# execution code

arg = sys.argv

if 2 <= len(arg) <= 4:
	if arg[1] == "--help":
		print("port.py [stations+ils.dat] [radiomap.dat] [-k | keep already assigned ATC frequencies]")
	else:
		stationFile = open(arg[1], "r")
		stationFileStr = stationFile.read()
		stationFile.close()

		if "-k" in arg:
			mode = True
			if len(arg) == 3:
				writeOutput(stationsils(stationFileStr, mode))
			elif len(arg) == 4:
				radioFile = open(arg[2], "r")
				radioFileStr = radioFile.read()
				radioFile.close()
				radiomap(radioFileStr)
				writeOutput(stationsils(stationFileStr, mode))
		else:
			mode = False
			if len(arg) == 2:
				writeOutput(stationsils(stationFileStr, mode))
			elif len(arg) == 3:
				radioFile = open(arg[2], "r")
				radioFileStr = radioFile.read()
				radioFile.close()
				radiomap(radioFileStr)
				writeOutput(stationsils(stationFileStr, mode))
