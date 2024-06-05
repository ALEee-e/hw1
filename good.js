document.getElementById('searchButton').addEventListener('click', function () {
    const query = document.getElementById('searchQuery').value.trim();
    if (!query) {
        alert('Per favore, inserisci una query di ricerca.');
        return;
    }

    fetch(`good.php?query=${encodeURIComponent(query)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Errore nella risposta del server');
            }
            return response.json();
        })
        .then(data => {
            const results = document.getElementById('searchResults');
            results.innerHTML = '';

            if (data.error) {
                const errorMessage = document.createElement('p');
                errorMessage.textContent = `Errore: ${data.error}`;
                results.appendChild(errorMessage);
                return;
            }

            if (data.errors) {
                const errorMessage = document.createElement('p');
                errorMessage.textContent = `Errore: ${data.errors[0].message}`;
                results.appendChild(errorMessage);
                return;
            }

            const mangas = data.data.Page.media;
            mangas.forEach(manga => {
                const mangaElement = document.createElement('div');
                mangaElement.className = 'manga';

                const img = document.createElement('img');
                img.src = manga.coverImage.large;
                img.alt = manga.title.romaji;

                const title = document.createElement('h3');
                title.textContent = manga.title.romaji;

                const description = document.createElement('p');
                description.innerHTML = manga.description;

                const addToFavoritesButton = document.createElement('button');
                addToFavoritesButton.textContent = 'Aggiungi';
                addToFavoritesButton.addEventListener('click', () => openModal(manga));

                mangaElement.appendChild(img);
                mangaElement.appendChild(title);
                mangaElement.appendChild(description);
                mangaElement.appendChild(addToFavoritesButton);

                results.appendChild(mangaElement);
            });
        })
        .catch(error => {
            console.error('Errore durante la richiesta:', error);
            const results = document.getElementById('searchResults');
            results.innerHTML = `<p>Errore: ${error.message}</p>`;
        });
});


function openModal(manga) {
    const modal = document.getElementById('modal');
    const closeButton = document.querySelector('.close-button');
    const annullaButton = document.getElementById('annulla');
    const creaListaButton = document.getElementById('creaLista');
    const nomeNuovaLista = document.getElementById('nomeNuovaLista');

    // Rimuovi i listener duplicati se esistenti
    closeButton.onclick = closeModal;
    annullaButton.onclick = closeModal;

    creaListaButton.addEventListener('click', () => {
        const nomeLista = nomeNuovaLista.value.trim();
        if (!nomeLista) {
            alert('Inserisci il nome della nuova lista.');
            return;
        }

        fetch('good.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ azione: 'crea_lista', nome: nomeLista }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'successo') {
                    alert('Lista creata con successo');
 
                    const listaElement = document.createElement('div');
                    listaElement.className = 'lista';
                    listaElement.textContent = nomeLista;
                    listaElement.addEventListener('click', () => aggiungiAMangaLista(manga, data.lista_id));
                    const listeContainer = document.getElementById('liste');
                    listeContainer.appendChild(listaElement);

                    
                    closeModal();
                } else {
                    alert(`Errore: ${data.message}`);
                }
            });
    });

    modal.style.display = 'flex';

    fetch('good.php?azione=ottieni_liste')
        .then(response => response.json())
        .then(liste => {
            const listeContainer = document.getElementById('liste');
            listeContainer.innerHTML = '';
            liste.forEach(lista => {
                const listaElement = document.createElement('div');
                listaElement.className = 'lista';
                listaElement.textContent = lista.nome;
                listaElement.addEventListener('click', () => aggiungiAMangaLista(manga, lista.id));
                listeContainer.appendChild(listaElement);
            });
        });
}

function closeModal() {
    modal.style.display = 'none';
}

function aggiungiAMangaLista(manga, listaId) {
    fetch(`good.php?azione=verifica_manga&lista_id=${listaId}&manga_id=${manga.id}`)
        .then(response => response.json())
        .then(data => {
            if (data.presente) {
                alert('Il manga è già presente in questa lista.');
                return;
            }

            fetch('good.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    azione: 'aggiungi_a_lista',
                    lista_id: listaId,
                    manga_id: manga.id,
                    titolo: manga.title.romaji,
                    autore: manga.title.english,
                    thumbnail: manga.coverImage.large,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'successo') {
                        alert('Manga aggiunto con successo ai preferiti');
                    } else {
                        alert(`Errore: ${data.message}`);
                    }
                });
        });
}

function mostraAlert(messaggio, tipo) {
 
    const vecchiAvvisi = document.querySelectorAll('.alert');
    vecchiAvvisi.forEach(alert => document.body.removeChild(alert));

     const alertBox = document.createElement('div');
    alertBox.className = `alert ${tipo}`;
    alertBox.textContent = messaggio;

    document.body.appendChild(alertBox);

     alertBox.offsetHeight;
    alertBox.classList.add('mostra');

    setTimeout(() => {
        alertBox.classList.remove('mostra');
        setTimeout(() => {
            document.body.removeChild(alertBox);
        }, 500);  
    }, 3000);
}