<?php

header('Content-type: text/html;charset=ISO-8859-1');
include_once("conn.php");
$conn=Core::getInstance()->dbh;

$pkg=$_POST['pkg'];
$points=array(125,375,625,875);
switch($pkg){
	case '3333':{
		$SQL = "SELECT words.word AS word, COUNT(owned) AS word_number FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package = -1 GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
		$class_type=1;
		break;	
	}
	case '4444':{
		//cambiare
		$SQL = "SELECT words.word AS word, lemmi.package AS package, COUNT(owned) AS word_number FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package IN (0,1,3,5,7) GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
		$class_type=2;
		break;	
	}
	case '5555':{
		$SQL = "SELECT words.word AS word, COUNT(owned) AS word_number FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package IN (-1,0,1,3,5,7) GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
		$class_type=1;
		break;	
	}
	case '6666':{
		$SQL = "SELECT words.word AS word, COUNT(owned) AS word_number FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
		$class_type=1;		
		break;	
	}
	case '7777':{
		$SQL = "SELECT words.word AS word, lemmi.package AS package, COUNT(owned) AS word_number FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package NOT IN (-1,0,1,3,5,7) GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
		$class_type=2;
		break;	
	}
	default:{
		$SQL = "SELECT words.word AS word, diff, section FROM lemmi JOIN words ON lemmi.id=words.id JOIN packages ON packages.ID=lemmi.package WHERE lang=0 AND package=".$pkg." ORDER BY words.word ASC";
		$class_type=0;
		break;	
	}
}

try{
	$stm=$conn->prepare($SQL);
	$stm->execute();
	$alt=0;
	$add_class="";
	$base_counter=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); //40 pacchetti possibili
	$pack_names=array("Animali","Oggetti","Azioni Plus","Azioni","Mestieri Plus","Mestieri","Personaggi","Astratti","Proverbi","Oggetti Plus","Brand","Eroi di LoL","Sport","Modi di dire","Musica","Animali Plus","Azioni Encore","Oscenità","Film","Geografia","Scienza","Oggetti Encore","Medicina","Astratti Plus","Aggettivi","Disney");
	while($row=$stm->fetchObject()){
		$difficulty="diff_yellow";
		if($alt%2) $add_class=" alt";
		else $add_class="";
		if($class_type==0){
			$actual_points=$row->diff-$points[$row->section];
			if ($actual_points<-60) $difficulty="diff_green";
			else if ($actual_points<-30) $difficulty="diff_yellow_green";
			else if ($actual_points>60) $difficulty="diff_red";
			else if ($actual_points>30) $difficulty="diff_yellow_red";
			$write="<div class='word_wrapper ".$add_class."' ><div class='word_name' title='".htmlentities($row->word, ENT_QUOTES)."'>".$row->word."</div><div rel='".$actual_points."' class='word_difficulty ".$difficulty."'></div></div>";
			echo $write;
		}
		else if($class_type==1){
			$word_number=$row->word_number;
			$write="<div class='word_wrapper ".$add_class."' ><div class='word_name' title='".htmlentities($row->word, ENT_QUOTES)."'>".$row->word."</div><div class='pkg_words_number'>".$word_number."</div></div>";
			echo $write;
		}
		else{
			if($row->package!="999") $base_counter[$row->package]++;
	/*		switch($row->package){
				case '0':{
					$base_counter[0]++;	
					break;
				}
				case '1':{
					$base_counter[1]++;	
					break;
				}
				case '3':{
					$base_counter[2]++;	
					break;
				}
				case '5':{
					$base_counter[3]++;	
					break;
				}
				case '7':{
					$base_counter[4]++;	
					break;
				}
				default:{
					$base_counter[0]++;	
				}
			}*/
			
		}
		$alt++;
	}
	if($class_type==2){
		$write="";
		$keys=array();
		for($i=0;$i<count($base_counter)-1;$i++){
			if($base_counter[$i]!="0"){
				$write.="<div class='word_wrapper' ><div class='word_name'>".$pack_names[$i]."</div><div class='pkg_words_number'>".$base_counter[$i]."</div></div>";
			}
		}
		/*$write="<div class='word_wrapper' ><div class='word_name'>Animali</div><div class='pkg_words_number'>".$base_counter[0]."</div></div>".
		"<div class='word_wrapper alt' ><div class='word_name'>Oggetti</div><div class='pkg_words_number'>".$base_counter[1]."</div></div>".
		"<div class='word_wrapper' ><div class='word_name'>Azioni</div><div class='pkg_words_number'>".$base_counter[2]."</div></div>".
		"<div class='word_wrapper alt' ><div class='word_name'>Mestieri</div><div class='pkg_words_number'>".$base_counter[3]."</div></div>".
		"<div class='word_wrapper' ><div class='word_name'>Astratti</div><div class='pkg_words_number'>".$base_counter[4]."</div></div>";*/
		echo $write;		
		
	}
}
catch(PDOException $e) {
	echo "Error: " . $e->getMessage() . " " .$SQL;
}


?>