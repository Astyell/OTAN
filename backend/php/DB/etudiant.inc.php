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

	private string		$n_etud;
    private string		$n_ip;
    private string		$nom_etu;
    private string		$prenom_etu;
    private string		$cursus;
    private string		$bac;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($nE="",$nI="",$nomE="",$preE="",$c="",$b="") 
	{
		$this->n_etud 		= $nE;
		$this->n_ip	 		= $nI;
		$this->nom_etu 		= $nomE;
        $this->prenom_etu	= $preE;
		$this->cursus 		= $c;
		$this->bac 			= $b;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getn_etud		() { return $this->n_etud; }
	public function getN_Ip			() { return $this->n_ip;}
	public function getNom_Etu		() { return $this->nom_etu; }
    public function getPrenom_Etu	() { return $this->prenom_etu; }
	public function getCursus		() { return $this->cursus;}
	public function getBac			() { return $this->bac; }

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "n_etud:".$this->n_etud."\n";
		$res = $res ."n_Ip:".$this->n_ip."\n";
		$res = $res ."nom_Etu:".$this->nom_etu."\n";
        $res = $res ."prenom_Etu:".$this->prenom_etu."\n";
		$res = $res ."cursus:".$this->cursus."\n";
        $res = $res ."bac:".$this->bac."\n";
		$res = $res ."<br/>";
		return $res;
	}
}
?>
