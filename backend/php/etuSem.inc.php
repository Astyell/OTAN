<?php

class etuSem
{
	private string		$n_Etud;
    private int			$id_Semestre;
    private string		$TP;
    private string		$TD;
    private string		$nbAbsJusti;
    private string		$nbAbsInjust;
	
	public function __construct($nE,$iS,$tp,$td,$naj,$nai) 
	{
		$this->n_Etud = $nE;
		$this->id_Semestre = $iS;
		$this->TP = $tp;
        $this->TD = $td;
		$this->nbAbsJusti = $naj;
		$this->nbAbsInjust = $nai;
	}

	public function getN_Etud() { return $this->n_Etud; }
	public function getId_Semestre() { return $this->id_Semestre;}
	public function getTP() { return $this->TP; }
    public function getTD() { return $this->TD; }
	public function getNbAbsJusti() { return $this->nbAbsJusti;}
	public function getNbAbsInjustc() { return $this->nbAbsInjust; }

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_Etud."\n";
		$res = $res ."id_Semestre:".$this->id_Semestre."\n";
		$res = $res ."TP:".$this->TP."\n";
        $res = $res ."TD:".$this->TD."\n";
		$res = $res ."nbAbsJusti:".$this->nbAbsJusti."\n";
        $res = $res ."nbAbsInjust:".$this->nbAbsInjust."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
