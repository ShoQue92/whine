from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottle_properties_csv
from whine_DB_SDK import clear_results
from whine_base import process_return_file
from whine_base import process_bottle_property_return_file
from sys import argv

'''
Interface scriptje tussen web front-end en de back-end.
Dit scriptje kan gebruikt worden door php om bepaalde acties uit te voeren tegen de back-end.

Toepassing is;
front_end_actions.py <actie*> <file> <dir>

Input argument <actie> is veprlicht, file & dir zijn optioneel, maar wel verplicht voor een aantal acties.
'''

if argv[1] == "clear_db":
       clear_results()
elif argv[1] == 'process_bottle':
      process_return_file(argv[2], argv[3]) 
elif argv[1] == "export_bottle_properties":
       export_bottle_properties_csv(argv[2], argv[3]) 
elif argv[1] == "process_bottle_properties":
       process_bottle_property_return_file(argv[2], argv[3])
else:
      print('Geen juiste actie opgegeven!')