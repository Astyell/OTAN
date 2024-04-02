<?php

class annee 
{
	private int		$id_annee;
	
	public function __construct($iA) 
	{
		$this->id_annee = $iA;
	}

	public function getId_annee() { return $this->id_annee; }

	public function __toString() 
	{
		$res = "id_annee:".$this->id_annee."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
