<?php

/** etudiant.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class etudiant 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private string		$n_Etud;
    private string		$n_Ip;
    private string		$nom_Etu;
    private string		$prenom_Etu;
    private string		$cursus;
    private string		$bac;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE,$nI,$nomE,$preE,$c,$b) 
	{
		$this->n_Etud 		= $nE;
		$this->n_Ip	 		= $nI;
		$this->nom_Etu 		= $nomE;
        $this->prenom_Etu	= $preE;
		$this->cursus 		= $c;
		$this->bac 			= $b;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getN_Etud		() { return $this->n_Etud; }
	public function getN_Ip			() { return $this->n_Ip;}
	public function getNom_Etu		() { return $this->nom_Etu; }
    public function getPrenom_Etu	() { return $this->prenom_Etu; }
	public function getCursus		() { return $this->cursus;}
	public function getBac			() { return $this->bac; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_Etud:".$this->n_Etud."\n";
		$res = $res ."n_Ip:".$this->n_Ip."\n";
		$res = $res ."nom_Etu:".$this->nom_Etu."\n";
        $res = $res ."prenom_Etu:".$this->prenom_Etu."\n";
		$res = $res ."cursus:".$this->cursus."\n";
        $res = $res ."bac:".$this->bac."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
