from whine_DB_SDK import update_whine
from whine_DB_SDK import export_bottles_csv
from whine_base import process_return_file
from sys import argv

actie = argv[1]
file = argv[2]
tgt_dir = argv[3]

if actie == 'process_bottle':
   process_return_file(file)
if actie == 'export_bottles':
   export_bottles_csv(file,tgt_dir)
