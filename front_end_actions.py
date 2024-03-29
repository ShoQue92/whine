from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottle_properties_csv
from whine_DB_SDK import clear_results
from whine_DB_SDK import recreate_table
from whine_DB_SDK import delete_selected
from whine_DB_SDK import fetch_latest_temp_measures
from whine_DB_SDK import fetch_avg_temp
from whine_DB_SDK import fetch_avg_temp_bottle
from whine_DB_SDK import clear_temps
from whine_DB_SDK import add_rating
from whine_DB_SDK import delete_bottle_property
from whine_DB_SDK import update_whine_deleted_ind
from whine_DB_SDK import update_whine_opgedronken_ind
from whine_DB_SDK import fetch_avg_rating
from whine_DB_SDK import fetch_avg_rating_all
from whine_DB_SDK import fetch_rating
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
       "recreate_db": recreate_table,
       "delete_bottle": delete_selected,
       "delete_bottle_property": delete_bottle_property,
       "fetch_cur_temp":fetch_latest_temp_measures,
       "fetch_avg_temp_bottle": fetch_avg_temp_bottle,
       "fetch_avg_temp": fetch_avg_temp,
       "clear_temps": clear_temps,
       "add_rating": add_rating,
       "deleted_ind_UID": update_whine_deleted_ind,
       "opgedronken_ind_UID": update_whine_opgedronken_ind,
       "fetch_avg_rating": fetch_avg_rating,
       "fetch_avg_rating_all": fetch_avg_rating_all,
       "fetch_rating": fetch_rating
}

# bestandsnaam negeren
argv.pop(0)

if not argv:
       print("Geen commando meegegeven!")
       exit(1)

# eerste cmd argument is altijd de command
received_command = argv.pop(0)
# match command naar functie met de dictionary, bestaat deze niet dan krijgen we None terug
matched_command = commands.get(received_command)

#check of command bestaat, als dat het geval is roep deze aan met de rest van de argumenten
if not matched_command:
       print("Geen geldig commando gevonden.")
       exit(1)

matched_command(*argv)
exit(0)