<?php

/** identidiant.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class identifiant 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private string		$identifiant;
	private string		$mdp;
    private bool		$estAdmin;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($i,$m,$eA=false) 
	{
		$this->identifiant 	= $i;
		$this->mdp 			= $m;
		$this->estAdmin 	= $eA;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getIdentifiant	() { return $this->identifiant; }
	public function getMdp			() { return $this->mdp;}
	public function getEstAdmin		() { return $this->estAdmin; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "identifiant:".$this->identifiant."\n";
		$res = $res ."mdp:".$this->mdp."\n";
		$res = $res ."estAdmin:".$this->estAdmin."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
