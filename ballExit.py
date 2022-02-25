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
	
	for i in range (0, length):
		lowerBlue = int(data[i]["score_breakdown"]["blue"]["autoCargoLowerBlue"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoLowerBlue"])+int(data[i]["score_breakdown"]["red"]["autoCargoLowerBlue"])+int(data[i]["score_breakdown"]["red"]["teleopCargoLowerBlue"])
		lowerFar = int(data[i]["score_breakdown"]["blue"]["autoCargoLowerFar"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoLowerFar"])+int(data[i]["score_breakdown"]["red"]["autoCargoLowerFar"])+int(data[i]["score_breakdown"]["red"]["teleopCargoLowerFar"])
		lowerNear = int(data[i]["score_breakdown"]["blue"]["autoCargoLowerNear"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoLowerNear"])+int(data[i]["score_breakdown"]["red"]["autoCargoLowerNear"])+int(data[i]["score_breakdown"]["red"]["teleopCargoLowerNear"])
		lowerRed = int(data[i]["score_breakdown"]["blue"]["autoCargoLowerRed"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoLowerRed"])+int(data[i]["score_breakdown"]["red"]["autoCargoLowerRed"])+int(data[i]["score_breakdown"]["red"]["teleopCargoLowerRed"])
		upperBlue = int(data[i]["score_breakdown"]["blue"]["autoCargoUpperBlue"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoUpperBlue"])+int(data[i]["score_breakdown"]["red"]["autoCargoUpperBlue"])+int(data[i]["score_breakdown"]["red"]["teleopCargoUpperBlue"])
		upperFar = int(data[i]["score_breakdown"]["blue"]["autoCargoUpperFar"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoUpperFar"])+int(data[i]["score_breakdown"]["red"]["autoCargoUpperFar"])+int(data[i]["score_breakdown"]["red"]["teleopCargoUpperFar"])
		upperNear = int(data[i]["score_breakdown"]["blue"]["autoCargoUpperNear"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoUpperNear"])+int(data[i]["score_breakdown"]["red"]["autoCargoUpperNear"])+int(data[i]["score_breakdown"]["red"]["teleopCargoUpperNear"])
		upperRed = int(data[i]["score_breakdown"]["blue"]["autoCargoUpperRed"])+int(data[i]["score_breakdown"]["blue"]["teleopCargoUpperRed"])+int(data[i]["score_breakdown"]["red"]["autoCargoUpperRed"])+int(data[i]["score_breakdown"]["red"]["teleopCargoUpperRed"])

	lowerTotal = lowerBlue + lowerFar + lowerNear + lowerRed
	upperTotal = upperBlue + upperFar + upperNear + upperRed

	return ("Lower Blue Percentage: " + (lowerBlue/lowerTotal) + ", " + "Lower Far Percentage: " + (lowerFar/lowerTotal) + ", " + "Lower Near Percentage: " + (lowerNear/lowerTotal) + ", " + "Lower Red Percentage: " + (lowerRed/lowerTotal) + "                   " + "Upper Blue Percentage: " + (upperBlue/upperTotal) + ", " + "Upper Far Percentage: " + (upperFar/upperTotal) + ", " + "Upper Near Percentage: " + (upperNear/upperTotal) + ", " + "Upper Red Percentage: " + (upperRed/upperTotal))
