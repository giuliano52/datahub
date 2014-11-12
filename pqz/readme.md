#Data Directory

- bin : all program to genertate csv file ( or to convert from other sources to csv)
- conf : all configuration (ex congratulation list urls file, .... ) 
- csv : all csv quiz
- ini : all quiz configuration
- src : all source to generate csv file (e.g. ods file ... )

#CSV Format:

##Campi
* sono obbligatori
- id                    : unique id of the question
- question *  			: La domanda come viene presentata (pi� domande possono essere separate da |) 
- correct_answer *		: La risposta corretta (in caso di pi� risposte corrette separale da | ) 
- wrong_answer			: Le verie risposte possibili (separate da | )
- difficult_level		: il livello di difficolt� (0-100) (10 Molto facile, 25 Facile, 50 Medio, 75 Difficle, 90 Molto Difficile)
- response_type			: options (risposta multipla) text (risposta libera) (Si pu� impostare un valore per includere un massimo numero di opzioni es options_3)
- tags					: categoria della domanda (tags separati da |)
- if_correct			: testo descrittivo che viene mostrato se la risposta � corretta
- if_wrong				: testo descrittivo che viene mostrato se la risposta � sbagliata 


# Programmi utili

## Convertire da OTD a CSV
bisogna abilitare in php.ini: (  extension=zip.so ) 

     php bin/convert-to-csv-php/ods2csv.php src/strumenti-musicali.ods
     mv src/*.csv csv/

## File ODT con immagini

oppure se si ha un file odt con le colonne img1 img2 .... img9 genera il campo question con solo le immagini. 
per semplicit� le colonne possono essere riempite con degli zeri (0) non verranno inserite nel campo question 
(pu� essere utile per la visualizzazione in openoffice)  
In questo particolare caso il file odt pu� non avere la colonna 'question'   
	 
     php bin/convert-to-csv-php/ods2csv-image-quiz.php src/animali.ods
     mv src/*.csv csv/


    
