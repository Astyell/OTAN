<?php

/** ressource.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class ressource 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private String	$id_ressource;
    private int		$id_semestre;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iR="",$iS=-1) 
	{
		$this->id_ressource = $iR;
        $this->id_semestre 	= $iS;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_ressource	() { return $this->id_ressource; }
    public function getId_semestre	() { return $this->id_semestre; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "id_ressource:".$this->id_ressource."\n";
        $res = $res ."id_semestre:".$this->id_semestre."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>