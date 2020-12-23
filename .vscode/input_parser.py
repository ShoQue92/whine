# File providing support for VS code debugging
# This file is used as a proxy to translate the 
# command parameters provided as a string to separate arguments

from sys import argv
import subprocess

filename = argv.pop(1)
command = argv.pop(1)
args = argv.pop(1).split(" ")
# filter out empty arguments
if args == ['']:
    args = []

# call the actual file
subprocess.call(["python", filename, command, *args])