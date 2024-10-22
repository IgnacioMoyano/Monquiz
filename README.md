# Monquiz
 Juego web de preguntas sobre cultura general

CREATE TABLE usuario (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    Apellido VARCHAR(255) NOT NULL,
    fecha_nac DATE NOT NULL,
    tipo_cuenta INT NOT NULL,
    genero VARCHAR(50) NOT NULL,
    pais VARCHAR(255) NOT NULL,
    ciudad VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    imagen VARCHAR(255),
    validado TINYINT(1) NOT NULL,
    token VARCHAR(255),
    cantidad_preg_vistas INT DEFAULT 0,
    cantidad_preg_correctas INT DEFAULT 0
);
