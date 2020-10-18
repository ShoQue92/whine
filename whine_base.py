#Imports from whine_classes
from whine_classes import WhineBottle
from whine_classes import RedWhine
from whine_classes import WhiteWhine
from whine_classes import RoseWhine

#Imports from whine_db_SDK
from whine_DB_SDK import create_table
from whine_DB_SDK import recreate_table
from whine_DB_SDK import add_whine
from whine_DB_SDK import fetch_all_results
from whine_DB_SDK import fetch_bottle
from whine_DB_SDK import delete_selected
from whine_DB_SDK import clear_results

import datetime

#fles_1 = WhineBottle(	'vb1', 'generieke wijn', 	'merlot'		,2014)
#fles_2 = RedWhine(		'vb2', 'Test rode wijn', 	'Shiraz'		,2015, 	['Shiraz', 'Merlot'])
#fles_3 = WhiteWhine(	'vb3', 'Witte wijn',		'Chardonnay'	,2016,	'D'						,['Chardonnay', 'Sauvignon Blanc'])
#fles_4 = RoseWhine(		'vb4', 'Rose wijn', 		'Semillion'		,2017, 	'S'						,['Semillion','Chardonnay'])

#recreate_table() #-- voor testen aanmaken nieuwe db

recreate_table() #-- voor aanmaken nieuwe tabel (bij lege db)

fles = RedWhine(		'vb1', 'Eerste test rode wijn', 	'Shiraz'		,2018, 	['Shiraz', 'Merlot'])
#fles = RedWhine(		'vb2', 'Nog een test rode wijn', 	'Shiraz'		,2018, 	['Shiraz', 'Merlot'])
add_whine(fles.UID, fles.name, fles.main_grape, fles.year, fles.list_grape_mix(), datetime.date.today())

# fles scannen
#fetch_bottle("vb1")

delete_selected("vb1")

fetch_bottle("vb1")