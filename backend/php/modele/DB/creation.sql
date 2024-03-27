DROP TABLE identifiant CASCADE;

DROP TABLE etudiant CASCADE;
DROP TABLE annee CASCADE;
DROP TABLE competence CASCADE;
DROP TABLE semestre CASCADE;
DROP TABLE ressource CASCADE;
DROP TABLE etuSem CASCADE;
DROP TABLE noteComp CASCADE;
DROP TABLE etuRes CASCADE;
DROP TABLE etuAnn CASCADE;
DROP TABLE resCom CASCADE;

CREATE TABLE etudiant(
   n_etud VARCHAR(50),
   n_IP VARCHAR(50) NOT NULL,
   nom_etu VARCHAR(50) NOT NULL,
   prenom_Etu VARCHAR(50) NOT NULL,
   cursus VARCHAR(50) NOT NULL,
   bac VARCHAR(50) NOT NULL,
   PRIMARY KEY(n_Etud),
   UNIQUE(n_IP)
);

CREATE TABLE annee(
   id_annee INT,
   PRIMARY KEY(id_annee)
);

CREATE TABLE competence(
   id_competence VARCHAR(50),
   PRIMARY KEY(id_competence)
);

CREATE TABLE identifiant(
   identifiant VARCHAR(50),
   mdp VARCHAR(50) NOT NULL,
   estAdmin BOOL NOT NULL,
   PRIMARY KEY(identifiant)
);

CREATE TABLE semestre(
   id_semestre INT,
   id_annee INT NOT NULL,
   PRIMARY KEY(id_semestre),
   FOREIGN KEY(id_annee) REFERENCES annee(id_annee)
);

CREATE TABLE ressource(
   id_ressource VARCHAR(50),
   id_semestre INT NOT NULL,
   PRIMARY KEY(id_ressource),
   FOREIGN KEY(id_semestre) REFERENCES semestre(id_semestre)
);

CREATE TABLE etuSem(
   n_Etud VARCHAR(50),
   id_semestre INT,
   TP VARCHAR(50) NOT NULL,
   TD VARCHAR(50),
   nbAbsInjust VARCHAR(50),
   nbAbsJusti VARCHAR(50) NOT NULL,
   moy_Gene DECIMAL(15,2) NOT NULL,
   nb_UE VARCHAR(50),
   alternant BOOL,
   PRIMARY KEY(n_Etud, id_semestre),
   FOREIGN KEY(n_Etud) REFERENCES etudiant(n_Etud),
   FOREIGN KEY(id_semestre) REFERENCES semestre(id_semestre)
);

CREATE TABLE noteComp(
   n_Etud VARCHAR(50),
   id_competence VARCHAR(50),
   moy_UE DECIMAL(15,2),
   PRIMARY KEY(n_Etud, id_competence),
   FOREIGN KEY(n_Etud) REFERENCES etudiant(n_Etud),
   FOREIGN KEY(id_competence) REFERENCES competence(id_competence)
);

CREATE TABLE etuRes(
   n_Etud VARCHAR(50),
   id_ressource VARCHAR(50),
   moy DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(n_Etud, id_ressource),
   FOREIGN KEY(n_Etud) REFERENCES etudiant(n_Etud),
   FOREIGN KEY(id_ressource) REFERENCES ressource(id_ressource)
);

CREATE TABLE etuAnn(
   n_Etud VARCHAR(50),
   id_annee INT,
   bonus DECIMAL(15,2),
   parcours VARCHAR(50) NOT NULL,
   admission VARCHAR(50),
   PRIMARY KEY(n_Etud, id_annee),
   FOREIGN KEY(n_Etud) REFERENCES etudiant(n_Etud),
   FOREIGN KEY(id_annee) REFERENCES annee(id_annee)
);

CREATE TABLE resCom(
   id_ressource VARCHAR(50),
   id_competence VARCHAR(50),
   coefR DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(id_ressource, id_competence),
   FOREIGN KEY(id_ressource) REFERENCES ressource(id_ressource),
   FOREIGN KEY(id_competence) REFERENCES competence(id_competence)
);

