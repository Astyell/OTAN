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

	private String		$id_competence;
	private String		$id_semestre;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iC="",$iS="") 
	{
		$this->id_competence 	= $iC;
		$this->id_semestre 		= $iS;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_competence() { return $this->id_competence; }
	public function getId_Semestre() { return $this->id_semestre; }

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
