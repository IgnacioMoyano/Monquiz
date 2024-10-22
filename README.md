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

Rellenar tablas:

INSERT INTO categoria (descripcion, color) VALUES
('Ciencia', 'verde'),
('Historia', 'amarillo'),
('Geografía', 'azul'),
('Entretenimiento', 'rosa'),
('Deportes', 'naranja'),
('Arte', 'rojo'),
('Mitología', 'celeste'),
('Tecnología', 'violeta');

INSERT INTO estado (descripcion) VALUES 
('pendiente'),
('aprobada'),
('rechazada'),
('reportada'),
('descativada')

INSERT INTO pregunta (pregunta, categoria_FK, estado_FK, reportada, creada_usuarios, cantidad_vista, cantidad_correctas)
VALUES
-- Ciencia
('¿Cuál es el planeta más cercano al Sol?', 1, 2, 0, 0, 0, 0),
('¿Qué tipo de animal es un tiburón?', 1, 2, 0, 0, 0, 0),
('¿Qué gas es esencial para la respiración humana?', 1, 2, 0, 0, 0, 0),
('¿Qué partícula tiene carga negativa?', 1, 2, 0, 0, 0, 0),
('¿Cuál es el órgano más grande del cuerpo humano?', 1, 2, 0, 0, 0, 0),
('¿Cuántos planetas hay en el sistema solar?', 1, 2, 0, 0, 0, 0),
('¿Cómo se llama la fuerza que nos mantiene en la Tierra?', 1, 2, 0, 0, 0, 0),
('¿Qué tipo de energía produce una planta solar?', 1, 2, 0, 0, 0, 0),
('¿Cuál es la fórmula química del agua?', 1, 2, 0, 0, 0, 0),
('¿Qué científico desarrolló la teoría de la relatividad?', 1, 2, 0, 0, 0, 0),

-- Historia
('¿Quién fue el primer presidente de los Estados Unidos?', 2, 2, 0, 0, 0, 0),
('¿Qué evento histórico terminó en 1945?', 2, 2, 0, 0, 0, 0),
('¿En qué año llegó Cristóbal Colón a América?', 2, 2, 0, 0, 0, 0),
('¿Quién fue el líder del Imperio Mongol?', 2, 2, 0, 0, 0, 0),
('¿Qué guerra fue causada por la invasión de Polonia?', 2, 2, 0, 0, 0, 0),
('¿En qué año cayó el Muro de Berlín?', 2, 2, 0, 0, 0, 0),
('¿Dónde ocurrió la Revolución Industrial?', 2, 2, 0, 0, 0, 0),
('¿Quién fue el faraón egipcio que ordenó la construcción de las pirámides de Giza?', 2, 2, 0, 0, 0, 0),
('¿Qué imperio cayó en 1453 con la toma de Constantinopla?', 2, 2, 0, 0, 0, 0),
('¿Qué tratado puso fin a la Primera Guerra Mundial?', 2, 2, 0, 0, 0, 0),

-- Geografía
('¿Cuál es el río más largo del mundo?', 3, 2, 0, 0, 0, 0),
('¿En qué continente se encuentra el desierto del Sahara?', 3, 2, 0, 0, 0, 0),
('¿Cuál es la capital de Japón?', 3, 2, 0, 0, 0, 0),
('¿En qué país se encuentran las pirámides de Giza?', 3, 2, 0, 0, 0, 0),
('¿Qué país tiene más habitantes?', 3, 2, 0, 0, 0, 0),
('¿Cuál es el océano más grande del mundo?', 3, 2, 0, 0, 0, 0),
('¿Qué montaña es la más alta del mundo?', 3, 2, 0, 0, 0, 0),
('¿Cuál es el país más pequeño del mundo?', 3, 2, 0, 0, 0, 0),
('¿Qué país está entre Canadá y México?', 3, 2, 0, 0, 0, 0),
('¿Qué país tiene la forma de una bota?', 3, 2, 0, 0, 0, 0),

-- Entretenimiento
('¿Quién interpretó a Jack Sparrow en "Piratas del Caribe"?', 4, 2, 0, 0, 0, 0),
('¿En qué año se estrenó la película "Titanic"?', 4, 2, 0, 0, 0, 0),
('¿Qué superhéroe es conocido como el "Hombre Araña"?', 4, 2, 0, 0, 0, 0),
('¿Qué película ganó el Oscar a Mejor Película en 2020?', 4, 2, 0, 0, 0, 0),
('¿Cuál es el nombre del mago en "El Señor de los Anillos"?', 4, 2, 0, 0, 0, 0),
('¿Cuál es el apellido de los hermanos que crearon "Stranger Things"?', 4, 2, 0, 0, 0, 0),
('¿En qué año se estrenó la primera película de "Star Wars"?', 4, 2, 0, 0, 0, 0),
('¿Qué actor interpretó a Wolverine en las películas de "X-Men"?', 4, 2, 0, 0, 0, 0),
('¿Qué personaje de "Friends" es paleontólogo?', 4, 2, 0, 0, 0, 0),
('¿Quién es el autor de las novelas "Harry Potter"?', 4, 2, 0, 0, 0, 0),

-- Deportes
('¿Cuántos jugadores hay en un equipo de fútbol?', 5, 2, 0, 0, 0, 0),
('¿En qué año se celebraron los primeros Juegos Olímpicos modernos?', 5, 2, 0, 0, 0, 0),
('¿En qué país nació Lionel Messi?', 5, 2, 0, 0, 0, 0),
('¿Qué deporte se juega con un volante?', 5, 2, 0, 0, 0, 0),
('¿Quién ganó la Copa Mundial de Fútbol en 2018?', 5, 2, 0, 0, 0, 0),
('¿Qué tenista ha ganado más títulos de Grand Slam?', 5, 2, 0, 0, 0, 0),
('¿Cuál es el deporte nacional de Japón?', 5, 2, 0, 0, 0, 0),
('¿Qué jugador de baloncesto es apodado "King James"?', 5, 2, 0, 0, 0, 0),
('¿Qué país ha ganado más Copas Mundiales de fútbol?', 5, 2, 0, 0, 0, 0),
('¿En qué equipo de fútbol jugaba Diego Maradona cuando ganó la Copa del Mundo en 1986?', 5, 2, 0, 0, 0, 0),

-- Arte
('¿Quién pintó "La Mona Lisa"?', 6, 2, 0, 0, 0, 0),
('¿En qué país se encuentra el Museo del Louvre?', 6, 2, 0, 0, 0, 0),
('¿Qué estilo de arte es conocido por sus formas geométricas?', 6, 2, 0, 0, 0, 0),
('¿Quién pintó "La noche estrellada"?', 6, 2, 0, 0, 0, 0),
('¿Qué famoso pintor cortó parte de su propia oreja?', 6, 2, 0, 0, 0, 0),
('¿Cuál es la técnica de pintar sobre yeso húmedo?', 6, 2, 0, 0, 0, 0),
('¿Quién esculpió el "David"?', 6, 2, 0, 0, 0, 0),
('¿Qué artista es famoso por sus cuadros de girasoles?', 6, 2, 0, 0, 0, 0),
('¿Qué movimiento artístico es Salvador Dalí famoso por representar?', 6, 2, 0, 0, 0, 0),
('¿En qué país nació Pablo Picasso?', 6, 2, 0, 0, 0, 0),

-- Mitología
('¿Quién es el dios del trueno en la mitología nórdica?', 7, 2, 0, 0, 0, 0),
('¿Qué criatura mitológica tiene la cabeza de un toro y el cuerpo de un hombre?', 7, 2, 0, 0, 0, 0),
('¿Cuál es el nombre del dios griego del mar?', 7, 2, 0, 0, 0, 0),
('¿Quién fue el héroe que mató a la Medusa?', 7, 2, 0, 0, 0, 0),
('¿Qué mitológica ave renace de sus cenizas?', 7, 2, 0, 0, 0, 0),
('¿Cómo se llama el río que separa el mundo de los vivos y los muertos en la mitología griega?', 7, 2, 0, 0, 0, 0),
('¿Quién era el dios principal en la mitología egipcia?', 7, 2, 0, 0, 0, 0),
('¿Qué arma usaba Zeus?', 7, 2, 0, 0, 0, 0),
('¿Qué criatura mitológica tenía el cuerpo de una cabra, la cabeza de un león y la cola de una serpiente?', 7, 2, 0, 0, 0, 0),
('¿Quién es el dios del vino en la mitología griega?', 7, 2, 0, 0, 0, 0),

-- Tecnología
('¿Quién es el fundador de Microsoft?', 8, 2, 0, 0, 0, 0),
('¿Qué significa "www" en una dirección web?', 8, 2, 0, 0, 0, 0),
('¿Qué dispositivo se utiliza para medir la temperatura corporal?', 8, 2, 0, 0, 0, 0),
('¿Qué tipo de energía utiliza un panel solar?', 8, 2, 0, 0, 0, 0),
('¿Qué tecnología permite almacenar grandes cantidades de datos en discos ópticos?', 8, 2, 0, 0, 0, 0),
('¿Qué empresa fabrica los procesadores Ryzen?', 8, 2, 0, 0, 0, 0),
('¿Qué siglas representan la inteligencia artificial?', 8, 2, 0, 0, 0, 0),
('¿Qué es un dron?', 8, 2, 0, 0, 0, 0),
('¿Qué material se utiliza en la fabricación de microchips?', 8, 2, 0, 0, 0, 0),
('¿Qué tipo de red es utilizada por los teléfonos móviles?', 8, 2, 0, 0, 0, 0);
