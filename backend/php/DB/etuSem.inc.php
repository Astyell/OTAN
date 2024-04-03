<?php

/** etuSem.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class etuSem
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private string		$n_etud;
    private int			$id_semestre;
	private int 		$id_annee;
    private string		$tp;
    private string		$td;
	private string		$nbabsinjust;
    private string		$nbabsjusti;
	private float		$moy_gene;
	private float		$bonus;
	private String 		$nb_ue;
	private bool		$alternant;
    
	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE="",$iS=1,$iA=1,$tp="",$td="",$nai="",$naj="", $moy=1, $bon=1, $ue="", $alter=true ) 
	{
		$this->n_etud 		= $nE;
		$this->id_semestre 	= $iS;
		$this->id_annee		= $iA; 
		$this->tp 			= $tp;
        $this->td 			= $td;
		$this->nbabsinjust 	= $naj;
		$this->nbabsjusti	= $nai;
		$this->moy_gene		= $moy;
		$this->bonus		= $bon;
		$this->nb_ue		= $ue;
		$this->alternant	= $alter;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud		() { return $this->n_etud; }
	public function getId_Semestre	() { return $this->id_semestre;}
	public function getId_Annee		() { return $this->id_annee;}
	public function getTP			() { return $this->tp; }
    public function getTD			() { return $this->td; }
	public function getNbAbsJusti	() { return $this->nbabsjusti;}
	public function getNbAbsInjustc	() { return $this->nbabsinjust; }
	public function getMoyGeneral	() { return $this->moy_gene; }
	public function getBonus		() { return $this->bonus; }
	public function getNbUe			() { return $this->nb_ue; }
	public function getAlternant	() { return $this->alternant; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_etud."\n";
		$res = $res ."id_Semestre:".$this->id_semestre."\n";
		$res = $res ."TP:".$this->tp."\n";
        $res = $res ."TD:".$this->td."\n";
		$res = $res ."nbAbsJusti:".$this->nbabsjusti."\n";
        $res = $res ."nbAbsInjust:".$this->nbabsinjust."\n";
		$res = $res ."moy_gene:".$this->moy_gene."\n";
		$res = $res ."bonus:".$this->bonus."\n";
		$res = $res ."nb_ue:".$this->nb_ue."\n";
		$res = $res ."alternant:".$this->alternant."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
