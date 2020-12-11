from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottle_properties_csv
from whine_DB_SDK import clear_results
from whine_base import process_return_file
from whine_base import process_bottle_property_return_file
from sys import argv

actie = argv[1]
file = argv[2]
tgt_dir = argv[3]

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