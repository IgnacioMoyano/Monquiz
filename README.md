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

CREATE TABLE estado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL
);

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    color VARCHAR(50)
);

CREATE TABLE pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta varchar(500) NOT NULL,
    categoria_FK INT,
    estado_FK INT,
    reportada INT DEFAULT 0,
    creada_usuarios INT DEFAULT 0,
    cantidad_vista INT DEFAULT 0,
    cantidad_correctas INT DEFAULT 0,
    FOREIGN KEY (categoria_FK) REFERENCES categoria(id),
    FOREIGN KEY (estado_FK) REFERENCES estado(id)
);

CREATE TABLE respuesta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_FK INT,
    respuesta varchar(500) NOT NULL,
    es_correcta int DEFAULT 0,
    FOREIGN KEY (pregunta_FK) REFERENCES pregunta(id)
);

CREATE TABLE preguntas_respondidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_FK INT,
    pregunta_FK INT,
    FOREIGN KEY (usuario_FK) REFERENCES usuario(id),
    FOREIGN KEY (pregunta_FK) REFERENCES pregunta(id)
);
