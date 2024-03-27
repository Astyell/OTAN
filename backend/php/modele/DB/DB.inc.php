<?php

class DB
{
	private static $instance = null; //mémorisation de l'instance de DB pour appliquer le pattern Singleton
	private $connect = null; //connexion PDO à la base

	/************************************************************************/
	//	Constructeur gerant  la connexion à la base via PDO
	//	NB : il est non utilisable a l'exterieur de la classe DB
	/************************************************************************/
	private function __construct()
	{
		// Connexion à la base de données
		$connStr = 'pgsql:host=localhost port=5432 dbname=sm220306'; // A MODIFIER ! 
		try {
			// Connexion à la base
			$this->connect = new PDO($connStr, 'sm220306', 'mateo2705'); //A MODIFIER !
			// Configuration facultative de la connexion
			$this->connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "probleme de connexion :" . $e->getMessage();
			return null;
		}
	}

	/************************************************************************/
	//	Methode permettant d'obtenir un objet instance de DB
	//	NB : cet objet est unique pour l'exécution d'un même script PHP
	//	NB2: c'est une methode de classe.
	/************************************************************************/
	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			try {
				self::$instance = new DB();
			} catch (PDOException $e) {
				echo $e;
			}
		} //fin IF
		$obj = self::$instance;

		if (($obj->connect) == null) {
			self::$instance = null;
		}
		return self::$instance;
	} //fin getInstance	 

	/************************************************************************/
	//	Methode permettant de fermer la connexion a la base de données
	/************************************************************************/
	public function close()
	{
		$this->connect = null;
	}

	/************************************************************************/
	//	Methode uniquement utilisable dans les méthodes de la class DB 
	//	permettant d'exécuter n'importe quelle requête SQL
	//	et renvoyant en résultat les tuples renvoyés par la requête
	//	sous forme d'un tableau d'objets
	//	param1 : texte de la requête à exécuter (éventuellement paramétrée)
	//	param2 : tableau des valeurs permettant d'instancier les paramètres de la requête
	//	NB : si la requête n'est pas paramétrée alors ce paramètre doit valoir null.
	//	param3 : nom de la classe devant être utilisée pour créer les objets qui vont
	//	représenter les différents tuples.
	//	NB : cette classe doit avoir des attributs qui portent le même que les attributs
	//	de la requête exécutée.
	//	ATTENTION : il doit y avoir autant de ? dans le texte de la requête
	//	que d'éléments dans le tableau passé en second paramètre.
	//	NB : si la requête ne renvoie aucun tuple alors la fonction renvoie un tableau vide
	/************************************************************************/
	private function execQuery($requete, $tparam, $nomClasse)
	{
		try 
		{
			//on prépare la requête
			$stmt = $this->connect->prepare($requete);
			//on indique que l'on va récupére les tuples sous forme d'objets instance de Client
			$stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $nomClasse);
			//on exécute la requête
			if ($tparam != null) {
				$stmt->execute($tparam);
			} else {
				$stmt->execute();
			}
			//récupération du résultat de la requête sous forme d'un tableau d'objets
			$tab = array();
			$tuple = $stmt->fetch(); //on récupère le premier tuple sous forme d'objet
			if ($tuple) {
				//au moins un tuple a été renvoyé
				while ($tuple != false) {
					$tab[] = $tuple; //on ajoute l'objet en fin de tableau
					$tuple = $stmt->fetch(); //on récupère un tuple sous la forme
					//d'un objet instance de la classe $nomClasse	       
				} //fin du while	           	     
			}
			return $tab;
		} catch (\Throwable $th) 
		{
			
		}
		
	}

	/************************************************************************/
	//	Methode utilisable uniquement dans les méthodes de la classe DB
	//	permettant d'exécuter n'importe quel ordre SQL (update, delete ou insert)
	//	autre qu'une requête.
	//	Résultat : nombre de tuples affectés par l'exécution de l'ordre SQL
	//	param1 : texte de l'ordre SQL à exécuter (éventuellement paramétré)
	//	param2 : tableau des valeurs permettant d'instancier les paramètres de l'ordre SQL
	//	ATTENTION : il doit y avoir autant de ? dans le texte de la requête
	//	que d'éléments dans le tableau passé en second paramètre.
	/************************************************************************/
	private function execMaj($ordreSQL, $tparam)
	{
		try 
		{
			$stmt = $this->connect->prepare($ordreSQL);
			$res = $stmt->execute($tparam); //execution de l'ordre SQL      	     
			return $stmt->rowCount();		
		} catch (\Throwable $th) 
		{
			 /*echo "erreur " . $ordreSQL . " : " . $th . "<br><br>";*/
		}
	}

	/*************************************************************************
	 * Fonctions qui peuvent être utilisées dans les scripts PHP
	 *************************************************************************/

	/*-------------*/
	/*  ETUDIANT   */
	/*-------------*/

	public function getAllEtudiant()
	{
		$requete = 'select * from etudiant';
		return $this->execQuery($requete, null, 'Etudiant');
	}

	public function insertEtudiant($n_etud, $n_ip, $nom_etu, $prenom_etu, $cursus, $bac)
	{
		$requete = 'insert into etudiant values(?,?,?,?,?,?)';
		$tparam = array($n_etud, $n_ip, $nom_etu, $prenom_etu, $cursus, $bac);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  ANNEE      */
	/*-------------*/

	public function getAllAnnee()
	{
		$requete = 'select * from annee';
		return $this->execQuery($requete, null, 'Annee');
	}

	public function insertAnnee($id_annee)
	{
		$requete = 'insert into annee values(?)';
		$tparam = array($id_annee);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  COMPETENCE */
	/*-------------*/

	public function getAllCompetence()
	{
		$requete = 'select * from competence';
		return $this->execQuery($requete, null, 'Competence');
	}

	public function insertCompetence($id)
	{
		$requete = 'insert into competence values(?)';
		$tparam = array($id);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/* IDENTIFIANT */
	/*-------------*/

	public function getAllIdentifiant()
	{
		$requete = 'select * from identifiant';
		return $this->execQuery($requete, null, 'Identifiant');
	}

	public function insertIdentifiant($id, $mdp, $estAdmin)
	{
		$requete = 'insert into identifiant values(?,?,?)';
		$tparam = array($id, $mdp, $estAdmin);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  SEMESTRE   */
	/*-------------*/

	public function getAllSemestre()
	{
		$requete = 'select * from semestre';
		return $this->execQuery($requete, null, 'Semestre');
	}

	public function insertSemestre($id_sem, $id_ann)
	{
		$requete = 'insert into semestre values(?,?)';
		$tparam = array($id_sem, $id_ann);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  RESSOURCE  */
	/*-------------*/

	public function getAllRessource()
	{
		$requete = 'select * from ressource';
		return $this->execQuery($requete, null, 'Ressource');
	}

	public function insertRessource($id_res, $id_sem)
	{
		$requete = 'insert into ressource values(?,?)';
		$tparam = array($id_res, $id_sem);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  ETU/SEMES  */
	/*-------------*/

	public function getAllEtuSem()
	{
		$requete = 'select * from etusem';
		return $this->execQuery($requete, null, 'EtuSem');
	}

	public function insertEtuSem($n_etud, $id_sem, $tp, $td, $nbAbsInjust, $nbAbsJust, $moy, $nb_UE, $altern)
	{
		$requete = 'insert into etusem values(?,?,?,?,?,?,?,?,?)';
		$tparam = array($n_etud, $id_sem, $tp, $td, $nbAbsInjust, $nbAbsJust, $moy, $nb_UE, $altern);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  NOTE/COMP  */
	/*-------------*/

	public function getAllNoteComp()
	{
		$requete = 'select * from notecomp';
		return $this->execQuery($requete, null, 'NoteComp');
	}

	public function insertNoteComp($n_etud, $id_comp, $moy_UE)
	{
		$requete = 'insert into notecomp values(?,?,?)';
		$tparam = array($n_etud, $id_comp, $moy_UE);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  ETU/RES    */
	/*-------------*/

	public function getAllEtuRes()
	{
		$requete = 'select * from etures';
		return $this->execQuery($requete, null, 'EtuRes');
	}

	public function insertEtuRes($n_etud, $id_res, $moy)
	{
		$requete = 'insert into etures values(?,?,?)';
		$tparam = array($n_etud, $id_res, $moy);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  ETU/ANN    */
	/*-------------*/

	public function getAllEtuAnn()
	{
		$requete = 'select * from etuann';
		return $this->execQuery($requete, null, 'EtuAnn');
	}

	public function insertEtuAnn($n_etud, $id_ann, $bonus, $parcours, $admission)
	{
		$requete = 'insert into etuann values(?,?,?,?,?)';
		$tparam = array($n_etud, $id_ann, $bonus, $parcours, $admission);
		return $this->execMaj($requete, $tparam);
	}

	public function updateEtuAnn($n_etud, $id_ann, $admission)
	{
		$requete = 'update etuann set admission = ? where n_etud = ? and id_annee = ?';
		$tparam = array($admission, $n_etud, $id_ann);
		return $this->execMaj($requete, $tparam);
	}

	/*-------------*/
	/*  RES/COM    */
	/*-------------*/

	public function getAllResCom()
	{
		$requete = 'select * from rescom';
		return $this->execQuery($requete, null, 'ResCom');
	}

	public function insertResCom($id_res, $id_com, $coef)
	{
		$requete = 'insert into rescom values(?,?,?)';
		$tparam = array($id_res, $id_com, $coef);
		return $this->execMaj($requete, $tparam);
	}

	//Client
	/*
	public function getClient($idcli)
	{
		$requete = 'select * from client where ncli = ?';
		return $this->execQuery($requete, array($idcli), 'Client');
	}

	public function updateAdrClient($idcli, $adr)
	{
		$requete = 'update client set ville = ? where ncli = ?';
		$tparam = array($adr, $idcli);
		return $this->execMaj($requete, $tparam);
	}

	public function deleteClient($idcli)
	{
		$requete = 'delete from client where ncli = ?';
		$tparam = array($idcli);
		return $this->execMaj($requete, $tparam);
	}

	//Produit
	public function getProduits()
	{
		$requete = 'select * from produit';
		return $this->execQuery($requete, null, 'Produit');
	}

	public function getProduitsTri($choixTri)
	{
		$requete = 'select * from produit order by ' . $choixTri;
		return $this->execQuery($requete, null, 'Produit');
	}

	public function insertProduit($idpro, $lib, $coul, $qs)
	{
		//try{
		$requete = 'insert into produit values(?,?,?,?)';
		$tparam = array($idpro, $lib, $coul, $qs);
		return $this->execMaj($requete, $tparam);
		//}catch(PDOException e){}
		//return null;
	}

	public function deleteProduit($idpro)
	{
		self::$instance->deleteAchat($idpro);
		$requete = 'delete from produit where np = ?';
		$tparam = array($idpro);
		return $this->execMaj($requete, $tparam);
	}

	public function updateProduit($idpro, $nom, $coul, $qs)
	{
		$requete = 'update produit set lib = ?, coul = ?, qs = ? where np = ?';
		$tparam = array($nom, $coul, $qs, $idpro);
		return $this->execMaj($requete, $tparam);
	}

	//Achat
	public function getAchats()
	{
		$requete = 'select * from achat';
		return $this->execQuery($requete, null, 'Achat');
	}

	public function insertAchat($idcli, $idpro, $qa)
	{
		$requete = 'insert into achat values(?,?,?)';
		$tparam = array($idcli, $idpro, $qa);
		return $this->execMaj($requete, $tparam);
	}

	public function deleteAchat($idpro)
	{
		$requete = 'delete from achat where np = ?';
		$tparam = array($idpro);
		return $this->execMaj($requete, $tparam);
	}*/

}

?>