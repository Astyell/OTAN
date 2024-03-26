<?php

class etuAnn 
{
	private string		$n_Etud;
	private int			$id_annee;
    private float		$bonus;
    private string		$parcours;
	private string		$admission;
	
	public function __construct($nE,$iA,$b,$p,$a) 
	{
		$this->n_Etud	 	= $nE;
		$this->id_annee 	= $iA;
		$this->bonus 		= $b;
        $this->parcours 	= $p;
		$this->admission 	= $a;
	}

	public function getN_Etud	() { return $this->n_Etud; }
	public function getId_annee	() { return $this->id_annee;}
	public function getBonus	() { return $this->bonus; }
    public function getParcours	() { return $this->parcours; }
	public function getAdmission() { return $this->admission;}

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_Etud."\n";
		$res = $res ."id_annee:".$this->id_annee."\n";
		$res = $res ."bonus:".$this->bonus."\n";
        $res = $res ."parcours:".$this->parcours."\n";
		$res = $res ."admission:".$this->admission."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
