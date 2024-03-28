<?php

/** annee.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class annee 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private int		$id_annee;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iA=-1) 
	{
		$this->id_annee = $iA;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_annee() { return $this->id_annee; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "id_annee:".$this->id_annee."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
