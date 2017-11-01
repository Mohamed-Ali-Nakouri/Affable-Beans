<?php
require_once("../classes/Produits.php");
require_once("../classes/Util.php");

@$libelle = $_POST['libelle'];
@$description = $_POST['description'];
@$id = $_POST['id'];
@$prix=$_POST['prix'];

if( !empty($libelle) && !empty($description) ) 
{
	$cat = new Produits();
	$util = new Util();
	$cat->_libelle = $libelle;
	$cat->_description = $description;
	$cat->_image = $util->upload('image', "../upload");
	$cat->_prix = $prix;
	if( empty($id) ) 	// Ajout
		$id = $cat->ajouter();
	else				// Modification
	{
		$cat->_id = $id;
		$cat->modifier();
	}
	
	header("Location: produit_liste.php");
} 
else 
	exit('Tous les champs sont obligatoires !!');
?>