from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottle_properties_csv
from whine_DB_SDK import clear_results
from whine_DB_SDK import recreate_table
from whine_base import process_return_file
from whine_base import process_bottle_property_return_file
from sys import argv

'''
Interface scriptje tussen web front-end en de back-end.
Dit scriptje kan gebruikt worden door php om bepaalde acties uit te voeren tegen de back-end.

Toepassing is;
front_end_actions.py <actie*> <file> <dir>

Input argument <actie> is veprlicht en altijd als eerste, de rest is optioneel, maar wel verplicht voor een aantal acties en verschillend per functie.
'''

# defineer alle commando's in deze dictionary
commands = {
       "clear_db": clear_results,
       "process_bottle": process_return_file,
       "export_bottle_properties": export_bottle_properties_csv,
       "process_bottle_properties": process_bottle_property_return_file,
       "update_whine": update_whine,
       "recreate_db": recreate_table
}

# eerste cmd argument is altijd de command
received_command = argv.pop(1)
# match command naar functie met de dictionary, bestaat deze niet dan krijgen we None terug
matched_command = commands.get(received_command)

# check of command bestaat, als dat het geval is roep deze aan met de rest van de argumenten
if matched_command:
       matched_command(*argv[1:])
else:
      print('Geen juiste actie opgegeven!')
