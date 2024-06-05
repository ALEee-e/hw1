document.getElementById('searchButton').addEventListener('click', function () {
    const query = document.getElementById('searchQuery').value;
    if (!query) {
        alert('Per favore, inserisci una query di ricerca.');
        return;
    }
    fetch(`https://www.googleapis.com/books/v1/volumes?q=${query}`)
        .then(response => response.json())
        .then(data => {
            const results = document.getElementById('results');
            results.innerHTML = '';
            data.items.forEach(libro => {
                const elementoLibro = document.createElement('div');
                elementoLibro.className = 'libro';

                const img = document.createElement('img');
                img.src = libro.volumeInfo.imageLinks?.thumbnail || '';
                img.alt = libro.volumeInfo.title;

                const titolo = document.createElement('h3');
                titolo.textContent = libro.volumeInfo.title;

                const autori = document.createElement('p');
                autori.textContent = libro.volumeInfo.authors?.join(', ') || 'Autore sconosciuto';

                const bottone = document.createElement('button');
                bottone.textContent = 'Aggiungi';
                bottone.onclick = function () {
                    apriFinestraListe(libro.id, libro.volumeInfo.title, libro.volumeInfo.authors?.join(', '), libro.volumeInfo.imageLinks?.thumbnail);
                };

                elementoLibro.appendChild(img);
                elementoLibro.appendChild(titolo);
                elementoLibro.appendChild(autori);
                elementoLibro.appendChild(bottone);

                results.appendChild(elementoLibro);
            });
        });
});

function apriFinestraListe(bookId, titolo, autori, thumbnail) {
    window.tempBookData = {
        bookId: bookId,
        titolo: titolo,
        autori: autori,
        thumbnail: thumbnail
    };
    const modal = document.getElementById('modal');
    const closeButton = modal.querySelector('.close-button');
    closeButton.onclick = function () {
        modal.style.display = 'none';
    };

    const annullaButton = document.getElementById('annulla');
    annullaButton.onclick = function () {
        modal.style.display = 'none';
    };

    modal.style.display = 'flex';
    caricaListe(bookId, titolo, autori, thumbnail);
}

function caricaListe(bookId, titolo, autori, thumbnail) {
    fetch('apigoogle.php?azione=ottieni_liste')
        .then(response => response.json())
        .then(data => {
            const listeDiv = document.getElementById('liste');
            listeDiv.innerHTML = '';
            data.forEach(lista => {
                const nomeLista = document.createElement('div');
                nomeLista.textContent = lista.nome;
                nomeLista.className = 'nome-lista';
                nomeLista.onclick = function () {
                    aggiungiALista(lista.id, bookId, titolo, autori, thumbnail);
                    document.getElementById('modal').style.display = 'none';
                };
                listeDiv.appendChild(nomeLista);
            });
        });
}

document.getElementById('creaLista').onclick = function () {
    const nomeLista = document.getElementById('nomeNuovaLista').value;
    if (nomeLista) {
        creaLista(nomeLista);
    } else {
        mostraAlert('Errore: Il nome della lista non può essere vuoto.');
    }
};

function creaLista(nomeLista) {
    fetch('apigoogle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            azione: 'crea_lista',
            nome: nomeLista
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'successo') {
                caricaListe();  
                const { bookId, titolo, autori, thumbnail } = window.tempBookData;
                aggiungiALista(data.lista_id, bookId, titolo, autori, thumbnail);
            } else {
                mostraAlert(data.message);  
            }
        });
}

function aggiungiALista(listaId, bookId, titolo, autori, thumbnail) {
    fetch(`apigoogle.php?azione=verifica_libro&lista_id=${listaId}&book_id=${bookId}`)
        .then(response => response.json())
        .then(data => {
            if (data.presente) {
                mostraAlert('Il libro è già presente nella lista', 'errore');
            } else {
                fetch('apigoogle.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        azione: 'aggiungi_a_lista',
                        lista_id: listaId,
                        book_id: bookId,
                        titolo: titolo,
                        autore: autori,
                        thumbnail: thumbnail
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'successo') {
                            mostraAlert('Libro aggiunto con successo!', 'success');
                        } else if (data.status === 'errore') {
                            mostraAlert(data.message);  
                        }
                    });
            }
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
