document.getElementById('inserisciButton').addEventListener('click', function () {
    const titolo = document.getElementById('titolo').value;
    const autore = document.getElementById('autore').value;
    const thumbnail = document.getElementById('thumbnail').value;
    const tipo = document.getElementById('tipo').value;

    if (!titolo) {
        alert('inserisci tutti i campi');
        return;
    }

    apriFinestraListe(titolo, autore, thumbnail, tipo);
});

function apriFinestraListe(titolo, autore, thumbnail, tipo) {
    window.tempBookData = {
        titolo: titolo,
        autore: autore,
        thumbnail: thumbnail,
        tipo: tipo
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
    caricaListe(titolo, autore, thumbnail, tipo);
}

function caricaListe(titolo, autore, thumbnail, tipo) {
    fetch('manu.php?azione=ottieni_liste')
        .then(response => response.json())
        .then(data => {
            const listeDiv = document.getElementById('liste');
            listeDiv.innerHTML = '';
            data.forEach(lista => {
                const nomeLista = document.createElement('div');
                nomeLista.textContent = lista.nome;
                nomeLista.className = 'nome-lista';
                nomeLista.onclick = function () {
                    aggiungiALista(lista.id, titolo, autore, thumbnail, tipo);
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
    fetch('manu.php', {
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
                const { titolo, autore, thumbnail, tipo } = window.tempBookData;
                aggiungiALista(data.lista_id, titolo, autore, thumbnail, tipo);
            } else {
                mostraAlert(data.message);  
            }
        });
}

function aggiungiALista(listaId, titolo, autore, thumbnail, tipo) {
    const bookId = `${tipo}_${Date.now()}`; 

    fetch(`manu.php?azione=verifica_libro&lista_id=${listaId}&book_id=${bookId}`)
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
                        autore: autore,
                        thumbnail: thumbnail
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'successo') {
                            mostraAlert('Libro aggiunto con successo!', 'successo');
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

    // Forziamo   reflow per far si che l'elemento sia aggiunto al DOM
    alertBox.offsetHeight;
    alertBox.classList.add('mostra');

    setTimeout(() => {
        alertBox.classList.remove('mostra');
        setTimeout(() => {
            document.body.removeChild(alertBox);
        }, 500); 
    }, 3000);
}