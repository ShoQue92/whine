#Imports from whine_classes
from whine_classes import WhineBottle
#Imports from whine_db_SDK
from whine_DB_SDK import create_table
from whine_DB_SDK import recreate_table
from whine_DB_SDK import add_whine
from whine_DB_SDK import add_whine_property
from whine_DB_SDK import fetch_bottle
from whine_DB_SDK import fetch_bottle_init_file
from whine_DB_SDK import fetch_bottle_properties
from whine_DB_SDK import delete_selected
from whine_DB_SDK import clear_results
from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottle_properties_csv
from whine_DB_SDK import check_bottle_existance

#Other imports
import datetime
import csv
import os

#global variables
tgt_dir = os.getcwd()
tgt_file = False

def create_init_file(tgt_file,tgt_dir,bottle):
    data=fetch_bottle_init_file(bottle)
    os.chdir(tgt_dir)
    data['status'] = 'registered'
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

def process_return_file(tgt_file, tgt_dir):
    os.chdir(tgt_dir)
    with open(tgt_file, 'r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        next(csv_reader)
        for line in csv_reader:
            UID = line[0]
            name = line[1]
            main_grape = line[2]
            year = line[3]
            type = line[4]
            update_whine(UID, name, main_grape, year, type)
            return print(UID, name, main_grape, year, type)

def process_bottle_property_return_file(prop_file, tgt_dir):
    os.chdir(tgt_dir)
    with open(prop_file, 'r') as csv_file:
        csv_reader = csv.reader(csv_file, delimiter=';')
        next(csv_reader)
        for line in csv_reader:
            UID = line[0]
            property = line[1]
            value = line[2]
            add_whine_property(UID, property, value)