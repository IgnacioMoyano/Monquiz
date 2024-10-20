# Monquiz
 Juego web de preguntas sobre cultura general

CREATE TABLE usuario (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    fecha_nac DATE NOT NULL,
    genero VARCHAR(50) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    validado TINYINT(1) NOT NULL,
    token BIGINT NOT NULL
);
