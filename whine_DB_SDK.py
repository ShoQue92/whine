import sqlite3
from whine_classes import WhineBottle
from whine_classes import RedWhine
from whine_classes import WhiteWhine
from whine_classes import RoseWhine


def create_table():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('CREATE TABLE IF NOT EXISTS whine_bottles (ID INTEGER, name TEXT, main_grape TEXT, year TEXT, grape_mix TEXT, date_in_fridge DATE)')

def add_whine(ID, name, main_grape, year, grape_mix, date_in_fridge):
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('INSERT INTO whine_bottles (ID, name, main_grape, year, grape_mix, date_in_fridge) VALUES (?, ?, ?, ?, ?, ?)', (ID, name, main_grape, year, grape_mix, date_in_fridge))
    conn.commit()
    message = print('Succesfully inserted!')
    return message

def fetch_results():
    conn = sqlite3.connect('whine_inventory.db')
    c = conn.cursor()
    c.execute('''SELECT ID, name, main_grape, year, grape_mix, date_in_fridge FROM whine_bottles ORDER BY date_in_fridge DESC''')
    data = c.fetchall()
    return data

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