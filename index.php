<?php
	header('Content-type: text/html;charset=ISO-8859-1');
	include_once("conn.php");
	$conn=Core::getInstance()->dbh;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='viewport' content='width=device-width, user-scalable=no' />

<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>

<title>Quetzal Encycloedia</title>
</head>

<body>

	<div class="" id="box">
    	<div class="" id="header">
        	Quetzal Encyclopedia
        </div>
        
        <div class="" id="content">
        	<div class="colonna" id="categorie">
            	<ul>
                	<li>
                    	<div class="wrapper_pacchetti">
                            <div class="bullet blue" id=""></div>
                            <div class="categoria">Sempliciotto</div>
                        </div>
                        <div class="box_pacchetti" id="">
                        	<?php
								
								$SQL = "SELECT packages.id AS id, package_info.name AS name, packages.name AS path, COUNT(lemmi.package) AS words FROM package_info JOIN packages ON package_info.id = packages.id JOIN lemmi ON lemmi.package = packages.id WHERE packages.section =0 AND lang =0 GROUP BY package_info.name ORDER BY package_info.name ASC";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								while($row=$stm->fetchObject()){
									echo "<div class='pkg_wrapper' rel='".$row->id."'><img src='img/pkg/pkg_".$row->path.".png' class='pkg_icon' \><div class='pkg_name'>".$row->name."</div><div class='pkg_words_number'>".$row->words."</div></div>";
								}
							
							?>
                        </div>
                    </li>
                    <li>
	                    <div class="wrapper_pacchetti">
                            <div class="bullet red" id=""></div>
                            <div class="categoria">Fattibile</div>
                        </div>
                        <div class="box_pacchetti" id="">
                        	<?php
								
								$SQL = "SELECT packages.id AS id, package_info.name AS name, packages.name AS path, COUNT(lemmi.package) AS words FROM package_info JOIN packages ON package_info.id = packages.id JOIN lemmi ON lemmi.package = packages.id WHERE packages.section =1 AND lang =0 GROUP BY package_info.name ORDER BY package_info.name ASC";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								while($row=$stm->fetchObject()){
									echo "<div class='pkg_wrapper' rel='".$row->id."'><img src='img/pkg/pkg_".$row->path.".png' class='pkg_icon' \><div class='pkg_name'>".$row->name."</div><div class='pkg_words_number'>".$row->words."</div></div>";
								}
							
							?>                        	
                        </div>
                    </li>
                    <li>
                    	<div class="wrapper_pacchetti">
                    		<div class="bullet yellow" id=""></div>
                        	<div class="categoria">Problematico</div>
                        </div>
                        <div class="box_pacchetti" id="">
                        	<?php
								
								$SQL = "SELECT packages.id AS id, package_info.name AS name, packages.name AS path, COUNT(lemmi.package) AS words FROM package_info JOIN packages ON package_info.id = packages.id JOIN lemmi ON lemmi.package = packages.id WHERE packages.section =2 AND lang =0 GROUP BY package_info.name ORDER BY package_info.name ASC";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								while($row=$stm->fetchObject()){
									echo "<div class='pkg_wrapper' rel='".$row->id."'><img src='img/pkg/pkg_".$row->path.".png' class='pkg_icon' \><div class='pkg_name'>".$row->name."</div><div class='pkg_words_number'>".$row->words."</div></div>";
								}
							
							?>                        	
                        </div>
                    </li>
                    <li>
                    	<div class="wrapper_pacchetti">
                    		<div class="bullet green" id=""></div>
                        	<div class="categoria">Improponibile</div>
                   		</div>
                        <div class="box_pacchetti" id="">
                        	<?php
								
								$SQL = "SELECT packages.id AS id, package_info.name AS name, packages.name AS path, COUNT(lemmi.package) AS words FROM package_info JOIN packages ON package_info.id = packages.id JOIN lemmi ON lemmi.package = packages.id WHERE packages.section =3 AND lang =0 GROUP BY package_info.name ORDER BY package_info.name ASC";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								while($row=$stm->fetchObject()){
									echo "<div class='pkg_wrapper' rel='".$row->id."'><img src='img/pkg/pkg_".$row->path.".png' class='pkg_icon' \><div class='pkg_name'>".$row->name."</div><div class='pkg_words_number'>".$row->words."</div></div>";
								}
							
							?>                        	
                        </div>                        
                    </li>
                    
                    <li>
                    	<div class="wrapper_pacchetti">
                    		<div class="bullet purple" id=""></div>
                        	<div class="categoria">Taboo!</div>
                   		</div>
                        <div class="box_pacchetti" id="">
                        	<?php
								
								$SQL = "SELECT words.word, lemmi.package, COUNT(owned) FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package = -1 GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								$taboo_total=0;
								while($row=$stm->fetchObject()){
									$taboo_total++;
									
								}
								echo "<div class='pkg_wrapper' rel='3333'><img src='img/pkg/pkg_taboo.png' class='pkg_icon' \><div class='pkg_name'>Non categorizzato</div><div class='pkg_words_number'>".$taboo_total."</div></div>";
								
								$SQL = "SELECT words.word, lemmi.package, COUNT(owned) FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package IN (0,1,3,5,7) GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								$taboo_total=0;
								while($row=$stm->fetchObject()){
									$taboo_total++;
									
								}
								echo "<div class='pkg_wrapper' rel='4444'><img src='img/pkg/pkg_taboo.png' class='pkg_icon' \><div class='pkg_name'>Pacchetti base</div><div class='pkg_words_number'>".$taboo_total."</div></div>";
							
								$SQL = "SELECT words.word, lemmi.package, COUNT(owned) AS num_taboo FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package IN (-1,0,1,3,5,7) GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								$taboo_total=0;
								while($row=$stm->fetchObject()){
									$taboo_total++;
									
								}
								echo "<div class='pkg_wrapper' rel='5555'><img src='img/pkg/pkg_taboo.png' class='pkg_icon' \><div class='pkg_name'>Totale FREE</div><div class='pkg_words_number'>".$taboo_total."</div></div>";
							
								$SQL = "SELECT words.word, lemmi.package, COUNT(owned) FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 AND lemmi.package NOT IN (-1,0,1,3,5,7) GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								$taboo_total=0;
								while($row=$stm->fetchObject()){
									$taboo_total++;
									
								}
								echo "<div class='pkg_wrapper' rel='7777'><img src='img/pkg/pkg_taboo.png' class='pkg_icon' \><div class='pkg_name'>Espansioni</div><div class='pkg_words_number'>".$taboo_total."</div></div>";
								
								$SQL = "SELECT words.word, lemmi.package, COUNT(owned) AS num_taboo FROM taboo JOIN words ON words.id=taboo.owner JOIN lemmi ON lemmi.id=taboo.owner WHERE words.lang=0 GROUP BY words.word HAVING COUNT(owned)>4 ORDER BY words.word";
								$stm=$conn->prepare($SQL);
								$stm->execute();
								$taboo_total=0;
								while($row=$stm->fetchObject()){
									$taboo_total++;
									
								}
								echo "<div class='pkg_wrapper' rel='6666'><img src='img/pkg/pkg_taboo.png' class='pkg_icon' \><div class='pkg_name'>Totale</div><div class='pkg_words_number'>".$taboo_total."</div></div>";
							?>                        	
                        </div>                        
                    </li>
                
                </ul>
            </div>
            <div class="colonna" id="lista">
                     	<div class="wrapper_parole">
                    		<div class="bullet_pacchetto" id=""><img id="img_pacchetto" src="" alt="" /></div>
                        	<div class="pacchetto" id="nome_pacchetto"></div>
                        </div>
                        <div class="box_parole" id="">
                                         	
                        </div>           	
            </div>
            <div class="colonna" id="legenda">
            	<ul>
                	<li>
                    	<div class="word_difficulty diff_green"></div><div class="legenda_name">Facile</div>
                    </li>
                	<li>
                    	<div class="word_difficulty diff_yellow"></div><div class="legenda_name">Medio</div>
                    </li>
                	<li>
                    	<div class="word_difficulty diff_red"></div><div class="legenda_name">Difficile</div>
                    </li>                    
                </ul>
            </div>
            <div class="clearer" id="">
            	
            </div>
        </div>
    </div>

</body>
</html>
