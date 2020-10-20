#Imports from whine_classes
from whine_classes import WhineBottle

#Imports from whine_db_SDK
from whine_DB_SDK import create_table
from whine_DB_SDK import recreate_table
from whine_DB_SDK import add_whine
from whine_DB_SDK import add_whine_property
from whine_DB_SDK import fetch_bottle
from whine_DB_SDK import fetch_bottle_properties
from whine_DB_SDK import delete_selected
from whine_DB_SDK import clear_results

#Other imports
import datetime
import os
import shutil
import csv
import sys

#global variables
tgt_dir = r"G:\\Onedrive\\GIT\\Whine\\workdir"
tgt_file = "nieuwefile.csv"
os.chdir(tgt_dir)

def create_tgt_file(tgt_file,data):
    with open(tgt_file, 'w+', newline='') as csv_file:  
        writer = csv.writer(csv_file)
        writer.writerow(csv_header)
        writer.writerow(data.values())

recreate_table() #-- voor aanmaken nieuwe tabel (bij lege db)

#Twee test flessen toevoegen.
fles = WhineBottle('vb1', '', '', '', '')
fles2 = WhineBottle('vb2', '', '', '', '')
add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.properties, datetime.datetime.now())
add_whine(fles2.UID, fles2.name, fles2.main_grape, fles2.year, fles2.properties, datetime.datetime.now())

#Properties voor een fles toevoegen
#add_whine_property('vb1','nasmaak','vies')
#add_whine_property('vb1','smaak','goed')
#add_whine_property('vb2','nasmaak','vies')
#add_whine_property('vb2','smaak','goed')

# fles scannen
#fetch_bottle("vb2")

#delete_selected("vb2")
#fetch_bottle("vb2")



#print(fles.properties)
uitvoer = fetch_bottle('vb2')

#fetch the header for the csv file based on the keys of the dict
csv_header = uitvoer.keys()

create_tgt_file(tgt_file,uitvoer)