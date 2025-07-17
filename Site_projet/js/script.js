$(document).ready(function(){
    
         
   
    // Bouton UP
    
    $(document).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.btnup').fadeIn();
        } else {
            $('.btnup').fadeOut();
        }
    });

    // Lien Menu

    $('.linkhover').hover(function () {
    $(this).css({
        'font-weight': 'bold',
        'text-decoration': 'underline',
        'text-underline-offset': '3px'
    });
    }, function() {
        $(this).css({
            'font-weight': '',
            'text-decoration': 'none',
            'text-underline-offset': ''
        });
  });


    // ACTIVER SWIPE SUR LA PREMIERE IMAGE DU CAROUSSEL DE L'ACCUEIL
    
  if ($('body').hasClass('accueil')) {
    const carousel = document.querySelector('#carouselExampleDark');

    if (carousel) {
      const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);
      bsCarousel.to(0);
    }
  }

  



//PORTFOLIO 
    
    // "Images Cachées" Portfolio

    $('.suiteportfo').hide();

   
    // Bouton pour Montrer/Cacher "Images Cachées"
    
    function afficherPhotos() {
        $(".suiteportfo").fadeIn(2000); 
        $(".voirplus").text("Voir Moins...").off("click").on("click", cacherPhotos);
    }

    function cacherPhotos() {
        $(".suiteportfo").fadeOut(1000);
        $(".voirplus").text("Voir Plus...").off("click").on("click", afficherPhotos);
    }

    $(".voirplus").on("click", afficherPhotos)

    // Afficher le modal lors du clique sur une photo

    $(".imgportfo").click(function () {
    let index = $(this).data("index");

    // Redémarre le carrousel avec un nouveau Bootstrap.Carousel
    const carouselElement = document.getElementById("carousel");
    const carousel = bootstrap.Carousel.getInstance(carouselElement) || new bootstrap.Carousel(carouselElement);

    carousel.to(index);
    });


//FORMULAIRES

    $('.inform').hover(function () {
        $(this).css({
            'background-color':'#f3f3f3',
            'border' : '1px solid black'
        });        
    },function () {
        $(this).css({
            'background-color':'white',
            'border' : ''
        });
        
    });


     
    
});

document.addEventListener("DOMContentLoaded", function () {
  
  // Liste des formulaires à valider
  const formulaires = [
    document.getElementById("form-contact"),
    document.getElementById("form-index")
  ];

  formulaires.forEach((formulaire) => {
    if (!formulaire) return;

    formulaire.addEventListener("submit", function (e) {
      const prenom = formulaire.querySelector('[name="prenom"]').value.trim();
      const nom = formulaire.querySelector('[name="nom"]').value.trim();
      const email = formulaire.querySelector('[name="email"]').value.trim();
      const message = formulaire.querySelector('[name="message"]').value.trim();

      const regexNomPrenom = /^[A-Za-zÀ-ÿ \-']+$/;
      const erreurs = [];

      if (!regexNomPrenom.test(prenom)) {
        erreurs.push("Prénom invalide.");
      }

      if (!regexNomPrenom.test(nom)) {
        erreurs.push("Nom invalide.");
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        erreurs.push("Email invalide.");
      }

      if (message.length < 5) {
        erreurs.push("Message trop court.");
      }

      if (erreurs.length > 0) {
        e.preventDefault();
        alert(erreurs.join("\n"));
      }
    });
  });
});
