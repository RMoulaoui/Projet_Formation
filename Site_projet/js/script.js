$(document).ready(function(){
    
    // Ouvrir la section cachée 
    $("#btn-voir-projet").on("click", function () {
        $("#details-projet")
            .hide()
            .removeClass("d-none")
            .fadeIn(400, function () {
                this.scrollIntoView({ behavior: "smooth" });
            });
    }); 

    // Fermer la section projet 
    $("#btn-fermer-projet").on("click", function () {
        $("#details-projet").fadeOut(300, function () {
            $(this).addClass("d-none");
        });
        $("html, body").animate({ scrollTop: 0 }, 300);
    });
   
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

  //Caroussel page d'accueil

  const track = document.querySelector(".custom-carousel-track");
  const slides = document.querySelectorAll(".custom-carousel-slide");
  const prevButton = document.querySelector(".custom-prev");
  const nextButton = document.querySelector(".custom-next");

  let currentIndex = 0;

  function updateCarousel() {
  const gap = parseInt(getComputedStyle(track).gap || "20", 10);
  const slideWidth = slides[0].getBoundingClientRect().width;
  const offset = -(currentIndex * (slideWidth + gap));
  track.style.transform = `translateX(${offset}px)`;
  // Met à jour les points de pagination
  document.querySelectorAll(".custom-dot").forEach((dot, index) => {
  dot.classList.toggle("active", index === currentIndex);
});
}

 nextButton.addEventListener("click", function () {
  currentIndex = (currentIndex + 1) % slides.length;
  updateCarousel();
});

prevButton.addEventListener("click", function () {
  currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  updateCarousel();
});

const dotsContainer = document.querySelector(".custom-carousel-dots");

// Pagination 

slides.forEach((_, index) => {
  const dot = document.createElement("div");
  dot.classList.add("custom-dot");
  if (index === currentIndex) dot.classList.add("active");

  dot.addEventListener("click", () => {
    currentIndex = index;
    updateCarousel();
  });

  dotsContainer.appendChild(dot);
});


// Swipe mobile
 
let startX = 0;
let isSwiping = false;

track.addEventListener("touchstart", function (e) {
  startX = e.touches[0].clientX;
  isSwiping = true;
});

track.addEventListener("touchmove", function (e) {
  if (!isSwiping) return;
  const deltaX = e.touches[0].clientX - startX;

  if (Math.abs(deltaX) > 50) {
    if (deltaX < 0) {
      currentIndex = (currentIndex + 1) % slides.length;
    } else {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    }
    updateCarousel();
    isSwiping = false;
    startX = e.touches[0].clientX; // reset point de départ
  }
});

track.addEventListener("touchend", function () {
  isSwiping = false;
});




  window.addEventListener("resize", updateCarousel);
  updateCarousel(); // initialise le positionnement

  
  // Liste des formulaires à valider
  const formulaires = [
    document.getElementById("form-contact"),
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

      // Vérifie si un champ est vide
    if (!prenom || !nom || !email || !message) {
      erreurs.push("Veuillez remplir tous les champs obligatoires.");
    } else {
      // Validation du prénom et nom
      if (!regexNomPrenom.test(prenom)) erreurs.push("Prénom invalide.");
      if (!regexNomPrenom.test(nom)) erreurs.push("Nom invalide.");

      // Validation email
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) erreurs.push("Email invalide.");

      // Validation message
      if (message.length < 5) erreurs.push("Message trop court.");
    }

      if (erreurs.length > 0) {
        e.preventDefault();
        alert(erreurs.join("\n"));
      }
    });
  });


    
});
