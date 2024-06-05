function caricaListeLibri() {
    fetch('pers.php?azione=ottieni_liste')
        .then(response => response.json())
        .then(data => {
            const listeDiv = document.getElementById('favorites');
            listeDiv.innerHTML = '';
            data.forEach(lista => {
                const listaDiv = document.createElement('div');
                listaDiv.className = 'lista';
                listaDiv.setAttribute('data-lista-id', lista.id);  

                const nomeLista = document.createElement('h3');
                nomeLista.textContent = lista.nome;
                nomeLista.onclick = function () {
                    if (listaDiv.classList.contains('aperta')) {
                        listaDiv.classList.remove('aperta');
                        listaDiv.querySelector('.libri').innerHTML = '';
                    } else {
                        caricaLibri(lista.id, lista.nome, listaDiv);
                        listaDiv.classList.add('aperta');
                    }
                };

                const eliminaListaButton = document.createElement('button');
                eliminaListaButton.textContent = 'Elimina Lista';
                eliminaListaButton.onclick = function () {
                    eliminaTuttaLista(lista.id);  
                };

                const chiudiLista = document.createElement('button');
                chiudiLista.textContent = 'Chiudi Lista';
                chiudiLista.onclick = function () {
                    listaDiv.classList.remove('aperta');
                    listaDiv.querySelector('.libri').innerHTML = '';
                };

                listaDiv.appendChild(nomeLista);
                listaDiv.appendChild(eliminaListaButton);
                listaDiv.appendChild(chiudiLista);
                listaDiv.appendChild(document.createElement('div')).className = 'libri';
                listeDiv.appendChild(listaDiv);
            });
        });
}

function eliminaTuttaLista(listaId) {
    fetch('pers.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            azione: 'elimina_lista',
            lista_id: listaId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'successo') {
                caricaListeLibri();
                mostraAlert('Lista eliminata con successo!', 'success');
            } else if (data.status === 'errore') {
                mostraAlert(data.message, 'errore');  
            }
        })
        .catch(error => {
            mostraAlert('Errore durante l\'eliminazione della lista.', 'errore');
        });
}

function mostraAlert(messaggio, tipo) {
    const vecchiAvvisi = document.querySelectorAll('.alert');
    vecchiAvvisi.forEach(alert => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    });
    const alertBox = document.createElement('div');
    alertBox.className = `alert ${tipo}`;
    alertBox.textContent = messaggio;

    document.body.appendChild(alertBox);

    // Forzo il reflow in modo che l'elemento sia aggiunto al DOM
    alertBox.offsetHeight;
    alertBox.classList.add('mostra');

    setTimeout(() => {
        alertBox.classList.remove('mostra');
        setTimeout(() => {
            if (alertBox.parentNode) {
                alertBox.parentNode.removeChild(alertBox);
            }
        }, 500);  
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
    function caricaInformazioniUtente() {
        fetch('pers.php?azione=ottieni_informazioni_utente')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Impossibile ottenere le informazioni dell\'utente.');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

               
                document.getElementById('username').textContent = data.username;
                document.getElementById('nome').textContent = data.nome;
                document.getElementById('cognome').textContent = data.cognome;
                document.getElementById('email').textContent = data.email;
                document.getElementById('data_di_nascita').textContent = data.data_di_nascita;
                document.getElementById('comune').textContent = data.comune;

            
                document.querySelector('.informazioni-utente').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Errore durante il recupero delle informazioni utente:', error.message);
            });
    }

    function toggleInformazioni() {
        const informazioniUtente = document.querySelector('.informazioni-utente');
        const toggleButton = document.getElementById('toggleInformazioni');

        if (informazioniUtente.classList.contains('hidden')) {
            caricaInformazioniUtente();
            toggleButton.textContent = 'Nascondi Informazioni';
        } else {
            informazioniUtente.classList.add('hidden');
            toggleButton.textContent = 'Mostra Informazioni';
        }
    }

    
    document.getElementById('toggleInformazioni').addEventListener('click', toggleInformazioni);

    // Carica le liste all'avvio della pagina
    caricaListeLibri();  
});


function caricaLibri(listaId, listaNome, listaDiv) {
    fetch(`pers.php?azione=ottieni_preferiti&lista_id=${listaId}`)
        .then(response => response.json())
        .then(data => {
            const preferiti = listaDiv.querySelector('.libri');
          
            data.forEach(item => {
                const elementoLibro = document.createElement('div');
                elementoLibro.className = 'libro';

                const img = document.createElement('img');
                img.src = item.thumbnail;
                img.alt = item.titolo;

                const titolo = document.createElement('h3');
                titolo.textContent = item.titolo;

                const autori = document.createElement('p');
                autori.textContent = item.autore;

                const bottone = document.createElement('button');
                bottone.textContent = 'Rimuovi dalla lista';
                bottone.onclick = function () {
                    rimuoviPreferito(item.book_id);
                };

                elementoLibro.appendChild(img);
                elementoLibro.appendChild(titolo);
                elementoLibro.appendChild(autori);
                elementoLibro.appendChild(bottone);

                preferiti.appendChild(elementoLibro);
            });
        });
}

function rimuoviPreferito(bookId) {
    fetch('pers.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            azione: 'rimuovi_preferito',
            book_id: bookId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'successo') {
                caricaListeLibri();
                mostraAlert('Elemento rimosso con successo!', 'success');
            } else if (data.status === 'errore') {
                mostraAlert(data.message);  
            }
        });
}
