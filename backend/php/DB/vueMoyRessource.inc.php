<?php

/** vueMoyRessource.inc.php
* @author  : Matéo
* @since   : 28/03/2024
* @version : 1.0.0 - 28/03/2024
*/

class vueMoyRessource 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private String 	$n_etud;
	private String	$id_ressource;
	private float	$moy;
	private float	$moy_gene;


	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($n="",$iR="",$m=0.0, $mo=0.0) 
	{
		$this->n_etud		 	= $n;
		$this->id_ressource 	= $iR;
		$this->moy			 	= $m;
		$this->moy_gene		 	= $mo;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getNetud		() { return $this->n_etud;}
	public function getRessource	() { return $this->id_ressource;}
	public function getMoy			() { return $this->moy;}


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
