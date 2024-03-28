<?php

/** etuAnn.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class etuAnn 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private string		$n_etud;
	private int			$id_annee;
    private string		$parcours;
	private string		$admission;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE="",$iA=-1,$p="",$a="") 
	{
		$this->n_etud	 	= $nE;
		$this->id_annee 	= $iA;
        $this->parcours 	= $p;
		$this->admission 	= $a;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud	() { return $this->n_etud; }
	public function getId_annee	() { return $this->id_annee;}
    public function getParcours	() { return $this->parcours; }
	public function getAdmission() { return $this->admission;}

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_etud."\n";
		$res = $res ."id_annee:".$this->id_annee."\n";
        $res = $res ."parcours:".$this->parcours."\n";
		$res = $res ."admission:".$this->admission."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
