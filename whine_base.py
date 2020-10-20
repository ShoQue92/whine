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

import datetime

#fles_1 = WhineBottle(	'vb1', 'generieke wijn', 	'merlot'		,2014)

recreate_table() #-- voor aanmaken nieuwe tabel (bij lege db)

#fles = RedWhine(	'vb1', 'Eerste test rode wijn', 'Shiraz',2018, 	['Shiraz', 'Merlot'])
fles = WhineBottle(	'vb2', 'Nog een tesyt rode wijn', 'Shiraz',2018, {'test_key': 'test_val', 'test_key2' : 'test_val2'})
add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.properties, datetime.datetime.now())
add_whine_property('vb2','nasmaak','vies')
add_whine_property('vb2','smaak','goed')

# fles scannen
#fetch_bottle("vb2")

#delete_selected("vb2")
#fetch_bottle("vb2")



#print(fles.properties)
uitvoer = fetch_bottle_properties('vb2')

print(uitvoer)