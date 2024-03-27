<?php

/** competence.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class competence 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private int		$id_competence;
    private string	$nomC;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iC,$nC) 
	{
		$this->id_competence 	= $iC;
		$this->nomC 			= $nC;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_competence() { return $this->id_competence; }
	public function getN_Ip			() { return $this->n_Ip;}

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "id_competence:".$this->id_competence."\n";
		$res = $res ."nomC:".$this->nomC."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
