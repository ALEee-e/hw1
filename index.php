 
<!DOCTYPE html>
 

<html>
<head>
    <title>
      Home
    </title>    
    <link rel="stylesheet" href="index.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="index.js"> </script>
</head>
<body>
    <nav>
        <div class='header-top'>
            siediti e sfoglia un libro
        </div>
        <div id='menu'>
            <img class='logo' src="img/239157da497dd0e7dd53d0425821b165.jpg">
            <div class='pannello'>
                <a href="http://localhost/apigoogle.php">Ricerca Libri</a>
                <a href="http://localhost/pers.php">Pagina Personale</a>
                <a href="http://localhost/harry.php">Harry Potter</a>
                <a href="http://localhost/good.php">Ricerca Manga</a>
                <a href="http://localhost/good.php">Inserimento Libri/Manga</a>
            </div>
            <div>
 <?php
                session_start();
 
                if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] ==! true) {
                    echo '<a href="http://localhost/login.php"><button class="login">Login</button></a>';
                    echo '<a href="http://localhost/register.php"><button class="registrazione">Registrazione</button></a>';
                } else {
                       echo '<a href="http://localhost/logout.php"><button class="logout">Logout</button></a>';
                }
                ?>
    </div>
        </div>

    </nav>
    <header>

        <div class='copertita'>
            <div id='bott1'>
                <p class='titol'> Harry Potter </p>
                Scopri il magico mondo di questo piccolo maghetto
                <a href="http://localhost/harry.php">
                    <p class='tasto'>  SCOPRI DI PIÙ   </p>
                </a>
            </div>

            <div id='bott2' class='hidden'>
                <p class='titol'> Trilogia delle Gemme </p>
                Immergiti in questo mondo tra passato e futuro
            </div>

        </div>
        <p class='bottoni'>
            <botton id="bot1">  </botton>
            <botton id="bot2"> </botton>
        </p>
    </header>
    <section>
        <div id='galleria'>
            <div class='galleria'>
                <img src=" img/2e3d4fb79d1e5a88292d22356b58f0f9.jpg">
                Fantasy
            </div>
            <div class='galleria'>
                <img src="img/1446e5f57f2c03105b2bcf0ece219317.jpg">
                Horror
            </div>
            <div class='galleria'>
                <img src="img/aca0111f79dfb9c620e31d9d03535b46.jpg">
                Avventura
            </div>
            <div class='galleria'>
                <img src="img/97e8ab50cf63797a8d87d6ac3d04e144.jpg">
                Mistero
            </div>
            <div class='galleria'>
                <img src="img/0be66f5e523b6a03d7cecf73832a60eb.jpg">
                Romantico
            </div>
        </div>
        <botton> </botton>
        <div class="show-details">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1083533/forward-arrow.png" />
            <span>Mostra altro</span>
        </div>
        <div class='details hidden'>
            <div id='galleria2'>
                <div class='galleria'>
                    <img src="img/f0a69a4601bb6d416858c4602783d4b4.jpg">
                    FanFiction
                </div>
                <div class='galleria'>
                    <img src="img/f1f4ef8c5089c9eb68c2a99c76906039.jpg">
                    Comico
                </div>
                <div class='galleria'>
                    <img src="img/bfa2aab4d3de040974402e7698a4b2bb.jpg">
                    Distopico
                </div>
                <div class='galleria'>
                    <img src="img/8873a670d2fdb51e400accc9ecee610e.jpg">
                    Storico
                </div>
                <div class='galleria'>
                    <img src="img/432c90f1bceb458ef67c6519a3ac7d5a.jpg">
                    Rosa
                </div>
            </div>
        </div>
    </section>

    <p class='riga'> </p>


    <section>
        <p class='tit'> I PIÙ AMATI </p>

        <div id='amati' class="carousel">
            <div class="carousel-items">
                <div class='ma'>
                    <img src="img/5c78f2041b5256174db6a752f4f29099.jpg">
                    Harry Potter
                </div>
                <div class='ma'>
                    <img src="img/8cbe8ed8cf542a0ced03d5da0b6a0021.jpg">
                    <p>
                        La canzone d'Achille
                    </p>
                </div>
                <div class='ma'>
                    <img src="img/891e45f90da38355065074eef8bfcd2b.jpg">
                    <p> L'attraversaspecchi</p>
                </div>
                <div class='ma'>
                    <img src="img/f3860d40509116c4fecc4f0e35be62a7.jpg">
                    <p>
                        Il ritratto di Dorian Graty
                    </p>
                </div>
                <div class='ma'>
                    <img src="img/dd7e6e7b8b2da104cb2eaae417a29188.jpg">
                    <p>
                        Percy Jackson
                    </p>
                </div>

                <div class='ma'>
                    <img src="img/2a6aac7334e85b8aff2854971c1e963a.jpg">
                    <p>
                        Shadowhunters
                    </p>

                </div>
                <div class='ma'>
                    <img src="img/0c9769a19ef35388d569f3f2df5a68a0.jpg">
                    <p>    Narnia </p>
                </div>
            </div>
            <button class="sinistra" onclick="prevSlide()">-</button>
            <button class="destra" onclick="nextSlide()">-</button>
        </div>
    </section>

    <section id='leggere'>
        <img class='fot' src="img\0e5dd5d1a69378f93f3b8e8a22545324.jpg">
        <div class='paragrafo'>
            <p class='titolo2'> PERCHE' LEGGERE </p>
            <p>I libri insegnano a comprendere il mondo, ad approfondire, a riflettere, a pensare. Propongono la calma e la temperanza. Le storie permettono di accedere alla sfera dei sentimenti e delle emozioni dei protagonisti e in questo modo aumentano l'alfabetizzazione emotiva.</p>
        </div>

    </section>


    <section >
        <p class='tit'>  DICONO DI NOI </p>
        <div id='amati' class="carousel">
            <div class="carousel-items">
                <div class='ok'>
                    <img src="img\38e54f0113ad805857d1ae8a3aa7140b.jpg">
                    <span class='tit'>Emily Dicknson </br> </span>
                    “Non esiste un vascello veloce come un libro, per portarci in terre lontane, né corsieri come una pagina, di poesia che si impenna – questa traversata può farla anche il povero senza oppressione di pedaggio – tanto è frugale il carro dell’anima”
                </div>
                <div class='ok'>
                    <img src="img\a8472e3668009f84c83f4121202a5293.jpg">
                    <span class='tit'>Virginia Woolf </br></span>
                    “Talvolta penso che il paradiso sia leggere continuamente, senza fine”

                </div>
                <div class='ok'>
                    <img src="img\b4de07e6ae8e61dab6e358a1b8588f0d.jpg">
                    <span class='tit'> Jane Austen </br> </span>
                    “Per quanto mi riguarda, se un libro è scritto bene, lo trovo sempre troppo breve,”

                </div>
                <div class='ok'>
                    <img src="img\7a1314a98cf9772e362141cadc855e04.jpg">
                    <span class='tit'>  Gustave Flaubert </br> </span>
                    “Non leggete, come fanno i bambini, per divertirvi, o, come gli ambiziosi, per istruirvi. No, leggete per vivere.”

                </div>
                <div class='ok'>
                    <img src="img\b35aeca873956f1c781a3de4f4ac9f4f.jpg">
                    <span class='tit'>
                        VITTORIO ALFIERI </br>
                    </span>
                    “Leggere, come io l'intendo, vuol dire profondamente pensare.”
                </div>
                <div class='ok'>
                    <img src="img\46887c3d9d88b8aa32bf15e014cfe4bd.jpg">
                    <span class='tit'>  Stephen King </br> </span>
                    “Quando stai male, quando ti senti sopraffatto, quando sei certo che non ce la farai, apri un libro e leggilo tutto. E se ancora non stai meglio prendine un altro e ricomincia.”

                </div>

                <div class='ok'>
                    <img src="img\c61d0873d311ea821f3b8f47ad77368f.jpg">
                    <span class='tit'>   Harry Potter </br> </span>
                    “- Draco: Perché porti gli occhiali!? </br>
                    - Harry: Ah, ehm... Leggevo.</br>
                    - Draco: Leggevi!? Perché, sai leggere?”

                </div>

            </div>
            <button class="sinistra" onclick="prevSlide2()">-</button>
            <button class="destra" onclick="nextSlide2()">-</button>
        </div>
    </section>

    <footer>

        <div id='informazioni'>
            <div class='pannellof'>
                <span class='strong'> Generi </span>
                <p>Fantasy </p>
                <p>Horror</p>
                <p>Avventura</p>
                <p>Mistero</p>
                <p>Romantico</p>
                <p>Fanfiction</p>
                <p>Comico</p>
                <p>Distopico</p>
                <p>Comico</p>
            </div>

            <div class='pannellof'>
                <span class='strong'>Servizi</span>
                <p>Gestione libri e manga</p>
                <p>Ricerca libri </p>
                 <p>Ricerca Manga </p>
                 <p>Pagina harry Potter </p>
                 <p>Inserimento manuale libri</p>

            </div>
            <div class='pannellof'>
                <strong>Alcuni autori </strong>
                <p> Kerstin Gier</p>
                <p> Veronica Roth</p>
                <p>Rick Riordan</p>
                <p>J. K. Rowling</p>
                <p>Luigi Pirandello</p>
                <p>Alessandro Manzoni</p>
                
            </div>
        </div>

        <div class='fine'>
            <span> Copyright © 2024 </span>

        </div>

    </footer>

</body>
</html>