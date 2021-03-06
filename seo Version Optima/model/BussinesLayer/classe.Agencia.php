<?php

class Agencia{
	private $nom = null;
	private $direccio = null;
	private $actors = null;
	private $directors = null;
	private $obres = null;
	private $generes = null;
	private $tipus = null;
	
	public function __construct($nom,$direccio){
		$this->nom = $nom;
		$this->direccio = $direccio;
		$this->actors = array();
		$this->directors = array();
		$this->obres = array();
		$this->tipus = array();
		$this->generes = array();
	}
	public function getActors(){
		return $this->actors;
	}

	public function setActors($actors){
		$this->actors = $actors;
	}

	public function getDirectors(){
		return $this->directors;
	}

	public function setDirectors($directors){
		$this->directors = $directors;
	}

	public function getObres(){
		return $this->obres;
	}
	public function setObres($obres){
		$this->obres = $obres;
	}
		public function getTipus(){
		return $this->tipus;
	}
	public function setTipus($tipus){
		$this->tipus = $tipus;
	}
		public function getGeneres(){
		return $this->generes;
	}
	public function setGeneres($generes){
		$this->generes = $generes;
	}

	public function populateAgencia(){
		$this->populateObras();
		$this->populateActors();
		$this->populateDirectors();
		$this->populateGenere();
		$this->populateTipus();
	}

	public function cercarActor($nif){
		$aparicions=0;
		for ($i = 0; $i<count($this->actors); $i++){
			if ($this->actors[$i]->getNif()==$nif){
				$aparicions=1;
			}
		}
		return $aparicions;			
	}
	public function cercarDirector($nif){
		$aparicions=0;
		for ($i = 0; $i<count($this->directors); $i++){
			if ($this->directors[$i]->getNif()==$nif){
				$aparicions=1;
			}
		}
		return $aparicions;			
	}
	public function cercarObra($nom){
		$aparicions=0;
		for ($i = 0; $i<count($this->obres); $i++){
			if ($this->obres[$i]->getNom()==$nom){
				$aparicions=1;
			}
		}
		return $aparicions;			
	}
	public function getActor($nif){
		$actor=null;
		for ($i = 0; $i<count($this->actors); $i++){
			if ($this->actors[$i]->getNif()==$nif){
				$actor=$this->actors[$i];
			}
		}
		return $actor;			
	}
	public function getDirector($nif){
		$director=null;
		for ($i = 0; $i<count($this->directors); $i++){
			if ($this->directors[$i]->getNif()==$nif){
				$director=$this->directors[$i];
			}
		}
		return $director;			
	}
	public function getObra($nom){
		$obra=null;
		for ($i = 0; $i<count($this->obres); $i++){
			if ($this->obres[$i]->getNom()==$nom){
				$obra=$this->obres[$i];
			}
		}
		return $obra;			
	}

	function populateObras() {	
		$agenciadb = new Agenciadb();
		$resultatConsultaObres = $agenciadb->queryObra();
		$obres = $agenciadb->queryArray($resultatConsultaObres);
		foreach($resultatConsultaObres as $obra) {		
			$ObraS = new Obra($obra['nom'],$obra['descripcio'],$obra['tipus'],$obra['dataInici'],$obra['dataFinal'],$obra['genere'],$obra['director'],$obra['actorPrincipal'],$obra['actrizPrincipal'],$obra['actorSecundario'],$obra['actrizSecundaria']);
			$ObraS->setId($obra['id']);
			array_push($this->obres, $ObraS);
		}
		
	}

	function populateActors() {	
		$agenciadb = new Agenciadb();
		$resultatConsultaActors = $agenciadb->queryActor();
		$actors = $agenciadb->queryArray($resultatConsultaActors);
		foreach($resultatConsultaActors as $actor) {		
			$ActorS = new Actor($actor['nif'],$actor['nom'],$actor['cognom'],$actor['sexe'],$actor['foto']);
			array_push($this->actors, $ActorS);
		}
	}
	function populateDirectors() {	
		$agenciadb = new Agenciadb();
		$resultatConsulta = $agenciadb->query("director");
		$directors = $agenciadb->queryArray($resultatConsulta);
		foreach($resultatConsulta as $dire) {		
			$DirectS = new Director($dire['nif'],$dire['nom'],$dire['cognom']);
			array_push($this->directors, $DirectS);
		}
		
	}
	function populateGenere() {	
		$agenciadb = new Agenciadb();
		$resultatConsulta = $agenciadb->query("genero");
		$generes = $agenciadb->queryArray($resultatConsulta);
		foreach($resultatConsulta as $var) {
			$generoS = new Genero($var['nom'],$var['descripcio']);
			
			//array_push($this->generes, $generoS);
			$this->generes[] = $generoS;
		}
		
	}
	function populateTipus() {	
		$agenciadb = new Agenciadb();
		$resultatConsulta = $agenciadb->query("tipo");
		$tipus = $agenciadb->queryArray($resultatConsulta);
		foreach($resultatConsulta as $var) {		
			$tipoS = new Tipo($var['nom'],$var['descripcio']);
			//array_push($this->tipus, $tipoS);
			$this->tipus[]= $tipoS;
		}
		
	}
	public function insertActor($nif,$nom,$cognom,$sexe,$foto){
		if($this->cercarActor($nif)==0){
			try {
				$actor = new Actor($nif,$nom,$cognom,$sexe,$foto);
				$actor ->afegirActor();
				array_push($this->obres, $obra);
				return 1;
			} catch (Exception $e) {
				echo "ERROR EN LA INSERSIO";
			}
		} else {
			return null;
		}
	}
	public function insertDirector($nif,$nom,$cognom){
		if($this->cercarDirector($nif)==0){
			try {
				$dir = new Director($nif,$nom,$cognom);
				$dir ->afegirDirector();
				array_push($this->directors, $dir);
				return 1;
			} catch (Exception $e) {
				echo "ERROR EN LA INSERSIO";
			}
		} else {
			return null;
		}
	}
	public function insertObra($nombre, $descripcion, $tipo, $fechaInicio, $fechaFinal, $genere, $director, $actorPrincipal,$actrizPrincipal, $actorSecundario, $actrizSecundaria){
		if($this->cercarObra($nombre)==0){
			try {			
				$obra = new Obra($nombre, $descripcion, $tipo, $fechaInicio, $fechaFinal, $genere, $director, $actorPrincipal, $actrizPrincipal, $actorSecundario, $actrizSecundaria);
				$id = $obra ->afegirObra();
				$obra ->setId($id);
				array_push($this->obres, $obra);
				return 1;
			} catch (Exception $e) {
				echo "ERROR EN LA INSERSIO";
			}
		} else {
			return null;
		}
	}
}
?>