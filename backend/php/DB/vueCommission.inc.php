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

	private String 	$n_ip;
	private String 	$nom;
	private String	$prenom;
	private String	$cursus;
	private String	$ue;
	private float	$moy;


	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($i="",$n="",$p="",$c="",$u="",$m=0.0) 
	{
		$this->n_ip		= $i;
		$this->nom 		= $n;
		$this->prenom 	= $p;
		$this->cursus 	= $c;
		$this->ue 		= $u;
		$this->moy	 	= $m;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getNip		() { return $this->n_ip;}
	public function getNom		() { return $this->nom;}
	public function getPrenom	() { return $this->prenom;}
	public function getCursus	() { return $this->cursus;}
	public function getUE		() { return $this->ue;}
	public function getMoy		() { return $this->moy;}

	public function getInfo($num)
	{
		switch ($num) 
		{
			case 0 : return $this->nom;
			case 1 : return $this->prenom;
			case 2 : return $this->cursus;
			case 3 : return $this->ue;
			case 4 : return $this->moy;
		}
		return null;
	}

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	/*public function __toString() 
	{
		$res = "id_semestre:".$this->id_semestre."\n";
		$res = $res ."id_annee:".$this->id_annee."\n";
		$res = $res ."<br/>";
		return $res;
	}*/
}
?>
