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
from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottles_csv

#Other imports
import datetime
import csv
import os

#global variables
tgt_dir = r"G:\\Onedrive\\GIT\\Whine\\workdir"
tgt_file = "nieuwefile.csv"
os.chdir(tgt_dir)

def create_init_file(tgt_file,bottle):
    data=fetch_bottle(bottle)
    data['status'] = 'init'
    if data:
        try:
            with open(tgt_file, 'w+', newline='') as csv_file:
                #fetch the header for the csv file based on the keys of the dict
                csv_header = data.keys()  
                writer = csv.writer(csv_file, delimiter=';')
                writer.writerow(csv_header)
                writer.writerow(data.values())
                #Remove last line, since it is blank
                csv_file.seek(0, os.SEEK_END)
                csv_file.seek(csv_file.tell()-2, os.SEEK_SET)
                csv_file.truncate()
            return print(tgt_file+ " succesvol aangemaakt op "+tgt_dir)
        except IOError:
            print("Kon bestand " +tgt_file+ "niet aanmaken...")
    else:
        return print('Fles bestaat niet!')

def process_return_file(tgt_file):
    with open(tgt_file, 'r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        next(csv_reader)
        for line in csv_reader:
            UID = line[0]
            name = line[1]
            main_grape = line[2]
            year = line[3]
            update_whine(UID, name, main_grape, year)

#recreate_table() #-- voor aanmaken nieuwe tabel (bij lege db)

#Twee test flessen toevoegen.
#fles = WhineBottle('vb1', '', '', '', '')
#fles2 = WhineBottle('vb2', '', '', '', '')
#add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.properties, datetime.datetime.now())
#add_whine(fles2.UID, fles2.name, fles2.main_grape, fles2.year, fles2.properties, datetime.datetime.now())

#Properties voor een fles toevoegen
#add_whine_property('vb1','nasmaak','vies')
#add_whine_property('vb1','smaak','goed')
#add_whine_property('vb2','nasmaak','vies')
#add_whine_property('vb2','smaak','goed')
#fetch_bottle_properties('vb1')
# fles scannen
#fetch_bottle("vb1")

#delete_selected("vb2")
#fetch_bottle("vb2")

#print(fles.properties)

#aanmaken csv bestand
#create_init_file(tgt_file,'vb1')
#process_return_file(tgt_file)

export_bottles_csv('export.csv',tgt_dir)

