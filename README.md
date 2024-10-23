# Monquiz
 Juego web de preguntas sobre cultura general

CREATE DATABASE monquiz;

Use monquiz;

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

CREATE TABLE reporte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_FK INT,
    usuario_FK INT,
    descripcion TEXT,
    FOREIGN KEY (pregunta_FK) REFERENCES pregunta(id),
    FOREIGN KEY (usuario_FK) REFERENCES usuario(id)
);


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

INSERT INTO respuesta (pregunta_FK, respuesta, es_correcta)
VALUES
(pregunta_FK = 1 a 10)
(1, 'Mercurio', 1),
(1, 'Venus', 0),
(1, 'Tierra', 0),
(1, 'Marte', 0),

(2, 'Pez', 1),
(2, 'Mamífero', 0),
(2, 'Anfibio', 0),
(2, 'Reptil', 0),

(3, 'Oxígeno', 1),
(3, 'Dióxido de carbono', 0),
(3, 'Hidrógeno', 0),
(3, 'Nitrógeno', 0),

(4, 'Electrón', 1),
(4, 'Protón', 0),
(4, 'Neutrón', 0),
(4, 'Foton', 0),

(5, 'Piel', 1),
(5, 'Corazón', 0),
(5, 'Hígado', 0),
(5, 'Cerebro', 0),

(6, 'Ocho', 1),
(6, 'Siete', 0),
(6, 'Nueve', 0),
(6, 'Diez', 0),

(7, 'Gravedad', 1),
(7, 'Fricción', 0),
(7, 'Inercia', 0),
(7, 'Aceleración', 0),

(8, 'Energía solar', 1),
(8, 'Energía nuclear', 0),
(8, 'Energía eólica', 0),
(8, 'Energía hidráulica', 0),

(9, 'H2O', 1),
(9, 'CO2', 0),
(9, 'O2', 0),
(9, 'N2O', 0),

(10, 'Albert Einstein', 1),
(10, 'Isaac Newton', 0),
(10, 'Stephen Hawking', 0),
(10, 'Galileo Galilei', 0),

(pregunta_FK = 11 a 20)
(11, 'George Washington', 1),
(11, 'Abraham Lincoln', 0),
(11, 'Thomas Jefferson', 0),
(11, 'John Adams', 0),

(12, 'Segunda Guerra Mundial', 1),
(12, 'Primera Guerra Mundial', 0),
(12, 'Guerra Civil Americana', 0),
(12, 'Guerra de Corea', 0),

(13, '1492', 1),
(13, '1500', 0),
(13, '1512', 0),
(13, '1475', 0),

(14, 'Gengis Khan', 1),
(14, 'Atila', 0),
(14, 'Alejandro Magno', 0),
(14, 'Julio César', 0),

(15, 'Segunda Guerra Mundial', 1),
(15, 'Guerra Fría', 0),
(15, 'Guerra de Vietnam', 0),
(15, 'Guerra del Golfo', 0),

(16, '1989', 1),
(16, '1991', 0),
(16, '1980', 0),
(16, '1975', 0),

(17, 'Reino Unido', 1),
(17, 'Francia', 0),
(17, 'Alemania', 0),
(17, 'Italia', 0),

(18, 'Keops', 1),
(18, 'Tutankamón', 0),
(18, 'Ramsés II', 0),
(18, 'Cleopatra', 0),

(19, 'Imperio Bizantino', 1),
(19, 'Imperio Romano', 0),
(19, 'Imperio Otomano', 0),
(19, 'Imperio Egipcio', 0),

(20, 'Tratado de Versalles', 1),
(20, 'Tratado de París', 0),
(20, 'Tratado de Ginebra', 0),
(20, 'Tratado de Potsdam', 0),

(pregunta_FK = 21 a 30)
(21, 'Nilo', 1),
(21, 'Amazonas', 0),
(21, 'Yangtsé', 0),
(21, 'Misisipi', 0),

(22, 'África', 1),
(22, 'Asia', 0),
(22, 'América del Sur', 0),
(22, 'Australia', 0),

(23, 'Tokio', 1),
(23, 'Kyoto', 0),
(23, 'Osaka', 0),
(23, 'Hiroshima', 0),

(24, 'Egipto', 1),
(24, 'India', 0),
(24, 'China', 0),
(24, 'Grecia', 0),

(25, 'China', 1),
(25, 'India', 0),
(25, 'Estados Unidos', 0),
(25, 'Indonesia', 0),

(26, 'Océano Pacífico', 1),
(26, 'Océano Atlántico', 0),
(26, 'Océano Índico', 0),
(26, 'Océano Ártico', 0),

(27, 'Monte Everest', 1),
(27, 'K2', 0),
(27, 'Mont Blanc', 0),
(27, 'Aconcagua', 0),

(28, 'Vaticano', 1),
(28, 'Mónaco', 0),
(28, 'Liechtenstein', 0),
(28, 'San Marino', 0),

(29, 'Estados Unidos', 1),
(29, 'Canadá', 0),
(29, 'México', 0),
(29, 'Cuba', 0),

(30, 'Italia', 1),
(30, 'Grecia', 0),
(30, 'Francia', 0),
(30, 'España', 0),
(pregunta_FK = 31 a 40)
(31, 'Robert Downey Jr.', 1),
(31, 'Chris Evans', 0),
(31, 'Chris Hemsworth', 0),
(31, 'Mark Ruffalo', 0),

(32, 'Walter White', 1),
(32, 'Jesse Pinkman', 0),
(32, 'Gustavo Fring', 0),
(32, 'Hank Schrader', 0),

(33, 'Grecia', 1),
(33, 'Italia', 0),
(33, 'Egipto', 0),
(33, 'Persia', 0),

(34, 'Disney', 1),
(34, 'Warner Bros', 0),
(34, 'DreamWorks', 0),
(34, 'Pixar', 0),

(35, 'NBC', 1),
(35, 'CBS', 0),
(35, 'ABC', 0),
(35, 'FOX', 0),

(36, 'Joaquin Phoenix', 1),
(36, 'Heath Ledger', 0),
(36, 'Jack Nicholson', 0),
(36, 'Jared Leto', 0),

(37, 'E.T.', 1),
(37, 'Gremlins', 0),
(37, 'Cazafantasmas', 0),
(37, 'Poltergeist', 0),

(38, 'HBO', 1),
(38, 'Netflix', 0),
(38, 'Amazon Prime', 0),
(38, 'Disney+', 0),

(39, 'Super Mario Bros.', 1),
(39, 'Pac-Man', 0),
(39, 'Sonic', 0),
(39, 'Zelda', 0),

(40, 'Steven Spielberg', 1),
(40, 'Martin Scorsese', 0),
(40, 'Quentin Tarantino', 0),
(40, 'James Cameron', 0),

(pregunta_FK = 41 a 50)
(41, 'Brasil', 1),
(41, 'Alemania', 0),
(41, 'Argentina', 0),
(41, 'Italia', 0),

(42, 'Michael Jordan', 1),
(42, 'Kobe Bryant', 0),
(42, 'LeBron James', 0),
(42, 'Shaquille O\'Neal', 0),

(43, 'Fórmula 1', 1),
(43, 'MotoGP', 0),
(43, 'NASCAR', 0),
(43, 'IndyCar', 0),

(44, '11', 1),
(44, '9', 0),
(44, '12', 0),
(44, '10', 0),

(45, 'Serena Williams', 1),
(45, 'Venus Williams', 0),
(45, 'Steffi Graf', 0),
(45, 'Maria Sharapova', 0),

(46, 'Roger Federer', 1),
(46, 'Rafael Nadal', 0),
(46, 'Novak Djokovic', 0),
(46, 'Pete Sampras', 0),

(47, 'Grecia', 1),
(47, 'Francia', 0),
(47, 'Italia', 0),
(47, 'España', 0),

(48, 'Los Angeles Lakers', 1),
(48, 'Chicago Bulls', 0),
(48, 'Boston Celtics', 0),
(48, 'Golden State Warriors', 0),

(49, 'Maratón', 1),
(49, 'Ciclismo', 0),
(49, 'Natación', 0),
(49, 'Remo', 0),

(50, 'Pelé', 1),
(50, 'Diego Maradona', 0),
(50, 'Lionel Messi', 0),
(50, 'Cristiano Ronaldo', 0),

(pregunta_FK = 51 a 60)
(51, 'Leonardo da Vinci', 1),
(51, 'Miguel Ángel', 0),
(51, 'Vincent van Gogh', 0),
(51, 'Pablo Picasso', 0),

(52, 'La Noche Estrellada', 1),
(52, 'Guernica', 0),
(52, 'La Última Cena', 0),
(52, 'El Grito', 0),

(53, 'Escultura', 1),
(53, 'Pintura', 0),
(53, 'Fotografía', 0),
(53, 'Música', 0),

(54, 'Salvador Dalí', 1),
(54, 'Claude Monet', 0),
(54, 'Edvard Munch', 0),
(54, 'Jackson Pollock', 0),

(55, 'Renacimiento', 1),
(55, 'Impresionismo', 0),
(55, 'Barroco', 0),
(55, 'Romanticismo', 0),

(56, 'Miguel Ángel', 1),
(56, 'Donatello', 0),
(56, 'Leonardo da Vinci', 0),
(56, 'Rafael', 0),

(57, 'Edvard Munch', 1),
(57, 'Vincent van Gogh', 0),
(57, 'Paul Gauguin', 0),
(57, 'Henri Matisse', 0),

(58, 'Andy Warhol', 1),
(58, 'Roy Lichtenstein', 0),
(58, 'Jean-Michel Basquiat', 0),
(58, 'Keith Haring', 0),

(59, 'Florencia', 1),
(59, 'Venecia', 0),
(59, 'Roma', 0),
(59, 'Milán', 0),

(60, 'La Piedad', 1),
(60, 'El David', 0),
(60, 'Moisés', 0),
(60, 'Baco', 0),

(pregunta_FK = 61 a 70)
(61, 'Poseidón', 1),
(61, 'Zeus', 0),
(61, 'Hades', 0),
(61, 'Apolo', 0),

(62, 'Perseo', 1),
(62, 'Hércules', 0),
(62, 'Teseo', 0),
(62, 'Aquiles', 0),

(63, 'Ave Fénix', 1),
(63, 'Grifo', 0),
(63, 'Quimera', 0),
(63, 'Pegaso', 0),

(64, 'Estigia', 1),
(64, 'Nilo', 0),
(64, 'Ganges', 0),
(64, 'Leteo', 0),

(65, 'Ra', 1),
(65, 'Osiris', 0),
(65, 'Horus', 0),
(65, 'Anubis', 0),

(66, 'Rayo', 1),
(66, 'Tridente', 0),
(66, 'Espada', 0),
(66, 'Arco', 0),

(67, 'Quimera', 1),
(67, 'Hidra', 0),
(67, 'Minotauro', 0),
(67, 'Cerbero', 0),

(68, 'Dionisio', 1),
(68, 'Apolo', 0),
(68, 'Hermes', 0),
(68, 'Hefesto', 0),

(69, 'Odiseo', 1),
(69, 'Aquiles', 0),
(69, 'Hércules', 0),
(69, 'Teseo', 0),

(70, 'Cerbero', 1),
(70, 'Minotauro', 0),
(70, 'Grifo', 0),
(70, 'Sátiro', 0),

(pregunta_FK = 71 a 80)
(71, 'Bill Gates', 1),
(71, 'Steve Jobs', 0),
(71, 'Elon Musk', 0),
(71, 'Mark Zuckerberg', 0),

(72, 'World Wide Web', 1),
(72, 'Wireless Wide Web', 0),
(72, 'Web World Wide', 0),
(72, 'Wide Web World', 0),

(73, 'Termómetro', 1),
(73, 'Barómetro', 0),
(73, 'Altímetro', 0),
(73, 'Odómetro', 0),

(74, 'Energía solar', 1),
(74, 'Energía nuclear', 0),
(74, 'Energía eólica', 0),
(74, 'Energía hidráulica', 0),

(75, 'CD-ROM', 1),
(75, 'Blu-ray', 0),
(75, 'Disquete', 0),
(75, 'USB', 0),

(76, 'AMD', 1),
(76, 'Intel', 0),
(76, 'Qualcomm', 0),
(76, 'NVIDIA', 0),

(77, 'Bitcoin', 1),
(77, 'Ethereum', 0),
(77, 'Ripple', 0),
(77, 'Litecoin', 0),

(78, '1991', 1),
(78, '1989', 0),
(78, '1995', 0),
(78, '2000', 0),

(79, 'JavaScript', 1),
(79, 'Python', 0),
(79, 'Java', 0),
(79, 'C++', 0),

(80, 'HTML', 1),
(80, 'CSS', 0),
(80, 'PHP', 0),
(80, 'SQL', 0);
