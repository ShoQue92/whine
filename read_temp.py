import os
import glob
import time
import datetime
from whine_DB_SDK import log_temp


'''
Dit script leest de temperatuur sensor uit die is geconfigureerd op de raspberry.
Hiervoor zijn twee functies gemaakt, read_temp_raw, en read_temp.
read_temp_raw is de waarde die teruggegeven wordt uit /sys/bus/w1/devices/28-00000c43e91a/w1_slave 
read_temp is een functie die deze ruwe waardes op een nette manier ophaalt, om alleen de celsius en fahrenheit waardes over te houden.

in read_temp zit tevens een call naar functie log_temp uit Whine_DB_SDK om de gelezen waardes te verwerken naar de database.
 
'''

now_raw = datetime.datetime.now()
now = now_raw.strftime("%Y-%m-%d %H:%M:%S")

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')
 
base_dir = '/sys/bus/w1/devices/'
device_folder = glob.glob(base_dir + '28*')[0]
device_file = device_folder + '/w1_slave'

sleep_raw = int(input('Selecteer optie voor temperatuurmeting in seconden'))

if sleep_raw == 1:
    sleep = 600
elif sleep_raw == 2:
    sleep =  1800
elif sleep_raw == 3:
    sleep = 3600
else:
    print("Ongeldige optie opgegeven (", sleep_raw, ')! Default wordt toegepast')
    sleep = 600

sleep_min = sleep / 60

def read_temp_raw():
    f = open(device_file, 'r')
    lines = f.readlines()
    f.close()
    return lines
 
def read_temp(now):
    lines = read_temp_raw()
    while lines[0].strip()[-3:] != 'YES':
        time.sleep(0.2)
        lines = read_temp_raw()
    equals_pos = lines[1].find('t=')
    if equals_pos != -1:
        temp_string = lines[1][equals_pos+2:]
        temp_c = float(temp_string) / 1000.0
        temp_f = temp_c * 9.0 / 5.0 + 32.0

        log_temp(temp_c, temp_f,now)
        message = print("De volgende meting gebeurd over",int(sleep_min), 'minuten.')
        return message
    return print(equals_pos)
	
while True:
	print(read_temp(now))
	time.sleep(sleep)