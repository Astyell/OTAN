<?php

class resCom 
{
	private int		$id_ressource;
	private int		$id_competence;
	
	public function __construct($iR,$iC) 
	{
		$this->id_ressource = $iR;
		$this->id_competence = $iC;
	}

	public function getId_ressource() { return $this->id_ressource; }
	public function getId_competence() { return $this->id_competence;}

	public function __toString() 
	{
		$res = "id_ressource:".$this->id_ressource."\n";
		$res = $res ."id_competence:".$this->id_competence."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
