#Imports for SPI communications with RPi
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522

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
from whine_DB_SDK import export_bottle_properties_csv
from whine_DB_SDK import check_bottle_existance

#Other imports
import datetime
import time

reader = SimpleMFRC522()
print('RFID lezer actief, plaats een tag voor de lezer...'.center(100,'='))
time.sleep(1)
try:
        id, text = reader.read()
        fles = WhineBottle(str(id), '', '', '', '')
        if check_bottle_existance(fles.UID):
                fetch_bottle(fles.UID)
                print('EINDE data opgehaald.'.center(100,'='))
        else:
                add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.properties, datetime.datetime.now())
                print('EINDE fles toegevoegd.'.center(100,'='))
finally:
        GPIO.cleanup()

