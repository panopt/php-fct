<?php

// Cette fonction convertis l'encodage utilisé dans $str (qui est retourné) vers UTF-8. (Seulement si différent de UTF-8)
// Une liste d'encodages reconnus (sous forme de tableau) doit être spécifiés dans $mbDetectOrder (ne pas y inclure UTF-8)
// Si il se produit une erreur (encodage non reconnu), le message d'erreur correspondant est levé.
function x_to_uft8($str, $mbDetectOrder=array('ISO-8859-1')){
	array_unshift($mbDetectOrder, 'UTF-8');
	$mbDetectOrder=implode(', ', $mbDetectOrder);
	$encoding=mb_detect_encoding($str, $mbDetectOrder, true);
	if(!empty($encoding)){
		if($encoding != 'UTF-8'){$str=mb_convert_encoding($str, 'UTF-8', $mbDetectOrder);}
	}
	else{
		throw new Exception('x_to_uft8 : L\'encodage n\'est pas reconnu.');
	}
return $str;
}

