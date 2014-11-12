#!/bin/python
# usage: 
# ./genera-differenze.py > ../csv/differenze.csv

numero_domande=200
numero_max=50
numero_min=10


import sys
import random

out="question;correct_answer\n"

for i in range(1,numero_domande):
	num1 = random.randint(numero_min,numero_max)
	num2 = random.randint(numero_min,numero_max)
	
	n1 = max(num1,num2)
	n2 = min(num1,num2)
	
	domanda = str(n1)+" - "+str(n2)
	risposta = str(n1-n2)
	
	
	out = out + domanda + ";"+ risposta + "\n"



sys.stdout.write(out)	

