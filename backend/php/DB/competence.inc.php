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

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iC) 
	{
		$this->id_competence 	= $iC;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_competence() { return $this->id_competence; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "id_competence:".$this->id_competence."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
