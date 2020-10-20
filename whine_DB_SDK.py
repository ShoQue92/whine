import sqlite3
from whine_classes import WhineBottle

# gebruiken we overal dus global
conn = sqlite3.connect('whine_inventory.db')
c = conn.cursor()

def create_table(drop):
    if drop == True:
        c.execute('DROP TABLE IF EXISTS whine_bottles')
        c.execute('DROP TABLE IF EXISTS bottle_properties')
    c.execute('CREATE TABLE IF NOT EXISTS whine_bottles (UID TEXT PRIMARY KEY, name TEXT, main_grape TEXT, year TEXT, date_in_fridge DATE)')
    c.execute('CREATE TABLE IF NOT EXISTS bottle_properties (property_id integer PRIMARY KEY AUTOINCREMENT, UID TEXT,  property TEXT, value TEXT)')
	
def recreate_table():
    create_table(True)

def add_whine(UID, name, main_grape, year, properties, date_in_fridge):
    c.execute("SELECT UID from bottle_properties where UID = '" + UID + "'")
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
            message = print("Succesfully inserted bottle "+UID+"\'s property "+property)
            return message

def fetch_all_results():
    c.execute('''SELECT UID, name, main_grape, year, date_in_fridge FROM whine_bottles ORDER BY date_in_fridge DESC''')
    data = c.fetchall()
    return data
	
def fetch_bottle(UID):
    print("Fetching bottle with UID="+UID)
    c.execute("SELECT name, main_grape, year, date_in_fridge FROM whine_bottles WHERE UID='"+UID+"'")
    data = c.fetchone()
    if data:
        bottle = {
            "name": data[0],
            "main_grape": data[1],
            "year": data[2],
            "date_in_fridge": data[3]
        }
        print("Bottle with UID '" + UID + "' found!")
        print("----------------------")
        print("Name: "+bottle["name"])
        print("Main Grape: "+bottle["main_grape"])
        print("Year: "+bottle["year"])
        print("Fridge Date: "+bottle["date_in_fridge"])
        print("----------------------")
        return bottle
    else:
        print("Bottle not found!")

def fetch_bottle_properties(UID):
    print("Fetching bottle with UID="+UID)
    c.execute("SELECT UID, property, value FROM bottle_properties WHERE UID='"+UID+"'")
    data = c.fetchone()
    if data:
        bottle = {
            "UID": data[0],
            "property": data[1],
            "value": data[2],
        }
        print("Bottle properties for bottle UID '" + UID + "' found!")
        print("----------------------")
        print("UID: "+bottle["UID"])
        print("Property: "+bottle["property"])
        print("Value: "+bottle["value"])
        print("----------------------")
        return bottle
    else:
        print("Bottle properties not found!")


def delete_selected(UID):
    c.execute("DELETE FROM whine_bottles WHERE UID='"+UID+"'")
    conn.commit()
    return print('Succes deleted bottle with UID' + UID) 

def clear_results():
    c.execute('''DELETE FROM whine_bottles ''')
    conn.commit()
    return print('Succes truncated table \'whine_bottles\'!')