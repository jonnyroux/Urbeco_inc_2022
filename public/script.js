// pour la page de la galerie produit vue par l'utilisatrice
function hide(){
  var connexion=document.getElementById('connexion')
  connexion.classList.add('hidden');

  
}
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



// appeler la fonction au chargement de la page

window.onload = () => {
  displayPics()
  // Gestion des boutons supprimer pour image//
  //let links = document.querySelectorAll("[data-delete]")
   
    
   var image_projet = document.getElementsByClassName('carousel-item')
      if (image_projet !=null){
        if(image_projet.length > 0){
      console.log(image_projet.length)
        image_projet[0].classList.add('active');
}
}
}







