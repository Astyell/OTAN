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

	private string		$n_Etud;
	private int			$id_competence;
    private float		$moy_UE;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE,$iC,$mUE) 
	{
		$this->n_Etud 			= $nE;
		$this->id_competence 	= $iC;
		$this->moy_UE 			= $mUE;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud		() { return $this->n_Etud; }
	public function getId_competence() { return $this->id_competence;}
	public function getMoy_UE		() { return $this->moy_UE; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_Etud."\n";
		$res = $res ."id_competence:".$this->id_competence."\n";
		$res = $res ."moy_UE:".$this->moy_UE."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
