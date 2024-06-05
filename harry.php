<?php
 
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require_once 'connessione.php';  
?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harry Potter  </title>
    <link rel="stylesheet" href="harry.css">
    <script src="harry.js" defer></script>
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


</head>
<body>
<nav>
   <p> Entra nel magico mondo di Harry Potter</p>
</nav>
<header> 
  <div id='menu'>
            <img class='logo' src="img/239157da497dd0e7dd53d0425821b165.jpg">
                   <a href="http://localhost/index.php">Home</a>
                <a href="http://localhost/apigoogle.php">Ricerca Libri</a>
                <a href="http://localhost/good.php">Ricerca Manga</a>
                <a href="http://localhost/manu.php">Inserimento manuale</a>
                  <a href="http://localhost/pers.php">Pagina Personale</a>

                    
            </div>
<a href="https://localhost/logout.php">
        <button>Logout</button>
    </a>

</header> 

 <section id='leggere'>
        <img class='fot' src="img\70d6e7f2443194d12c8f6209b7a40dbe.jpg">
        <div class='paragrafo'>
            <p class='titolo2'> Ma perche' leggere Harry Potter? </p>
            <p>Harry Potter  e' una serie avvincente che offre una straordinaria combinazione di avventura, magia e crescita personale. 
            I libri esplorano temi universali come l'amicizia, il coraggio e la lotta tra il bene e il male, il tutto ambientato in un mondo ricco di dettagli
            fantastici e personaggi indimenticabili. Inoltre, la serie ha una narrativa coinvolgente che cattura l'immaginazione di lettori di tutte le eta'.</p>
        </div>

    </section>

<section>
<p class="tito"> Serie completa dei libri </p>
    <div id='amati' class="carousel">
        <div class="carousel-items">
            <div class='ma'>
                 <img src="img\c92a015888956fc976738ae58eb7eb88.jpg">
                <span class='tit'> Harry Potter e la pietra filosofale</span>
                <p>Harry Potter, un giovane orfano, scopre di essere un mago quando riceve una lettera per
                frequentare la Scuola di Magia e Stregoneria di Hogwarts. Qui, fa amicizia con Ron Weasley e
                Hermione Granger e scopre il suo destino come "Il ragazzo che e' sopravvissuto", dopo aver 
                sconfitto il malvagio mago Voldemort quando era solo un bambino.</p>
            </div>
            <div class='ma'>
                 <img src="img\69ddbfee0751824b1741a520ac3889ea.jpg">
                <span class='tit'> Harry Potter e la camera dei segreti </span>
                <p>Harry torna a Hogwarts per il secondo anno e scopre che qualcuno sta liberando creature
                pericolose all'interno della scuola, collegato a una misteriosa Camera dei Segreti.
                Con l'aiuto dei suoi amici, Harry cerca di risolvere il mistero e fermare la minaccia che 
                terrorizza la scuola.</p>
            </div>
            <div class='ma'>
                <img src="img\378d297c4f128f4ffd059699c107dfe6.jpg">
                <span class='tit'> Harry potter e il prigioniero di azkaban </span>
                <p>Harry scopre che Sirius Black, un pericoloso criminale, e' scappato dalla prigione
                di Azkaban e si crede che sia in cerca di vendetta contro di lui. Nel frattempo, nuove 
                informazioni sul passato di Harry vengono alla luce mentre il mistero si infittisce.</p>
            </div>
            <div class='ma'>
                           <img src="img\66ca681acf564417ac238874ccff97d5.jpg">
                <span class='tit'> Harry Potter e il calice di fuoco </span>
                <p>Harry viene selezionato per partecipare al Torneo Tremaghi, una competizione magica
                per studenti di tre scuole di magia diverse. Tuttavia, scopre che il torneo e' stato
                manipolato per riportare in vita Voldemort e affronta prove sempre più pericolose per 
                proteggere se stesso e gli altri.</p>
            </div>
            <div class='ma'>
                <img src="img\cc8e5d8856395938694be7e1a478ca3f.jpg">
                <span class='tit'> Harry potter e l'ordine della fenice </span>
                <p>Harry ritorna a Hogwarts per il suo quinto anno e forma un gruppo segreto, l'Ordine della
                Fenice, per combattere Voldemort e i suoi seguaci, i Mangiamorte. Questo libro introduce 
                anche il Ministero della Magia, che rifiuta di credere al ritorno di Voldemort.</p>
            </div>
            <div class='ma'>
                <img src="img\d85543587285a4a8c92d2738d5812e2a.jpg">
                <span class='tit'> Harry Potter e il principe mezzosangue </span>
                <p>Harry inizia il suo sesto anno a Hogwarts e apprende piu' dettagli sul passato di
                Voldemort attraverso i ricordi raccolti da un misterioso libro di pozioni appartenuto al 
                "Principe Mezzosangue". Nel frattempo, Voldemort intensifica la sua ricerca di potere.</p>
            </div>
            <div class='ma'>
                   <img src="img\36a3b6716d8bb3acc85fbc9d24815945.jpg">
                <span class='tit'> Harry Potter e i doni della morte </span>
                <p>In questo libro finale, Harry, Ron e Hermione si mettono alla ricerca degli Horcrux,
                oggetti in cui Voldemort ha nascosto pezzi della sua anima per diventare immortale. 
                La loro missione li porta a vivere avventure pericolose mentre la guerra tra il bene e 
                il male raggiunge il suo culmine.</p>
            </div>
        </div>
        <button class="sinistra" onclick="prevSlide()"></button>
        <button class="destra" onclick="nextSlide()"></button>
    </div>
</section>


 <section id='leggere'>
        <img class='fot' src="img\25b725a272d1a56686f043098d432e7e.jpg">
        <div class='paragrafo'>
            <p class='titolo2'> J.K Rowling  </p>
            <p>Joanne Rowling, nota con lo pseudonimo J.K. Rowling e' nata Yate, in Inghilterra il 31 luglio 1965 ed e' cresciuta a Chepstow dove ha frequentato la scuola.
Poi si e' trasferita per frequentare l'universita' di Exter e si e' laureata in Francese e Lettere Classiche.
Una volta laureata si e' trasferita a Londra dove, tra le altre cose, ha lavorato per Amnesty International.
Ha cominciato a scrivere la prima storia di Harry Potter durante un viaggio in treno e ha continuato a lavorare alle sue avventure nei cinque anni successivi.
Si e' trasferita in Portogallo dove ha insegnato inglese. Si e' sposata nel 1992 e nel 1993 ha avuto una bambina, Jessica. Poco dopo ha divorziato e lei e Jessica sono tornate nel Regno Unito e sono andate a vivere a Edimburgo. 
Qui Joanne ha terminato di scrivere il primo libro di Harry Potter: Harry Potter e la pietra filosofale.
Dovo aver ricevuto tre rifiuti dai primi editori, il libro e' stato finalmente pubblicato dalla Bloomsbury Children's Book nel giugno del 1997.
L'editore preferiva che non si capisse se l' era un uomo o una donna, cosi' Joanne ha scelto di usare lo preudonimo J.K. pensando alla K di Kathleen che era in
nome della sua nonna paterna..
Dai sette romanzi di Harry Potter sono stati tratti otto film (l'ultimo e' stato diviso in due parti).
</p>
        </div>

    </section>
      <p class='riga'> </p>

<div class="container">
    <div>
    <p class="testo">      
    Curioso di scoprire cosa fanno gli incantesimi di questo magico mondo? 
    Scrivi nella barra l'incantesimo che vuoi cercare e divertiti a replicarli!
    </p>
        <input type="text" id="incantesimo" placeholder="Inserisci il nome dell'incantesimo">
        <button onclick="incantesimo()">Cerca</button>
    </div>
    </div>
    <p class='riga'> </p>
    <div class="container">
    <div>
         <p class="testo">      
    Vuoi sapere la razza o la casata del tuo personaggio preferito? </br> 
    Semplice, cercalo!
    </p>
        <input type="text" id="carattere" placeholder="Inserisci il nome del personaggio">
        <button onclick="carattere()">Cerca</button>
    </div>
   </div>
    <div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <div id="modal-body"></div>
    </div>
</div>
</div>
 <p class='riga'> </p>
 <p class="testo">      
   Scopri alcuni dei personaggi piu' amati della serie!
    </p>
    <div class='container'>
    <button id="openModal"> Clicca qui !</button>
    </div>
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <img id="modalImage" src="" alt="Photo">
            <p id="testo"></p>
        </div>
        <div id="tasti">
        <button id="prevPhoto">Previous</button>
        <button id="nextPhoto">Next</button>
                <button id="closeModal">Close</button>
                </div> 
    </div>

    <footer>
    </footer>

</body>
</html>
