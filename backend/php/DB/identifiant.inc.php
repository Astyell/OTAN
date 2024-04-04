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

	private int 		$id;
	private string		$identifiant;
	private string		$mdp;
    private bool 		$estadmin;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($id=0, $i="",$m="",$eA=false) 
	{
		$this->id           = $id;
		$this->identifiant 	= $i;
		$this->mdp 			= $m;
		$this->estadmin 	= $eA;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId	        () { return $this->id; }
	public function getIdentifiant	() { return $this->identifiant; }
	public function getMdp			() { return $this->mdp;}
	public function getEstAdmin		() { return $this->estadmin; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "identifiant:".$this->identifiant."\n";
		$res = $res ."mdp:".$this->mdp."\n";
		$res = $res ."estAdmin:".$this->estadmin."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
