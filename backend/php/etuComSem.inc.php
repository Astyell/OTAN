<?php

class etuComSem 
{
	private string	$n_Etud;
    private int		$id_semestre;
    private int		$id_competence;
    private float	$moy_Gene;
    private int		$nb_UE;
	
	public function __construct($nE,$iS,$iC,$mG,$nUE) 
	{
		$this->n_Etud 			= $nE;
		$this->id_semestre 		= $iS;
		$this->id_competence 	= $iC;
        $this->moy_Gene 		= $mG;
		$this->nb_UE			= $nUE;
	}

	public function getN_Etud		() { return $this->n_Etud; }
	public function getId_semestre	() { return $this->id_semestre;}
	public function getId_competence() { return $this->id_competence; }
    public function getMoy_Gene		() { return $this->moy_Gene; }
	public function getNb_UE		() { return $this->cursus;}

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_Etud."\n";
		$res = $res ."id_semestre:".$this->id_semestre."\n";
		$res = $res ."id_competence:".$this->id_competence."\n";
        $res = $res ."moy_Gene:".$this->moy_Gene."\n";
		$res = $res ."nb_UE:".$this->nb_UE."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
