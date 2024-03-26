<?php

class ressource 
{
	private int		$id_ressource;
    private string		$nomR;
    private float		$coefR;
    private int		$id_semestre;
	
	public function __construct($iR,$nR,$cR,$iS) 
	{
		$this->id_ressource = $iR;
		$this->nomR = $nR;
		$this->coefR = $cR;
        $this->id_semestre = $iS;
	}

	public function getId_ressource() { return $this->id_ressource; }
	public function getNomR() { return $this->nomR;}
	public function getCoefR() { return $this->coefR; }
    public function getId_semestre() { return $this->id_semestre; }

	public function __toString() 
	{
		$res = "id_ressource:".$this->id_ressource."\n";
		$res = $res ."nomR:".$this->nomR."\n";
		$res = $res ."coefR:".$this->coefR."\n";
        $res = $res ."id_semestre:".$this->id_semestre."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>