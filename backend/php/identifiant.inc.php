<?php

class identifiant 
{
	private string		$identifiant;
	private string		$mdp;
    private boolean		$estAdmin;
	
	public function __construct($i,$m,$eA=false) 
	{
		$this->identifiant = $i;
		$this->mdp = $m;
		$this->estAdmin = $eA;
	}

	public function getIdentifiant() { return $this->identifiant; }
	public function getMdp() { return $this->mdp;}
	public function getEstAdmin() { return $this->estAdmin; }

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
