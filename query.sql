CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    data_di_nascita DATE NOT NULL,
    comune VARCHAR(50) NOT NULL

);

CREATE TABLE liste (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES utenti(id)
);
CREATE TABLE libro(
    id INT AUTO_INCREMENT PRIMARY KEY,
    lista_id INT NOT NULL,
    book_id VARCHAR(255) NOT NULL,
    titolo VARCHAR(255) NOT NULL,
    autore VARCHAR(255),
    thumbnail VARCHAR(255),
    FOREIGN KEY (lista_id) REFERENCES liste(id)
);
CREATE TABLE manga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lista_id INT NOT NULL,
    manga_id VARCHAR(255) NOT NULL,
    titolo VARCHAR(255) NOT NULL,
    autore VARCHAR(255) ,
    thumbnail VARCHAR(255) NOT NULL,
      FOREIGN KEY (lista_id) REFERENCES liste(id)
);
