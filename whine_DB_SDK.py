import sqlite3
from whine_classes import WhineBottle


def create_table():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('CREATE TABLE IF NOT EXISTS whine_bottles (UID TEXT PRIMARY KEY, name TEXT, main_grape TEXT, year TEXT, date_in_fridge DATE)')
    c.execute('CREATE TABLE IF NOT EXISTS bottle_properties (UID TEXT PRIMARY KEY, property TEXT, value TEXT)')
	
def recreate_table():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('DROP TABLE IF EXISTS whine_bottles')
    c.execute('DROP TABLE IF EXISTS bottle_properties')
    create_table()

def add_whine(UID, name, main_grape, year, properties, date_in_fridge):
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('INSERT INTO whine_bottles (UID, name, main_grape, year, date_in_fridge) VALUES (?, ?, ?, ?, ?)', (UID, name, main_grape, year, date_in_fridge))
    conn.commit()
    #Add bottle properties
    add_whine_properties(UID, properties)
    message = print('Succesfully inserted new bottle!')
    return message

def add_whine_properties(UID, properties):
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    if properties:
        for key, val in properties.items(): #<--- dit krijg ik nog niet werkend. Ik wil de value van de dict wil ik gabruiken in de query. Als ik properties[val] doe krijg ik een key error.
            c.execute('INSERT INTO bottle_properties (UID, property, value) VALUES (?, ?, ?)', (UID, properties[key], properties[key]))
            conn.commit()
            message = print("Succesfully inserted bottle "+UID+"\'s properties")
            return message

def fetch_all_results():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('''SELECT UID, name, main_grape, year, date_in_fridge FROM whine_bottles ORDER BY date_in_fridge DESC''')
    data = c.fetchall()
    return data
	
def fetch_bottle(UID):
    print("Fetching bottle with UID="+UID)
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
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

def delete_selected(UID):
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute("DELETE FROM whine_bottles WHERE UID='"+UID+"'")
    conn.commit()
    return print('Succes deleted bottle with UID' + UID) 

def clear_results():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('''DELETE FROM whine_bottles ''')
    conn.commit()
    return print('Succes truncated table \'whine_bottles\'!')