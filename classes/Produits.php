<?php
require_once("Mysql.php");
class Produits extends Mysql
{
	// Les attributs priv�s
	private $_id;
	private $_libelle;
    private $_description;
    private $_prix;
    private $_image;
    private $_id_categorie;

	// M�thode magique pour les setters & getters
	public function __get($attribut) {
		if (property_exists($this, $attribut)) 
                return ( $this->$attribut ); 
        else
			exit("Erreur dans la calsse " . __CLASS__ . " : l'attribut $property n'existe pas!");     
    }

    public function __set($attribut, $value) {
        if (property_exists($this, $attribut)) {
            $this->$attribut = (mysqli_real_escape_string($this->get_cnx(), $value)) ;
        }
        else
        	exit("Erreur dans la calsse " . __CLASS__ . " : l'attribut $property n'existe pas!");
    }

	public function details($id)
	{
		$q = "SELECT * FROM produit WHERE id ='$id'";
		$res = $this->requete($q);
		$row = mysqli_fetch_array( $res); 
		$cat = new Produits();
		
		$cat->_id 			= $row['id'];
        $cat->_libelle 		= $row['libelle'];
        $cat->_prix         = $row['prix'];
		$cat->_image 		= $row['image'];
		$cat->_description	= $row['description'];
        $cat->_id_categorie	= $row['id_categorie'];
        
		return $cat;
	}


	public function liste()
	{
		$q = "SELECT * FROM produit ORDER BY libelle";
		$list_cat = array(); // Tableau VIDE
		$res = $this->requete($q);
		while($row = mysqli_fetch_array( $res)){
			$cat = new Produits();

			$cat->_id 			= $row['id'];
            $cat->_libelle 		= $row['libelle'];
           $cat->_description	= $row['description'];
             $cat->_prix         = $row['prix'];
            $cat->_image 		= $row['image'];
           
		
			$list_cat[]=$cat;
		}
		
		return $list_cat;
	}
	
	public function ajouter()
	{
	    $q = "INSERT INTO produit(id, libelle, description, prix, image) VALUES 
	  		(  null	, '$this->_libelle', '$this->_description','$this->_prix', '$this->_image')";
		$res = $this->requete($q);
		return mysqli_insert_id($this->get_cnx());
	}
	
	public function modifier(){
		$q = "UPDATE produit SET
			  libelle 	= '$this->_libelle',
			  description = '$this->_description',
                prix= '$this->_prix',
                 image = IF('$this->_image' = '', image, '$this->_image') 
			  WHERE id = '$this->_id' ";
	  
		$res = $this->requete($q);
		return $res;
	}

	public function supprimer($id){
		$q = "DELETE FROM produit WHERE id = '$id'";
		$res = $this->requete($q);
		return $res;
	}	 
}
?>