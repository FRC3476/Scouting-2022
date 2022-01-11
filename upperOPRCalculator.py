#!/usr/bin/env python3

import os
import time
import csv
import numpy as np
import requests
#import frcstat as frc
import json

def main(key):

	teamList = []
	noOfGames = 0
	realScore = []

	url = "https://www.thebluealliance.com/api/v3/event/" + key  + "/matches?X-TBA-Auth-Key=VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU"
	data2 = requests.get(url)
	data = data2.json()
	length = len(data)

	f1 = open('upper.txt', 'w')
	for i in range (0, length):
		if (data[i]["score_breakdown"] == None):
			print (data[i]["alliances"]["red"]["team_keys"][0],", ", data[i]["alliances"]["red"]["team_keys"][1],", ", data[i]["alliances"]["red"]["team_keys"][2],", ", "0",", ", data[i]["alliances"]["blue"]["team_keys"][0],", ", data[i]["alliances"]["blue"]["team_keys"][1],", ", data[i]["alliances"]["blue"]["team_keys"][2],", ", "0",", ",file = f1)
		if (data[i]["score_breakdown"] != None):
			print (data[i]["alliances"]["red"]["team_keys"][0],", ", data[i]["alliances"]["red"]["team_keys"][1],", ", data[i]["alliances"]["red"]["team_keys"][2],", ", (data[i]["score_breakdown"]["red"]["autoCellsInner"])+(data[i]["score_breakdown"]["red"]["teleopCellsInner"])+(data[i]["score_breakdown"]["red"]["autoCellsOuter"])+(data[i]["score_breakdown"]["red"]["teleopCellsOuter"]),", ", data[i]["alliances"]["blue"]["team_keys"][0],", ", data[i]["alliances"]["blue"]["team_keys"][1],", ", data[i]["alliances"]["blue"]["team_keys"][2],", ", (data[i]["score_breakdown"]["blue"]["autoCellsInner"])+(data[i]["score_breakdown"]["blue"]["teleopCellsInner"])+(data[i]["score_breakdown"]["blue"]["autoCellsOuter"])+(data[i]["score_breakdown"]["blue"]["teleopCellsOuter"]),file = f1)
	f1.flush()


	with open('upper.txt') as csv_file:
		csv_reader = csv.reader(csv_file, delimiter=',')
		line_count = 0
		for row in csv_reader:
			if (len(row) == 0):
				break

			if ((row[3].strip() == "NULL") or (row[7].strip() == "NULL")):
				continue

			if (row[0].strip() not in teamList) and (row[0].strip() != "NULL"): 
				teamList.append(row[0].strip())
			
			if row[1].strip() not in teamList and (row[1].strip() != "NULL"): 
				teamList.append(row[1].strip())

			if row[2].strip() not in teamList and (row[2].strip() != "NULL"): 
				teamList.append(row[2].strip())
			
			if row[4].strip() not in teamList and (row[4].strip() != "NULL"): 
				teamList.append(row[4].strip())

			if row[5].strip() not in teamList and (row[5].strip() != "NULL"): 
				teamList.append(row[5].strip())
			
			if row[6].strip() not in teamList and (row[6].strip() != "NULL"): 
				teamList.append(row[6].strip())
			
			

			noOfGames += 1

	gameMatrix = [[0 for row in range(len(teamList))] for row in range(len(teamList))]
	scoreMatrix = [0 for row in range(len(teamList))]

	with open('upper.txt') as csv_file:
		csv_reader = csv.reader(csv_file, delimiter=',')
		line_count1 = 0
		gameIndex = 0
		for row in csv_reader:
			if (len(row) == 0):
				break
			
			if ((row[3].strip() == "NULL") or (row[7].strip() == "NULL")):
				continue
			
			if (row[0].strip() not in teamList):
				if (row[1].strip() not in teamList):
					if (row[2].strip() not in teamList):
						continue
					team3Index = teamList.index(row[2].strip())
					gameMatrix[team3Index][team3Index] += 1
					scoreMatrix[team3Index] += int(row[3].strip())
				elif (row[2].strip() not in teamList):
					if (row[1].strip() not in teamList):
						continue
					team2Index = teamList.index(row[1].strip())
					gameMatrix[team2Index][team2Index] += 1
					scoreMatrix[team2Index] += int(row[3].strip()) 
				else:
					team2Index = teamList.index(row[1].strip())
					team3Index = teamList.index(row[2].strip())
					gameMatrix[team2Index][team2Index] += 1
					gameMatrix[team3Index][team3Index] += 1
					gameMatrix[team2Index][team3Index] += 1
					gameMatrix[team3Index][team2Index] += 1
					scoreMatrix[team2Index] += int(row[3].strip())
					scoreMatrix[team3Index] += int(row[3].strip())
			elif (row[1].strip() not in teamList):
				if (row[2].strip() not in teamList):
					if (row[0].strip() not in teamList):
						continue
					team1Index = teamList.index(row[0].strip())
					gameMatrix[team1Index][team1Index] += 1
					scoreMatrix[team1Index] += int(row[3].strip())
				elif (row[0].strip() not in teamList):
					if (row[2].strip() not in teamList):
						continue
					team3Index = teamList.index(row[2].strip())
					gameMatrix[team3Index][team3Index] += 1
					scoreMatrix[team3Index] += int(row[3].strip())
				else:
					team1Index = teamList.index(row[0].strip())
					gameMatrix[team1Index][team1Index] += 1
					team3Index = teamList.index(row[2].strip())
					gameMatrix[team1Index][team3Index] += 1
					gameMatrix[team3Index][team1Index] += 1
					gameMatrix[team3Index][team3Index] += 1
					scoreMatrix[team1Index] += int(row[3].strip())
					scoreMatrix[team3Index] += int(row[3].strip())
			elif (row[2].strip() not in teamList):
				if (row[0].strip() not in teamList):
					if (row[1].strip() not in teamList):
						continue
					team2Index = teamList.index(row[1].strip())
					gameMatrix[team2Index][team2Index] += 1
					scoreMatrix[team2Index] += int(row[3].strip())
				elif (row[1].strip() not in teamList):
					if (row[0].strip() not in teamList):
						continue
					team1Index = teamList.index(row[0].strip())
					gameMatrix[team1Index][team1Index] += 1
					scoreMatrix[team1Index] += int(row[3].strip())
				else:
					team1Index = teamList.index(row[0].strip())
					gameMatrix[team1Index][team1Index] += 1
					team2Index = teamList.index(row[1].strip())
					gameMatrix[team1Index][team2Index] += 1
					gameMatrix[team2Index][team1Index] += 1
					gameMatrix[team2Index][team2Index] += 1
					scoreMatrix[team1Index] += int(row[3].strip())
					scoreMatrix[team2Index] += int(row[3].strip())
			else:
				team1Index = teamList.index(row[0].strip())
				gameMatrix[team1Index][team1Index] += 1
				team2Index = teamList.index(row[1].strip())
				gameMatrix[team1Index][team2Index] += 1
				gameMatrix[team2Index][team1Index] += 1
				gameMatrix[team2Index][team2Index] += 1
				team3Index = teamList.index(row[2].strip())
				gameMatrix[team2Index][team3Index] += 1
				gameMatrix[team3Index][team2Index] += 1
				gameMatrix[team1Index][team3Index] += 1
				gameMatrix[team3Index][team1Index] += 1
				gameMatrix[team3Index][team3Index] += 1
				scoreMatrix[team1Index] += int(row[3].strip())
				scoreMatrix[team2Index] += int(row[3].strip())
				scoreMatrix[team3Index] += int(row[3].strip())

			if (row[4].strip() not in teamList):
				if (row[5].strip() not in teamList):
					if (row[6].strip() not in teamList):
						continue
					team6Index = teamList.index(row[6].strip())
					gameMatrix[team6Index][team6Index] += 1
					scoreMatrix[team6Index] += int(row[7].strip())
				elif (row[6].strip() not in teamList):
					if (row[5].strip() not in teamList):
						continue
					team5Index = teamList.index(row[5].strip())
					gameMatrix[team5Index][team5Index] += 1
					scoreMatrix[team5Index] += int(row[7].strip())
				else:
					team5Index = teamList.index(row[5].strip())
					gameMatrix[team5Index][team5Index] += 1
					team6Index = teamList.index(row[6].strip())
					gameMatrix[team5Index][team6Index] += 1
					gameMatrix[team6Index][team5Index] += 1
					gameMatrix[team6Index][team6Index] += 1
					scoreMatrix[team5Index] += int(row[7].strip())
					scoreMatrix[team6Index] += int(row[7].strip())
			elif (row[5].strip() not in teamList):
				if (row[6].strip() not in teamList):
					if (row[4].strip() not in teamList):
						continue
					team4Index = teamList.index(row[4].strip())
					gameMatrix[team4Index][team1Index] += 1
					scoreMatrix[team4Index] += int(row[7].strip())
				elif (row[4].strip() not in teamList):
					if (row[6].strip() not in teamList):
						continue
					team6Index = teamList.index(row[6].strip())
					gameMatrix[team6Index][team6Index] += 1
					scoreMatrix[team6Index] += int(row[7].strip())
				else:
					team4Index = teamList.index(row[4].strip())
					gameMatrix[team4Index][team4Index] += 1
					team6Index = teamList.index(row[6].strip())
					gameMatrix[team4Index][team6Index] += 1
					gameMatrix[team6Index][team4Index] += 1
					gameMatrix[team6Index][team6Index] += 1
					scoreMatrix[team4Index] += int(row[7].strip())
					scoreMatrix[team6Index] += int(row[7].strip())
			elif (row[6].strip() not in teamList):
				if (row[4].strip() not in teamList):
					if (row[5].strip() not in teamList):
						continue
					team5Index = teamList.index(row[5].strip())
					gameMatrix[team5Index][team5Index] += 1
					scoreMatrix[team5Index] += int(row[7].strip())
				elif (row[5].strip() not in teamList):
					if (row[4].strip() not in teamList):
						continue
					team4Index = teamList.index(row[4].strip())
					gameMatrix[team4Index][team4Index] += 1
					scoreMatrix[team4Index] += int(row[7].strip())
				else:
					team4Index = teamList.index(row[4].strip())
					gameMatrix[team4Index][team4Index] += 1
					team5Index = teamList.index(row[5].strip())
					gameMatrix[team4Index][team5Index] += 1
					gameMatrix[team5Index][team4Index] += 1
					gameMatrix[team5Index][team5Index] += 1
					scoreMatrix[team4Index] += int(row[7].strip())
					scoreMatrix[team5Index] += int(row[7].strip())
			else:
				team4Index= teamList.index(row[4].strip())
				gameMatrix[team4Index][team4Index] += 1
				team5Index = teamList.index(row[5].strip())
				gameMatrix[team4Index][team5Index] += 1
				gameMatrix[team5Index][team4Index] += 1
				gameMatrix[team5Index][team5Index] += 1
				team6Index = teamList.index(row[6].strip())
				gameMatrix[team5Index][team6Index] += 1
				gameMatrix[team6Index][team5Index] += 1
				gameMatrix[team6Index][team6Index] += 1
				gameMatrix[team4Index][team6Index] += 1
				gameMatrix[team6Index][team4Index] += 1
				scoreMatrix[team4Index] += int(row[7].strip())
				scoreMatrix[team5Index] += int(row[7].strip())
				scoreMatrix[team6Index] += int(row[7].strip())

			gameIndex += 1
		
		
	a = np.array(gameMatrix)
	b = np.array(scoreMatrix)
	x = np.linalg.solve(a , b)

	list = []

	z = 0
	for z in range (len(teamList)):
		list.append(teamList[z], ", ", x[z])
		z += 1
	return (list)