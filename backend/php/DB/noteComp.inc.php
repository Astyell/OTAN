<?php

/** noteComp.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class noteComp 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private string		$n_etud;
	private String			$id_competence;
    private float		$moy_ue;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE="",$iC=-1,$mUE=0.0) 
	{
		$this->n_etud 			= $nE;
		$this->id_competence 	= $iC;
		$this->moy_ue 			= $mUE;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud		() { return $this->n_etud; }
	public function getId_competence() { return $this->id_competence;}
	public function getMoy_ue		() { return $this->moy_ue; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_etud."\n";
		$res = $res ."id_competence:".$this->id_competence."\n";
		$res = $res ."moy_UE:".$this->moy_ue."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
