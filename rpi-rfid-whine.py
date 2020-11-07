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

reader = SimpleMFRC522()
print('RFID lezer actief, plaats een tag voor de lezer...'.center(100,'='))
try:
        id, text = reader.read()
        print(id)
        print(text)
        fles = WhineBottle(str(id), '', '', '', '')
        if check_bottle_existance(fles.UID):
                fetch_bottle(fles.UID)
        else:
                add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.properties, datetime.datetime.now())
finally:
        GPIO.cleanup()

