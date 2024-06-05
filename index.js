// Funzione per gestire il click sui bottoni
function bottoni(event) {
    const bottone = event.currentTarget;
    if (bottone === document.getElementById("bot1")) {
        
        document.getElementById('bott1').classList.remove('hidden');
        document.getElementById('bott2').classList.add('hidden');
        const img = document.querySelector('header');
        img.style.backgroundImage = "url('img/f33920dd5897ff1262f5b2e1ca787c68.jpg')"
    }
    else if (bottone === document.getElementById("bot2")) {
        
        document.getElementById('bott1').classList.add('hidden');
        document.getElementById('bott2').classList.remove('hidden');
        document.getElementById('bott2').classList.remove('hidden');
        const img = document.querySelector('header');
        img.style.backgroundImage = "url('img/3bc3e65a562b7c6ecaab38e996bbc5a5.jpg')";
    }
}

const bot1 = document.getElementById("bot1");
const bot2 = document.getElementById("bot2");



//bottone1 facciamo in modo che prima viene caricato tutto e poi vanno eseguite le funzioni 
window.addEventListener("DOMContentLoaded", (event) => {
    const bot1 = document.getElementById("bot1");
    if (bot1) {
        bot1.addEventListener("click", bottoni);
    }
});

// bottone2
window.addEventListener("DOMContentLoaded", (event) => {
    const bot2 = document.getElementById("bot2");
    if (bot2) {
        bot2.addEventListener("click", bottoni);
    }
});
 
let indice = 0;
const slides = document.getElementsByClassName('ma');
console.log("[slides]: ", slides);

function showSlide(index) { 
    for (var i = 0; i < slides.length; i++) {
        console.log(slides[i]);
        slides[i].classList.add('hidden');
    }

    for (let i = index; i < Math.min(index + 4, slides.length); i++) {
       
       slides[i].classList.remove('hidden');
    }
}

function prevSlide() {
    if (indice === 0) return;
    indice--;
    showSlide(indice);
}

function nextSlide() {
    if (indice >= slides.length - 3) return;
    indice++;
    showSlide(indice);
}

showSlide(indice);

let indice2 = 0;
const slides2 = document.getElementsByClassName('ok');


function showSlide2(index) {
  
    for (var i = 0; i < slides2.length; i++) {
        slides2[i].classList.add('hidden');
    }

    for (let i = index; i < Math.min(index + 4, slides2.length); i++) {
       
       slides2[i].classList.remove('hidden');
    }
}


function prevSlide2() {
    if (indice2 === 0) return;
    indice2--;
    showSlide2(indice2);
}

function nextSlide2() {
    if (indice2 >= slides2.length - 3) return;
    indice2++;
    showSlide2(indice2);
}

showSlide2(indice2);

const DOWN_ARROW = 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/1083533/down-arrow.png';
const RIGHT_ARROW = 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/1083533/forward-arrow.png';

function toggle(event) {
    const details = document.querySelector('.details');
    const image = event.currentTarget.querySelector('img');
    const text = event.currentTarget.querySelector('span');

    isVisible = !isVisible;
    if (isVisible) {
        details.classList.remove('hidden');
        image.src = DOWN_ARROW;
        text.textContent = 'Nascondi dettagli';
    } else {
        details.classList.add('hidden');
        image.src = RIGHT_ARROW;
        text.textContent = 'Mostra altro';
    }
}
let isVisible = false;


// tutto viene compilato e poi viene fatta la funzione 
window.addEventListener("DOMContentLoaded", (event) => {
    const detailToggle = document.querySelector('.show-details');
    if (detailToggle) {
        detailToggle.addEventListener('click', toggle);
    }
});


