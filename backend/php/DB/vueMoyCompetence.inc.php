<?php

/** vueMoyRessource.inc.php
* @author  : Matéo
* @since   : 28/03/2024
* @version : 1.0.0 - 28/03/2024
*/

class vueMoyCompetence 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private String 	$n_etud;
	private String	$id_competence;
	private float	$moy_ue;
	private float	$bonus;


	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($n="",$iR="",$m=0.0, $mo=0.0) 
	{
		$this->n_etud		 	= $n;
		$this->id_competence 	= $iR;
		$this->moy_ue			= $m;
		$this->bonus		 	= $mo;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getNetud		() { return $this->n_etud;}
	public function getCompetence	() { return $this->id_competence;}
	public function getMoy			() { return $this->moy_ue;}
	public function getBonus		() { return $this->bonus;}



	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	/*public function __toString() 
	{
		$res = "id_semestre:".$this->id_semestre."\n";
		$res = $res ."id_annee:".$this->id_annee."\n";
		$res = $res ."<br/>";
		return $res;
	}*/
}
?>
