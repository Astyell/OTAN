<?php

/** vueNomColonne.inc.php
* @author  : Matéo
* @since   : 28/03/2024
* @version : 1.0.0 - 28/03/2024
*/

class vueNomColonne 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private String 	$id_competence;
	private String	$id_ressource;
	private float	$coefr;


	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iC="",$iR="",$cR=0.00) 
	{
		$this->id_competence 	= $iC;
		$this->id_ressource 	= $iR;
		$this->coefr 			= $cR;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getCompetence	() { return $this->id_competence;}
	public function getRessource	() { return $this->id_ressource;}
	public function getCoef			() { return $this->coefr;}

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
