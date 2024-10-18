# Monquiz
 Juego web de preguntas sobre cultura general

Tabla usuario:
CREATE TABLE usuario (
    username VARCHAR(255) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    fecha_nac DATE NOT NULL,
    genero VARCHAR(50) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    nombre_usuario VARCHAR(255) NOT NULL
);
