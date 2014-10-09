<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php

	include_once 'Article.php';
	include_once 'liste.php';
	include_once 'Client.php';
	include_once 'Magasin.php';
	
	class Affichage{

		public static function BarreNav(){
			echo '<nav class="navbar navbar-inverse" >
					<div class="row">
          <div class="col-lg-offset-1 col-lg-10">
                    <div class = "col-lg-9">
                    
						<img id="logo" src="inQontrol_qdance.png" style="max-height:75px; max-width:75px; float:left;"/>
                        <h1 class="col-lg-3" style="color:red;">Life Organizer</h1>
                        <div class="col-lg-offset-1 col-lg-7" style="margin-top:1%">
                        <ul class="nav navbar-nav">
				            <li class="active" >
								<a href="PromoSphere.php">Accueil</a>
							</li>
                        
							<li >
								<a href="PromoSphere.php?a=SignalerProm">Signaler une promotion</a>
							</li>
				
							<li >
								<a href="PromoSphere.php?a=toutePromo">Les promotions</a>
							</li>
							<li >
								<a href="PromoSphere.php?a=AfficherPanier">Liste de shopping</a>
							</li>
						</ul> 
            </div>
                        
                        
					</div>
                    
					';
					
			if(isset($_SESSION['profil'])){
				echo	'	<div class="col-lg-2">
							Bonjour ' . $_SESSION['profil']['prenom'] .

							'<a href="PromoSphere.php?a=Deconnexion"><p class="log">Deconnexion</p></div>

						</div>
                        </div>
					</nav>';	
			}else{
				echo	'	<div class="col-lg-2">
              <br>
							<a class="col-lg-6" href="PromoSphere.php?a=Connexion"><p class="log">Se connecter</p></a>
							<a class="col-lg-6" href="PromoSphere.php?a=Inscription"><p class="log">S\'inscrire</p></a>
						</div>
            </div>
					</nav>';
			}
		}
		
		
		public static function Accueil(){

      echo ' <div class="col-lg-offset-1 col-lg-10">
      <div id="lastProd">Les derniers produits signalés...</div><br> 
            
      
      ';
			Affichage::AfiAll();
      
      echo '</div>';

		}
		
		public static function Connexion(){
			
			echo '<div>';
				echo '<form action="Connexion.php" method="post">

					<label for="Login">Login</label>
					<input type="text" name="login" value=""/>

					<label for="mdp">Mot de passe</label>
					<input type="password" name="mdp" value=""/>

					<input type="submit" value="Se connecter"/>
					</form>';			
			echo '</div>';
		}
		
		public static function Deconnexion(){
			unset($_SESSION['profil']);
			session_unset();
			session_destroy();
			header ('Location: PromoSphere.php?a=accueil');
		}
		
		public static function Inscription(){
			echo '<div>';
			echo '<form action="Inscription.php" method="post">
			
				<label for="Login">Login</label>
				<input type="text" name="login" value=""/>
				
				<label for="mdp">Mot de passe</label>
				<input type="password" name="mdp" value=""/>
				
				<label for="prenom">Prenom</label>
				<input type="text" name="prenom" value=""/>
					
				<label for="nom">Nom</label>
				<input type="text" name="nom" value=""/>

				<label for="email">Email</label>
				<input type="text" name="email" value=""/>

				<input type="submit" value="S\'inscrire"/>
				</form>';
			echo '</div>';
		}
		
		public static function Afi($art){

								

			echo '<div class="col-lg-offset-1 col-lg-10" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black;">'; 	 
					echo	'<div class="row" style="background:#F0EAE7;"><div class="bigbox">
								<h2 class="col-lg-offset-2 col-lg-3">';
								echo 'Nos produits :';
               echo '</h2>
								<div class="row"> <!-- box affichant les informations du produit -->
                 <div class="col-lg-offset-4 col-lg-8">             
                  <div class="col-lg-3" >
                  <br><br>
							       <!-- <img class="img-circle" src="data:jpg;base64,'.base64_encode($art->photo).'" /> -->
                                    <img class="img" src="LO.jpg" />
						      </div>  <!-- fin de div contenant img --> 
									<div class="col-lg-offset-3 col-lg-5" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black; background:#B8ABA5;"><div class="descr-box" style="font-size:inherit; text-shadow:inherit; font-weight:bolder;">
                  <br> Notre solution logiciel "Life Organizer" vous propose un calendrier innovant et intelligent. En effet celui ci vous permet d\'organiser vos journées à la minute près avec précision. 
                  
									</div></div>
                                   

								</div>
                </div>
                <hr />
								
								<div class="col-lg-offset-2 col-lg-8"><div class="descr-box">
                                Description : '.																						
									$art->description.' <br>';
                  echo 'Taille(s): '. $art->taille_dispo .'     <br>';
									echo '     Couleur: '. $art->couleur .'<br><br>';
                  
								echo'</div></div>
                <br><br>
 
							</div>
							</div>
					</div>';
		}
		
		public static function AfiAll(){				  
				foreach (Article::findAll() as $art) {
					Affichage::Afi($art);
				}
		}
		
		public static function AfiLs(){
			if(isset($_SESSION['profil'])){
				$temp = 0;
				foreach(Liste::findArtByIdCli($_SESSION['profil']['userid']) as $lis){
					$a = new Article();
					$a = Article::findById($lis->id_article);
					Affichage::Afi($a);
				}
				if($temp == 0){
					echo 'Votre liste est vide';
				}
				
			}
		
		}
		
		public static function AjoutListe($idart){
				liste::ajoute($idart,$_SESSION['profil']['userid']);
		}
		
		public static function NouvelPromo(){
			echo '<div class="col-lg-12">';
			echo '<form action="NvPromo.php" method="post">
			  
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="cbarre">code barre</label>
        </div>
        <div class="col-lg-2">
        <input type="text" name="cbarre" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="narticle">Nom de l\'article</label>
        </div>
        <div class="col-lg-2">
        <input type="text" name="narticle" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="prix">Prix origine</label>				
        </div>
        <div class="col-lg-2">
        <input type="text" name="prix" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="prixprom">Prix promotion</label>
        </div>
        <div class="col-lg-1">	
        <input type="text" name="prixprom" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="desc">Description</label>
        </div>
        <div class="col-lg-1">
        <textarea name="desc" rows="5" cols="50" > Description </textarea> 
        </div>
        </div>
				<br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="image">Image produit</label>			
        </div>
        <div class="col-lg-1">
        <input type="file" name="photo" />
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="taille">Taille disponible</label>			
        </div>
        <div class="col-lg-1">
        <input type="text" name="taille" value=""/>
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="datedeb">Date début</label>				
        </div>
        <div class="col-lg-1">
        <input type="date" name="datedeb">
        </div>
        </div>
				<br><br>
				
        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">
				<label for="datefin">Date fin</label>
        </div>
        <div class="col-lg-1">
        <input type="date" name="datefin">
        </div>
        </div>
				<br>

        <div class="row">
        <div class="col-lg-offset-4 col-lg-1">				
        </div>
        <div class="col-lg-1">
        <input type="submit" value="Valider promo"/>
        </div>
        </div>
				</form>';
			echo '</div>';
		}
	}

?>