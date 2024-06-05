let indice = 0;
const slides = document.getElementsByClassName('ma');

function showSlide(index) {
    for (let i = 0; i < slides.length; i++) {
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

function incantesimo() {
    const spellName = document.getElementById('incantesimo').value.toLowerCase();
    const url = 'https://hp-api.onrender.com/api/spells';

    fetch(url)
        .then(response => response.json())
        .then(spells => {
            const results = spells.filter(spell => spell.name.toLowerCase().includes(spellName));
            displayResults(results, 'spell');
        })
        .catch(error => {
            console.error('Errore nella richiesta:', error);
        });
}

function carattere() {
    const characterName = document.getElementById('carattere').value.toLowerCase();
    const url = 'https://hp-api.onrender.com/api/characters';

    fetch(url)
        .then(response => response.json())
        .then(characters => {
            const results = characters.filter(character => character.name.toLowerCase().includes(characterName));
            displayResults(results, 'character');
        })
        .catch(error => {
            console.error('Errore nella richiesta:', error);
        });
}

function openModal() {
    document.getElementById('modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function displayResults(results, type) {
    const modalBody = document.getElementById('modal-body');
    modalBody.innerHTML = ''; // Puliamo prima di avere nuovi risultati

    if (results.length === 0) {
        const noResult = document.createElement('p');
        noResult.textContent = 'Nessun risultato trovato per la tua ricerca.';
        modalBody.appendChild(noResult);
        openModal();
        return;
    }

    results.forEach(result => {
        const resultItem = document.createElement('div');
        resultItem.classList.add('result-item');

        if (type === 'spell') {
            const spellName = document.createElement('h3');
            spellName.textContent = result.name;
            const spellDescription = document.createElement('p');
            spellDescription.textContent = result.description;
            resultItem.appendChild(spellName);
            resultItem.appendChild(spellDescription);
        } else if (type === 'character') {
            const characterName = document.createElement('h3');
            characterName.textContent = result.name;
            const characterHouse = document.createElement('p');
            characterHouse.textContent = `Casa: ${result.house || 'N/A'}`;
            const characterSpecies = document.createElement('p');
            characterSpecies.textContent = `Specie: ${result.species || 'N/A'}`;
            resultItem.appendChild(characterName);
            resultItem.appendChild(characterHouse);
            resultItem.appendChild(characterSpecies);
        }

        modalBody.appendChild(resultItem);
    });

    openModal();
}

window.onclick = function (event) {
    const modal = document.getElementById('modal');
    if (event.target == modal) {
        closeModal();
    }
}



document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("myModal");
    const modalImg = document.getElementById("modalImage");
    const captionText = document.getElementById("testo");
    const span = document.getElementsByClassName("close")[0];
    const openModalBtn = document.getElementById("openModal");
    const prevBtn = document.getElementById("prevPhoto");
    const nextBtn = document.getElementById("nextPhoto");
    const closeModalBtn = document.getElementById("closeModal");


    const photos = [
        { url: 'img/1df7316694c2bfb68711ed6776dde9fa.jpg', testo: 'Ron Weasly' },  
        { url: 'img/99db7bf540461f0af1925221630fadb8.jpg', testo: ' Harry Potter' },
        { url: 'img/223267b9570fe865c81c4be4f912d4a4.jpg', testo: 'Dobby' },
        { url: 'img/24c266e104842cc1a035cdcb41b31031.jpg', testo: ' Albus Silente' },
        { url: 'img/61bd3b077ea9b77fe1f9e1654dda3a79.jpg', testo: 'Ginny Weasly' },
        { url: 'img/675ea5e1ebef1457c4b63b94647c0e2b.jpg', testo: 'Severus Piton' },
        { url: 'img/dd10baa36f8edd16d572acebe674e409.jpg', testo: ' Hermione Granger' },
        { url: 'img/4c9226983224ba3bc894119f4a57e1d9.jpg', testo: 'Minerva McGranit' },
        { url: 'img/9a19b77081487a97f3e91700c064763b.jpg', testo: 'Voldemort' },
        { url: 'img/53f5e4138350c7852c98e8fb53ae5d7c.jpg', testo: 'Luna Loovegod' }

    ];

    let currentIndex = 0;

    openModalBtn.onclick = function () {
        openModal();
    }

    span.onclick = function () {
        modal.style.display = "none";
    }
    closeModalBtn.onclick = function () {
        modal.style.display = "none";
    }
    prevBtn.onclick = function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateModalImage();
        }
    }

    nextBtn.onclick = function () {
        if (currentIndex < photos.length - 1) {
            currentIndex++;
            updateModalImage();
        }
    }

    function openModal() {
        currentIndex = 0;
        updateModalImage();
        modal.style.display = "block";
    }

    function updateModalImage() {
        modalImg.src = photos[currentIndex].url;
        captionText.textContent = photos[currentIndex].testo;
    }
});
