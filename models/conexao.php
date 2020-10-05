<?php
	
	class Conexao{

		function conectar(){
            try{
			    $conexao = new PDO('mysql:host=localhost;dbname=chat','root','');
			    return $conexao;
		    } catch (PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
        }
	}
  	
?>