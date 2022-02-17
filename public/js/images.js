window.onload = () => {
    // Gestion des boutons supprimer pour image//
    //let links = document.querySelectorAll("[data-delete]")
     var image_materiaux = document.getElementsByClassName('images_materiaux');
     var image_projet = document.getElementsByClassName('carousel-item')
        if(image_projet !=null)
        console.log(image_projet.length)
          image_projet[0].classList.add('active');
        
        if(image_materiaux.length > 0)
        document.getElementById('suppImg').style.visibility='visible';
         
}
function hideSuprimerImg(){
    var supp_image=document.getElementById('suppImg')
    supp_image.style.visibility='hidden';
    
}
//for(link of links){
    //link.addEventListener("click", function(e){
       // e.preventDefault()

        // confirmation//
       // if(confirm("Voulez vous supprimer cette image?")){
            //si oui on appelle la methode DELETE//
        //    fetch(this.getAttribute("href"),  {
           //     method : "DELETE",
           //     headers: {
             //       "X-Requested-With": "XMLHttpRequest",
               //     "Content-Type": "application/json"
               // },

                //recupere le token//
              //  body: JSON.stringify({"_token": this.dataset.token})
          //  }).then(
                //Recuperation en JSON
           //     response => response.JSON.stringify()
                
          //  ).then(data => {
           //     if(data.success)
           //         this.parentElement.remove()
          //      else
          //          alert(data.error)
          //  }).catch(e => alert(e))
      //  }

    //})
//}
