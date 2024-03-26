<?php

class semestre 
{
	private int		$id_semestre;
    private int		$id_annee;
	
	public function __construct($iS,$iA) 
	{
		$this->id_semestre = $iS;
		$this->id_annee = $iA;
	}

	public function getId_semestre() { return $this->id_semestre; }
	public function getId_annee() { return $this->id_annee;}

	public function __toString() 
	{
		$res = "id_semestre:".$this->id_semestre."\n";
		$res = $res ."id_annee:".$this->id_annee."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
