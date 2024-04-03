<?php

/** etuRes.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class etuRes 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private string		$n_etud;
	private string		$id_ressource;
    private float		$moy;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE="",$iR=-1,$m=0.0) 
	{
		$this->n_etud 			= $nE;
		$this->id_ressource	    = $iR;
		$this->moy 				= $m;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud		() { return $this->n_etud; }
	public function getId_ressource	() { return $this->id_ressource;}
	public function getMoy			() { return $this->moy; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_etud."\n";
		$res = $res ."id_ressource:".$this->id_ressource."\n";
		$res = $res ."moy:".$this->moy."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
