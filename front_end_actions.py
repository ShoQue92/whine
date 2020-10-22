from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottle_properties_csv
from whine_base import process_return_file
from sys import argv

actie = argv[1]
file = argv[2]
tgt_dir = argv[3]

if actie == 'process_bottle':
   process_return_file(file, tgt_dir)
elif actie == 'export_bottle_properties':
   export_bottle_properties_csv(file,tgt_dir)
else:
       print('Geen juiste actie opgegeven')
