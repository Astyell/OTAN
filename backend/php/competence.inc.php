<?php

class competence 
{
	private int		$id_competence;
    private string	$nomC;
	
	public function __construct($iC,$nC) 
	{
		$this->id_competence = $iC;
		$this->nomC = $nC;
	}

	public function getId_competence() { return $this->id_competence; }
	public function getN_Ip() { return $this->n_Ip;}

	public function __toString() 
	{
		$res = "id_competence:".$this->id_competence."\n";
		$res = $res ."nomC:".$this->nomC."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
