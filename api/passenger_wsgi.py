import sys
import json
import urllib
import os

sys.path.insert(0, os.path.dirname(__file__))

import upperOPRCalculator
import OPRCalculator

def application(environ, start_response): 
    arguments = urllib.parse.parse_qs(environ['QUERY_STRING'])
    
    response = json.dumps({})
    
    if arguments["type"] == "upperOPR":
        response = json.dumps(upperOPRCalculator.main(arguments["key"]))
    elif arguments["type"] == "OPR":
        response = json.dumps(OPRCalculator.main(arguments["key"]))
    
    start_response('200 OK', [('Content-Type', 'text/plain')])
    return [response.encode()]
