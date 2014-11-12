#!/bin/python
# usage: 
# ./genera-liste-da-ordinare.py > ../csv/liste-da-ordinare.csv
numero_elementi_per_lista=6
numero_massimo_della_lista=50
numero_domande_crescente=10
numero_domande_decrescente=10

domanda_crescente="Ordina in modo CRESCENTE i segenti numeri mettendo uno spazio tra uno e l'altro:<br>"
domanda_decrescente="Ordina in modo DECRESCENTE i segenti numeri mettendo uno spazio tra uno e l'altro:<br>"

import sys

import random

out="question;correct_answer\n"

for i in range(1,numero_domande_crescente):
	my_randoms = random.sample(range(numero_massimo_della_lista), numero_elementi_per_lista)
	str_myrandom = " ".join(str(x) for x in my_randoms)
	my_randoms.sort()
	str_sorted_myrandom = " ".join(str(x) for x in my_randoms)
	out = out + domanda_crescente+str_myrandom + ";"+ str_sorted_myrandom + "\n"

for i in range(1,numero_domande_decrescente):
	my_randoms = random.sample(range(numero_massimo_della_lista), numero_elementi_per_lista)
	str_myrandom = " ".join(str(x) for x in my_randoms)
	my_randoms.sort(reverse=True)
	str_sorted_myrandom = " ".join(str(x) for x in my_randoms)
	out = out + domanda_decrescente+str_myrandom + ";"+ str_sorted_myrandom + "\n"


sys.stdout.write(out)	

