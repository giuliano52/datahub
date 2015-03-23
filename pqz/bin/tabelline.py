#!/usr/bin/python
# -*- coding: utf-8 -*-
# gd 20150301
"""
Template for python
"""


import argparse
import csv

					



def run():

	#fieldnames = ['id', 'question','correct_answer','wrong_answer','difficult_level','response_type','tags','if_correct','if_wrong']
	fieldnames = [ 'question','correct_answer','wrong_answer','difficult_level','response_type','tags','if_correct','if_wrong']
	with open('../csv/tabelline.csv', 'w') as csvfile:
		writer = csv.DictWriter(csvfile, fieldnames=fieldnames,delimiter=';')
		writer.writeheader()
		for i1 in range(0,11):
			for i2 in range(0,11):
				 writer.writerow({'question': str(i1)+' x '+str(i2), 'correct_answer': str(i1*i2)})
		
		
def main():
	
	global args
	parser = argparse.ArgumentParser(description='Genera il file csv con le tabelline')
	args = parser.parse_args()

	run()

if __name__ == '__main__':
    main()
    


