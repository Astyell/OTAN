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

	private string		$n_Etud;
	private int			$id_ressource;
    private float		$moy;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE,$iR,$m) 
	{
		$this->n_Etud 			= $nE;
		$this->id_competence	= $iR;
		$this->moy 				= $m;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud		() { return $this->n_Etud; }
	public function getId_ressource	() { return $this->id_ressource;}
	public function getMoy			() { return $this->moy; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_Etud."\n";
		$res = $res ."id_competence:".$this->id_competence."\n";
		$res = $res ."moy:".$this->moy."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
