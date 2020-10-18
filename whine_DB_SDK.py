import sqlite3
from whine_classes import WhineBottle
from whine_classes import RedWhine
from whine_classes import WhiteWhine
from whine_classes import RoseWhine

def create_table():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('CREATE TABLE IF NOT EXISTS whine_bottles (UID TEXT PRIMARY KEY, name TEXT, main_grape TEXT, year TEXT, grape_mix TEXT, date_in_fridge DATE)')
	
def recreate_table():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('DROP TABLE IF EXISTS whine_bottles')
    create_table()

def add_whine(UID, name, main_grape, year, grape_mix, date_in_fridge):
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('INSERT INTO whine_bottles (UID, name, main_grape, year, grape_mix, date_in_fridge) VALUES (?, ?, ?, ?, ?, ?)', (UID, name, main_grape, year, grape_mix, date_in_fridge))
    conn.commit()
    message = print('Succesfully inserted!')
    return message

def fetch_all_results():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('''SELECT ID, name, main_grape, year, grape_mix, date_in_fridge FROM whine_bottles ORDER BY date_in_fridge DESC''')
    data = c.fetchall()
    return data
	
def fetch_bottle(UID):
    print("Fetching bottle with UID="+UID)
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute("SELECT name, main_grape, year, grape_mix, date_in_fridge FROM whine_bottles WHERE UID='"+UID+"'")
    data = c.fetchone()
    if data:
        bottle = {
            "name": data[0],
            "main_grape": data[1],
            "year": data[2],
            "grape_mix": data[3],
            "date_in_fridge": data[4]
        }
        print("Bottle with UID '" + UID + "' found!")
        print("----------------------")
        print("Name: "+bottle["name"])
        print("Main Grape: "+bottle["main_grape"])
        print("Grape Mix: "+bottle["grape_mix"])
        print("Year: "+bottle["year"])
        print("Fridge Date: "+bottle["date_in_fridge"])
        print("----------------------")
        return bottle
    else:
        print("Bottle not found!")

def delete_selected(ID):
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('''DELETE FROM whine_bottles WHERE ID = 2 ''')
    conn.commit()
    return print('Succes deleted bottle!') 

def clear_results():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('''DELETE FROM whine_bottles ''')
    conn.commit()
    return print('Succes truncated table \'whine_bottles\'!')