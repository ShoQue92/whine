#Imports from whine_classes
from whine_classes import WhineBottle
from whine_classes import RedWhine
from whine_classes import WhiteWhine
from whine_classes import RoseWhine

#Imports from whine_db_SDK
from whine_DB_SDK import create_table
from whine_DB_SDK import add_whine
from whine_DB_SDK import fetch_results
from whine_DB_SDK import delete_selected
from whine_DB_SDK import clear_results

import datetime

fles_1 = WhineBottle(1, 'generieke wijn', 'merlot', 2014)
fles_2 = RedWhine(2, 'Test rode wijn', 'Shiraz', 2015, ['Shiraz', 'Merlot'])
fles_3 = WhiteWhine(3, 'Witte wijn','Chardonnay',2016,'D',['Chardonnay', 'Sauvignon Blanc'])
fles_4 = RoseWhine(4, 'Rose wijn', 'Semillion', 2017, 'S',['Semillion','Chardonnay'])

create_table()

add_whine(fles_2.ID, fles_2.name, fles_2.main_grape, fles_2.year, fles_2.list_grape_mix(), datetime.date.today())

print(delete_selected(2))
