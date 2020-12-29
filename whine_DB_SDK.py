import sqlite3
import csv
import os
import time
import traceback
import sys
from whine_classes import WhineBottle
import json

from os.path import join, dirname
from dotenv import load_dotenv

dotenv_path = join(dirname(__file__), '.env')
load_dotenv(dotenv_path)

# gebruiken we overal dus global
db_path =  os.environ.get("DB_PATH")
db_name =  os.environ.get("DB_NAME")

conn = sqlite3.connect(db_path + db_name)
c = conn.cursor()
################# Database gedeelte ###################

def create_table(drop):
    print("Tabellen \'whine_bottles\', \'bottle_properties\', \'base_properties\', \'base_rating\', \'temp_measures\' en \'grapes\' worden aangemaakt...")
    if drop == True:
        c.execute('DROP TABLE IF EXISTS whine_bottles')
        c.execute('DROP TABLE IF EXISTS whine_rating')
        c.execute('DROP TABLE IF EXISTS bottle_properties')
        c.execute('DROP TABLE IF EXISTS base_properties')
        c.execute('DROP TABLE IF EXISTS grapes')
        c.execute('DROP TABLE IF EXISTS temp_measures')
    c.execute('CREATE TABLE IF NOT EXISTS whine_bottles (UID TEXT PRIMARY KEY, name TEXT, main_grape TEXT, year TEXT, type TEXT, date_in_fridge DATE)')
    c.execute('CREATE TABLE IF NOT EXISTS whine_rating (id INTEGER PRIMARY KEY AUTOINCREMENT, UID TEXT , name TEXT, rating INTEGER,  date_rating DATE)')
    c.execute('CREATE TABLE IF NOT EXISTS bottle_properties (property_id INTEGER PRIMARY KEY AUTOINCREMENT, UID TEXT,  property TEXT, value TEXT)')
    c.execute('CREATE TABLE IF NOT EXISTS base_properties (id INTEGER PRIMARY KEY AUTOINCREMENT, property TEXT)')
    c.execute('CREATE TABLE IF NOT EXISTS grapes (id INTEGER PRIMARY KEY AUTOINCREMENT, grape TEXT)')
    c.execute('CREATE TABLE IF NOT EXISTS temp_measures (id INTEGER PRIMARY KEY AUTOINCREMENT, timestamp DATETIME, temperature_c INTEGER, temperature_f INTEGER)')
    insert_base_records()
    print("Tabellen zijn opnieuw aangemaakt...")
def recreate_table():
    create_table(True)

def insert_base_records():
    properties = ['Origin', 'Sweetness', 'Acidity', 'Tannin', 'Fruit', 'Body']
    for property in properties: 
        c.execute('INSERT INTO base_properties (property) VALUES (?)', (property,))
    print("Verwerken basis wijneigenschappen...")
    grapes = ['Albarino', 'Barbera', 'Barolo' ,'Brunello di Montalcino' ,'Cabernet Franc' ,'Cabernet Sauvignon' ,'Chardonnay' ,'Chenin Blanc' ,'Cinsault' \
             ,'Corvina', 'Gewurztraminer' ,'Godello', 'Grenache' ,'Grüner Veltliner' , 'Malbec' ,'Mencia' ,'Merlot' ,'Molinara' , 'Mourvedre' ,'Muscat' \
             ,'Nero d\'Avola' ,'Nebbiolo' ,'Petit Verdot' ,'Pinot Blanc' ,'Pinot Grigio' ,'Pinot Noir' ,'Primitivo' ,'Riesling' ,'Rondinella' ,'Sancerre' \
             ,'Sangiovese' ,'Sauvignon Blanc' ,'Sémillon' ,'Syrah-Shiraz' ,'Tempranillo', 'Verdejo', 'Viognier', 'Zweigelt', 'Nerello', 'Mascalese']
    print("Basis wijneigenschappen verwerkt...")
    print("Verwerken basis druivenset...")
    for grape in grapes: 
        c.execute('INSERT INTO grapes (grape) VALUES (?)', (grape,))
        conn.commit()
    print("Basis druivenset verwerkt...")
    print("Inserten dummy temp_measure record")
    c.execute("INSERT into temp_measures (timestamp, temperature_c, temperature_f) VALUES (CURRENT_TIMESTAMP, 10, 47.3)")
    conn.commit()


################# Einde Database gedeelte ###################

################# Toevoegen ###################

def add_whine(UID, name, main_grape, year, type, properties, date_in_fridge):
    c.execute("SELECT UID from whine_bottles where UID = '" + UID + "'")
    data = c.fetchone()
    if data:
        # regel is al gevonden, dus niet opnieuw inserten
        message = print("Fles met tag " + UID + " bestaat al, dus inserten gaat niet door.")
    else:
        c.execute('INSERT INTO whine_bottles (UID, name, main_grape, year, type, date_in_fridge) VALUES (?, ?, ?, ?, ?, ?)', (UID, name, main_grape, year, type, date_in_fridge))
        conn.commit()
        #Add bottle properties
        #add_whine_properties(UID, properties)
        message = print('Fles {} succesvol toegevoegd op {}'.format(UID,date_in_fridge))
        return message

def add_whine_property(UID, property, value):
    if property is not None and value is not None:
        c.execute("SELECT property from bottle_properties where property = '"+property+"'")
        data = c.fetchone()
        if data:
            # regel is al gevonden, dus niet opnieuw inserten
            message = print("Eigenschap " + property + " bestaat al voor deze fles, dus inserten gaat niet door.")
        else:
            c.execute('INSERT INTO bottle_properties (UID, property, value) VALUES (?, ?, ?)', (UID, property, value))
            conn.commit()
            message = print("Verwerking fles "+UID+"\'s eigenschap "+property+" met succes!")
            return message

def log_temp(temp_c, temp_f, now):
    if temp_c is not None and temp_f is not None:
        c.execute("INSERT into temp_measures (timestamp, temperature_c, temperature_f) VALUES (CURRENT_TIMESTAMP, ?, ?)", (temp_c, temp_f))
        conn.commit()
        message = print("Temperatuurmeting op:", now, 'Celsius:', temp_c, 'Fahrenheit:', temp_f)
        return message

################# Einde toevoegen  ###################
 
################# Aanvullen  ###################

def update_whine(UID, name, main_grape, year, type):
    try:
        c.execute("UPDATE whine_bottles SET name = '"+name+"',main_grape = '"+main_grape+"',year = '"+year+"',type = '"+type+"' WHERE UID='"+UID+"'")
        conn.commit()
        message = print('Succesfully updated bottle; '+UID)
        return message
    except sqlite3.Error as er:
        print('SQLite error: %s' % (' '.join(er.args)))
        print("Exception class is: ", er.__class__)
        print('SQLite traceback: ')
        exc_type, exc_value, exc_tb = sys.exc_info()
        print(traceback.format_exception(exc_type, exc_value, exc_tb))

################# Einde anvullen  ###################

################# Ophalen database ###################

def export_bottle_properties_csv(tgt_file,tgt_dir):
    print("Alle flessen worden opgehaald!")
    c.execute("SELECT UID, property, value FROM bottle_properties")
    data = c.fetchall()
    try:
        with open(tgt_file, 'w+', newline='') as csv_file:
            writer = csv.writer(csv_file, delimiter=';')
            for i in range(0, len(data)):
                writer.writerow(data[i])
            #Remove last line, since it is blank
            csv_file.seek(0, os.SEEK_END)
            csv_file.seek(csv_file.tell()-2, os.SEEK_SET)
            csv_file.truncate()
            return print(tgt_file+ " succesvol aangemaakt op "+tgt_dir)
    except IOError:
            print("Kon bestand " +tgt_file+ "niet aanmaken...")

def check_bottle_existance(UID):
    time.sleep(0.5)
    message = "Er wordt gekeken of fles {} reeds bestaat".format(UID)
    print(message)
    c.execute("SELECT UID, name, main_grape, year, type, date_in_fridge FROM whine_bottles WHERE UID='"+UID+"'")
    data = c.fetchone()
    if data:
        return True
    else:
        return False

def fetch_bottle(UID):
    c.execute("SELECT UID, name, main_grape, year, type, date_in_fridge FROM whine_bottles WHERE UID='"+UID+"'")
    data = c.fetchone()
    time.sleep(1)
    if data:
        bottle = {
            'UID': data[0],
            "name": data[1],
            "main_grape": data[2],
            "year": data[3],
            "type": data[4],
            "date_in_fridge": data[5]
        }
        print("Fles met UID {} is gevonden!".format(UID))
        print("----------------------")
        print("UID: "+bottle["UID"])
        print("Name: "+bottle["name"])
        print("Main Grape: "+bottle["main_grape"])
        print("Year: "+bottle["year"])
        print("Type wijn: "+bottle["type"])
        print("Fridge Date: "+bottle["date_in_fridge"])
        print("----------------------")
        return bottle
    else:
        print("Fles niet gevonden!")

def fetch_bottle_properties(UID):
    print("De eigenschappen van fles {} worden opgehaald".format(UID))
    c.execute("SELECT UID, property, value FROM bottle_properties WHERE UID='"+UID+"' order by property")
    headers = list(map(lambda x: x[0], c.description))
    data = c.fetchall()
    if data:
        print("Eigenschappen voor fles {} gevonden!".format(UID))
        print("----------------------")
        datalist = []
        propertynum=1
        for row in data:
            rowdict = dict(zip(headers,row))
            datalist.append(rowdict)
            if propertynum > 1:
                print("----------------------")
            print("Property regel "+str(propertynum))
            print("UID: "+rowdict['UID'])
            print("Property: "+rowdict['property'])
            print("Value: "+rowdict['value'])
            propertynum += 1
        print("----------------------")
        return datalist
    else:
        print("Fles eigenschappen niet gevonden!")

def fetch_latest_temp_measures(c_or_f = "c", raw=True):
    c.execute("SELECT timestamp, temperature_f, temperature_c FROM temp_measures WHERE timestamp >= (SELECT MAX(timestamp) FROM temp_measures)")
    data = c.fetchone()
    if data:
        temps = {
            "timestamp": data[0],
            "fahrenheit": data[1],
            "celsius": data[2]
        }
        return print(json.dumps(temps))
        
    else:
        print('..Geen temperatuur meting beschikbaar..'.center(100,'='))

def fetch_avg_temp(UID):
    c.execute("SELECT avg(temperature_f), avg(temperature_c) FROM temp_measures WHERE timestamp >= (SELECT date_in_fridge FROM whine_bottles WHERE UID = '"+UID+"')")
    data = c.fetchone()
    if data:
        avg_temp = {
            "Fles": UID,
            "Average temp celcius": data[0],
            "Average temp fahrenheit": data[1]
        }
        return print(avg_temp)

################# Einde Ophalen database ###################

################# Verwijderen uit database ###################

def delete_selected(UID):
    c.execute("DELETE FROM whine_bottles WHERE UID='"+UID+"'")
    c.execute("DELETE FROM bottle_properties WHERE UID='"+UID+"'")
    conn.commit()
    return print('Fles {} is succesvol verwijderd'.format(UID))

def clear_results():
    c.execute('''DELETE FROM whine_bottles ''')
    c.execute('''DELETE FROM bottle_properties ''')
    conn.commit()
    return print('Tabel \'whine_bottles\' & \'bottle_properties\' succesvol geleegd!')

################# Einde Verwijderen uit database ##############