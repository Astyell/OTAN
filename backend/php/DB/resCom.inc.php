<?php
/** resCom.inc.php
* @author  : Alizéa Lebaron, Justine BONDU
* @since   : 27/03/2024
* @version : 1.0.0 - 27/03/2024
*/

class resCom 
{
	/* -------------------------------------- */
	/*               Attributs                */
	/* -------------------------------------- */

	private int		$id_ressource;
	private int		$id_competence;
	private float	$coefr;

	/* -------------------------------------- */
	/*              Constructeur              */
	/* -------------------------------------- */
	
	public function __construct($iR=-1,$iC=-1,$coef=0.0) 
	{
		$this->id_ressource 	= $iR;
		$this->id_competence 	= $iC;
		$this->coefr 	= $coef;
	}

	/* -------------------------------------- */
	/*                Accesseur               */
	/* -------------------------------------- */

	public function getId_ressource	() { return $this->id_ressource; }
	public function getId_competence() { return $this->id_competence;}
	public function getCoef() { return $this->coefr;}

	/* -------------------------------------- */
	/*                 Méthode                */
	/* -------------------------------------- */

	public function __toString() 
	{
		$res = "id_ressource:".$this->id_ressource."\n";
		$res = $res ."id_competence:".$this->id_competence."\n";
		$res = $res ."coefr:".$this->coefr."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>
