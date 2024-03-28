<?php

/** semestre.inc.php
* @author  : Matéo
* @since   : 28/03/2024
* @version : 1.0.0 - 28/03/2024
*/

class vueCommission 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private String	$rang;
	private String 	$nom;
	private String	$prenom;
	private String	$cursus;
	private String	$ue;
	private float	$moy;
	

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iS=-1,$iA=-1) 
	{
		$this->id_semestre 	= $iS;
		$this->id_annee 	= $iA;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_semestre	() { return $this->id_semestre; }
	public function getId_annee		() { return $this->id_annee;}

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "id_semestre:".$this->id_semestre."\n";
		$res = $res ."id_annee:".$this->id_annee."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
