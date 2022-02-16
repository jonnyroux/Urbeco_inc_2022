// pour la page de la galerie produit vue par l'utilisatrice

function displayPics() {

  var liens = document.getElementsByClassName('mini_pict'); // variable tous les liens contenu dans galerie_mini
  var big_photo = document.getElementById('big_pict'); // id big_pict qui est récupéré, photo en taille normale
  if (big_photo != null) {
    big_photo.src=liens[0].src

                                                // Une boucle parcourant l'ensemble des liens contenu dans galerie_mini
    for (var i = 0 ; i < liens.length ; ++i) {

                                        // Au clique sur ces liens
      liens[i].onclick = function() {

        big_photo.src = this.src;      // On change l'attribut src de l'image en le remplaçant par la valeur du lien
        return false; // Et pour finir on inhibe l'action réelle du lien
      };
    }
  }

  
}

function afficherSuprimerImg(){
  document.getElementById('suppImg').style.visibility='false';

  getFocus();
}

// appeler la fonction au chargement de la page

window.onload = displayPics;

// pour permettre de remplir le panier de l'utilisatrice


