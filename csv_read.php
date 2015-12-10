<?php

// @ Inclure la fonction  à la place de ce hack
function x_to_uft8($str){ return $str; }

// Lis un fichier .csv et l'enregistre dans un tableau qui est retourné. Les lignes vides sont ignorées. 
// L'encodage est convertis vers UTF-8.
// Si mode=0 :  "table[index_ligne][index_colonne]=valeur" 
// Si mode=1 :  "table[index_ligne][index_colonne]=valeur" et la première ligne du fichier (entêtes) sera ignoré
// Si mode=2 :  "table[index_ligne][clef_colonne]=valeur" où clef_colonne correspondra à la valeur de la colonne dans la première ligne du fichier (entêtes)
function csv_read($FilePath, $delimiter, $enclosure, $mode=0){
$OUTarray=array();
$headings=null;
	if(is_readable($FilePath)){
		$cptl=0;
		if($handle=@fopen($FilePath, "r")){
			// Mode 2
			if($mode == 2){
				while(($cols=fgetcsv($handle, 1000, $delimiter, $enclosure)) !== FALSE){
					if(!is_null($cols[0])){
						if($headings == null){
							$headings=$cols;
						}
						else{
							$length=count($cols);
							for($cptc=0; $cptc < $length; $cptc++){
								$OUTarray[$cptl][ $headings[$cptc] ]=x_to_uft8(trim($cols[$cptc]));		// Noter que l'on normalise l'encodage vers UTF-8
							}
						$cptl++;
						}
					}
				}
			}
			// Mode 0 et 1
			else{
				if($mode == 0){ $headings=true; }
				$cptl=0;
				while(($cols=fgetcsv($handle, 1000, $delimiter, $enclosure)) !== FALSE){
					if(!is_null($cols[0])){
						if($headings == null){
							$headings=true;
						}
						else{
							$length=count($cols);
							for($cptc=0; $cptc < $length; $cptc++){
								$OUTarray[$cptl][$cptc]=x_to_uft8(trim($cols[$cptc]));					// Noter que l'on normalise l'encodage vers UTF-8
							}
						$cptl++;
						}
					}
				}
			}
		fclose($handle);
		}
		if($cptl == 0){
			throw new Exception('CSVtoTable : Le fichier ['.$FilePath.'] est vide.');
		}
	}
	else{
		throw new Exception('CSVtoTable : Imposible de lire ['.$FilePath.'].');
	}
return $OUTarray;
}

