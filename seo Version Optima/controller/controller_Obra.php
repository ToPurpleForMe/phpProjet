<!DOCTYPE html>
<html>
<body><link rel="stylesheet" title="css14" type="text/css" href="../view/css.css">
	<div id='login'>
		<?php
		session_start();
		function __autoload($class_name) {
			if(file_exists("../model/BussinesLayer/classe.".$class_name.".php")){
				require_once "../model/BussinesLayer/classe.".$class_name.".php";
			}else if(file_exists("../model/DAO/classe.".$class_name.".php")){
				require_once "../model/DAO/classe.".$class_name.".php";
			}
		}
		$buit=false;
		if(trim($_POST['nomObra']) == ''){
			echo("buit : Nom obligatori </br>");
			$buit=true;
		}
		if(trim($_POST['descripcioObra']) == ''){
			echo("buit : descripció obligatoria </br>");
			$buit=true;
		}

		if(trim($_POST['dataInici']) == ''){
			echo("buit : data Inici obligatoria </br>");
			$buit=true;
		}
		if(trim($_POST['dataFi']) == ''){
			echo("buit : data Final obligatoria </br>");
			$buit=true;
		}
		if(isset($_POST['dataInici'])){
			$stringDataInici = $_POST['dataInici'];
			$dataIniciObra = date("Y-m-d", strtotime($stringDataInici));
		}
		if(isset($_POST['dataFi'])){
			$stringDataFinal = $_POST['dataFi'];
			$dataFinalObra = date("Y-m-d", strtotime($stringDataFinal));
		}
		if($dataIniciObra>$dataFinalObra){
			echo("Error : data Final abans de la data d'inici </br>");
			$buit=true;
		}
		if($buit){      
			?>
			<button type="button" onclick="location.href='../view/formObra.php'">tornar</button>
			<?php
		}else{			
			$agen = unserialize($_SESSION['Agen']);
			$aux = $agen->insertObra($_POST['nomObra'], $_POST['descripcioObra'], $_POST['tipus'], $dataIniciObra, $dataFinalObra, $_POST['generes'], $_POST['director'], $_POST['actorPrincipal'], $_POST['actrizPrincipal'], $_POST['actorSecundario'], $_POST['actrizSecundaria']);
			if($aux = 1){
				$_SESSION['Agen']=serialize($agen);
				header("Location: ../view/MenuInicial.php?execucio=1");
			}else{
				$_SESSION['Agen']=serialize($agen);
				echo("Error ya existeix");
				header("Location: ../view/MenuInicial.php");
			}
		}

		?>
		<button type="button" onclick="location.href='../view/formObra.php'">tornar</button>

	</div>
</body>
</html>