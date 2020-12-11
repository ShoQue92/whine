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
from whine_base import create_init_file

#Other imports
import datetime
import time
"""
Functie voor het lezen van RFID tags.
Wanneer een tag gescand wordt, wordt gekeken of deze reeds bestaat.
Als dit het geval is, wordt de UID van de fles getoond.
Wanneer het een nieuwe fles betreft, wordt deze aangemaakt en wordt een interface bestand gemaakt (CSV) die gebruikt kan worden door het front-end systeem om uit te lezen en te updaten met aangevulde data.
Een aangevuld bestand kan worden 'verwekrt' door frond_end_actions.py aan te roepen met als actie 'process_bottle'.
"""
def read_rfid():
        tgt_file = "intf_init_bottle_"
        tgt_dir = "/var/www/html/interface_files"

        reader = SimpleMFRC522()
        print('RFID lezer actief, plaats een tag voor de lezer...'.center(100,'='))
        time.sleep(1)

        try:
                id, text = reader.read()
                fles = WhineBottle(str(id), '', '', '', '')
                #Als de gescande tag reeds bestaat, laat de data zien, anders een nieuwe toevoegen.
                if check_bottle_existance(fles.UID):
                        fetch_bottle(fles.UID)
                        print('EINDE data opgehaald.'.center(100,'='))
                        read_rfid()
                else:
                        add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.properties, datetime.datetime.now())
                        #Maak een interface bestand aan voor het front-end systeem.
                        print("Interface bestand {} wordt aangemaakt op locatie {}".format(tgt_file, tgt_dir))
                        create_init_file(tgt_file+fles.UID+'.csv', tgt_dir, fles.UID)
                        print('EINDE fles toegevoegd.'.center(100,'='))
                        #Roep de functie weer opnieuw aan om het lezen van een nieuwe tag weer mogelijk te maken.
                        read_rfid()
        finally:
                GPIO.cleanup()

read_rfid()