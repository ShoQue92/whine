import sqlite3
import csv
import os
from whine_classes import WhineBottle

# gebruiken we overal dus global
conn = sqlite3.connect('whine_inventory.db')
c = conn.cursor()

################# Database gedeelte ###################

def create_table(drop):
    print("Tabellen \'whine_bottles\', \'bottle_properties\', \'base_properties\' en \'grapes\' worden aangemaakt...")
    if drop == True:
        c.execute('DROP TABLE IF EXISTS whine_bottles')
        c.execute('DROP TABLE IF EXISTS bottle_properties')
        c.execute('DROP TABLE IF EXISTS base_properties')
        c.execute('DROP TABLE IF EXISTS grapes')
    c.execute('CREATE TABLE IF NOT EXISTS whine_bottles (UID TEXT PRIMARY KEY, name TEXT, main_grape TEXT, year TEXT, date_in_fridge DATE)')
    c.execute('CREATE TABLE IF NOT EXISTS bottle_properties (property_id integer PRIMARY KEY AUTOINCREMENT, UID TEXT,  property TEXT, value TEXT)')
    c.execute('CREATE TABLE IF NOT EXISTS base_properties (id integer PRIMARY KEY AUTOINCREMENT, property TEXT)')
    c.execute('CREATE TABLE IF NOT EXISTS grapes (id integer PRIMARY KEY AUTOINCREMENT, grape TEXT)')
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

################# Einde Database gedeelte ###################

################# Toevoegen ###################

def add_whine(UID, name, main_grape, year, properties, date_in_fridge):
    c.execute("SELECT UID from whine_bottles where UID = '" + UID + "'")
    data = c.fetchone()
    if data:
        # regel is al gevonden, dus niet opnieuw inserten
        message = print("Fles met tag " + UID + " bestaat al, dus inserten gaat niet door.")
    else:
        c.execute('INSERT INTO whine_bottles (UID, name, main_grape, year, date_in_fridge) VALUES (?, ?, ?, ?, ?)', (UID, name, main_grape, year, date_in_fridge))
        conn.commit()
        #Add bottle properties
        #add_whine_properties(UID, properties)
        message = print('Succesfully inserted new bottle!')
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
            message = print("Verwerking fles "+UID+"\'s eigenschap "+property+" succesfol!")
            return message

################# Einde toevoegen  ###################
 
################# Aanvullen  ###################

def update_whine(UID, name, main_grape, year):
    c.execute("UPDATE whine_bottles SET name = '"+name+"',main_grape = '"+main_grape+"',year = '"+year+"' WHERE UID='"+UID+"'")
    conn.commit()
    message = print('Succesfully updated bottle '+UID)
    return message

################# Einde anvullen  ###################

################# Ophalen database ###################

def export_bottle_properties_csv(tgt_file,tgt_dir):
    print("Fetching all botles in database")
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

def fetch_bottle(UID):
    print("Fetching bottle with UID="+UID)
    c.execute("SELECT UID, name, main_grape, year, date_in_fridge FROM whine_bottles WHERE UID='"+UID+"'")
    data = c.fetchone()
    no_bottle = None
    if data:
        bottle = {
            'UID': data[0],
            "name": data[1],
            "main_grape": data[2],
            "year": data[3],
            "date_in_fridge": data[4]
        }
        print("Bottle with UID '" + UID + "' found!")
        print("----------------------")
        print("UID: "+bottle["UID"])
        print("Name: "+bottle["name"])
        print("Main Grape: "+bottle["main_grape"])
        print("Year: "+bottle["year"])
        print("Fridge Date: "+bottle["date_in_fridge"])
        print("----------------------")
        return bottle
    else:
        print("Bottle not found!")
        return no_bottle

def fetch_bottle_properties(UID):
    print("Fetching bottle with UID="+UID)
    c.execute("SELECT UID, property, value FROM bottle_properties WHERE UID='"+UID+"' order by property")
    headers = list(map(lambda x: x[0], c.description))
    data = c.fetchall()
    if data:
        print("Bottle properties for bottle UID '" + UID + "' found!")
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
        print("Bottle properties not found!")

################# Einde Ophalen database ###################

################# Verwijderen uit database ###################

def delete_selected(UID):
    c.execute("DELETE FROM whine_bottles WHERE UID='"+UID+"'")
    conn.commit()
    return print('Succes deleted bottle with UID' + UID) 

def clear_results():
    c.execute('''DELETE FROM whine_bottles ''')
    conn.commit()
    return print('Succes truncated table \'whine_bottles\'!')

################# Einde Verwijderen uit database ##############