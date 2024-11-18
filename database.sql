CREATE DATABASE monquiz;

Use monquiz;

CREATE TABLE usuario ( Id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL, Apellido VARCHAR(255) NOT NULL, fecha_nac DATE NOT NULL, tipo_cuenta INT NOT NULL, genero VARCHAR(50) NOT NULL, pais VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, correo VARCHAR(100) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL UNIQUE, imagen VARCHAR(255), validado TINYINT(1) NOT NULL, token VARCHAR(255), cantidad_preg_vistas INT DEFAULT 0, cantidad_preg_correctas INT DEFAULT 0, fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP );

CREATE TABLE estado ( id INT AUTO_INCREMENT PRIMARY KEY, descripcion VARCHAR(255) NOT NULL );

CREATE TABLE categoria ( id INT AUTO_INCREMENT PRIMARY KEY, descripcion VARCHAR(255) NOT NULL, color VARCHAR(50) );

CREATE TABLE pregunta ( id INT AUTO_INCREMENT PRIMARY KEY, pregunta varchar(500) NOT NULL, categoria_FK INT, estado_FK INT, reportada INT DEFAULT 0, creada_usuarios INT DEFAULT 0, cantidad_vista INT DEFAULT 0, cantidad_correctas INT DEFAULT 0, FOREIGN KEY (categoria_FK) REFERENCES categoria(id), FOREIGN KEY (estado_FK) REFERENCES estado(id), fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE respuesta ( id INT AUTO_INCREMENT PRIMARY KEY, pregunta_FK INT, respuesta varchar(500) NOT NULL, es_correcta int DEFAULT 0, FOREIGN KEY (pregunta_FK) REFERENCES pregunta(id) );

CREATE TABLE preguntas_respondidas ( id INT AUTO_INCREMENT PRIMARY KEY, usuario_FK INT, pregunta_FK INT, FOREIGN KEY (usuario_FK) REFERENCES usuario(id), FOREIGN KEY (pregunta_FK) REFERENCES pregunta(id) );

CREATE TABLE reporte ( id INT AUTO_INCREMENT PRIMARY KEY, pregunta_FK INT, usuario_FK INT, descripcion TEXT, FOREIGN KEY (pregunta_FK) REFERENCES pregunta(id), FOREIGN KEY (usuario_FK) REFERENCES usuario(id),fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);

INSERT INTO categoria (descripcion, color) VALUES ('Ciencia', '#FFDF80'), ('Historia', '#BFFF80'), ('Geografía', '#80FF9F'), ('Entretenimiento', '#80FFFF'), ('Deportes', '#809FFF'), ('Arte', '#BF80FF'), ('Mitología', '#FF80DF'), ('Tecnología', '#FF8080');

INSERT INTO estado (descripcion) VALUES ('pendiente'), ('aprobada'), ('rechazada'), ('reportada'), ('descativada');

INSERT INTO pregunta (pregunta, categoria_FK, estado_FK, reportada, creada_usuarios, cantidad_vista, cantidad_correctas)
VALUES

('¿Cuál es el planeta más cercano al Sol?', 1, 2, 0, 0, 0, 0),
('¿Qué gas es esencial para la respiración humana?', 1, 2, 0, 0, 0, 0),
('¿Qué tipo de energía produce una planta solar?', 1, 2, 0, 0, 0, 0),
('¿Cuál es la fórmula química del agua?', 1, 2, 0, 0, 0, 0),
('¿Qué científico desarrolló la teoría de la relatividad?', 1, 2, 0, 0, 0, 0),


('¿Quién fue el primer presidente de los Estados Unidos?', 2, 2, 0, 0, 0, 0),
('¿Qué evento histórico terminó en 1945?', 2, 2, 0, 0, 0, 0),
('¿En qué año llegó Cristóbal Colón a América?', 2, 2, 0, 0, 0, 0),
('¿Quién fue el líder del Imperio Mongol?', 2, 2, 0, 0, 0, 0),
('¿En qué año cayó el Muro de Berlín?', 2, 2, 0, 0, 0, 0),


('¿Cuál es el río más largo del mundo?', 3, 2, 0, 0, 0, 0),
('¿En qué continente se encuentra el desierto del Sahara?', 3, 2, 0, 0, 0, 0),
('¿Cuál es la capital de Japón?', 3, 2, 0, 0, 0, 0),
('¿En qué país se encuentran las pirámides de Giza?', 3, 2, 0, 0, 0, 0),
('¿Qué país tiene más habitantes?', 3, 2, 0, 0, 0, 0),


('¿Quién interpretó a Jack Sparrow en "Piratas del Caribe"?', 4, 2, 0, 0, 0, 0),
('¿En qué año se estrenó la película "Titanic"?', 4, 2, 0, 0, 0, 0),
('¿Qué superhéroe es conocido como el "Hombre Araña"?', 4, 2, 0, 0, 0, 0),
('¿Qué película ganó el Oscar a Mejor Película en 2020?', 4, 2, 0, 0, 0, 0),
('¿Qué actor interpretó a Wolverine en las películas de "X-Men"?', 4, 2, 0, 0, 0, 0),


('¿Cuántos jugadores hay en un equipo de fútbol?', 5, 2, 0, 0, 0, 0),
('¿En qué año se celebraron los primeros Juegos Olímpicos modernos?', 5, 2, 0, 0, 0, 0),
('¿En qué país nació Lionel Messi?', 5, 2, 0, 0, 0, 0),
('¿Qué deporte se juega con un volante?', 5, 2, 0, 0, 0, 0),
('¿Quién ganó la Copa Mundial de Fútbol en 2018?', 5, 2, 0, 0, 0, 0),

('¿Quién pintó la Mona Lisa?', 6, 2, 0, 0, 0, 0),
('¿En qué museo se encuentra la Mona Lisa?', 6, 2, 0, 0, 0, 0),
('¿Qué estilo artístico es conocido por sus formas geométricas y colores vivos?', 6, 2, 0, 0, 0, 0),
('¿Qué artista pintó "La noche estrellada"?', 6, 2, 0, 0, 0, 0),
('¿Quién esculpió el David?', 6, 2, 0, 0, 0, 0),

('¿Quién es el dios del trueno en la mitología nórdica?', 7, 2, 0, 0, 0, 0),
('¿Qué criatura mitológica tiene la cabeza de un león, cuerpo de cabra y cola de serpiente?', 7, 2, 0, 0, 0, 0),
('¿Quién era el dios del inframundo en la mitología griega?', 7, 2, 0, 0, 0, 0),
('¿Cómo se llama el caballo alado en la mitología griega?', 7, 2, 0, 0, 0, 0),
('¿Qué dios egipcio tiene cabeza de halcón?', 7, 2, 0, 0, 0, 0),

('¿Quién es conocido como el padre de la computadora moderna?', 8, 2, 0, 0, 0, 0),
('¿En qué año se lanzó el primer iPhone?', 8, 2, 0, 0, 0, 0),
('¿Qué significa el acrónimo HTTP?', 8, 2, 0, 0, 0, 0),
('¿Cuál es el lenguaje de programación más utilizado para el desarrollo web?', 8, 2, 0, 0, 0, 0),
('¿Qué es un firewall?', 8, 2, 0, 0, 0, 0);

INSERT INTO respuesta (pregunta_FK, respuesta, es_correcta)
VALUES
(1, 'Mercurio', 1),
(1, 'Venus', 0),
(1, 'Tierra', 0),
(1, 'Marte', 0),

(2, 'Oxígeno', 1),
(2, 'Nitrógeno', 0),
(2, 'Hidrógeno', 0),
(2, 'Dióxido de carbono', 0),

(3, 'Energía solar', 1),
(3, 'Energía nuclear', 0),
(3, 'Energía eólica', 0),
(3, 'Energía hidráulica', 0),

(4, 'H2O', 1),
(4, 'CO2', 0),
(4, 'O2', 0),
(4, 'H2', 0),

(5, 'Albert Einstein', 1),
(5, 'Isaac Newton', 0),
(5, 'Galileo Galilei', 0),
(5, 'Stephen Hawking', 0),

(6, 'George Washington', 1),
(6, 'Abraham Lincoln', 0),
(6, 'Thomas Jefferson', 0),
(6, 'John Adams', 0),

(7, 'La Segunda Guerra Mundial', 1),
(7, 'La Primera Guerra Mundial', 0),
(7, 'La Guerra Fría', 0),
(7, 'La Revolución Industrial', 0),

(8, '1492', 1),
(8, '1502', 0),
(8, '1488', 0),
(8, '1498', 0),

(9, 'Gengis Kan', 1),
(9, 'Kublai Kan', 0),
(9, 'Tamerlán', 0),
(9, 'Atila', 0),

(10, '1989', 1),
(10, '1990', 0),
(10, '1988', 0),
(10, '1987', 0),

(11, 'El Amazonas', 1),
(11, 'El Nilo', 0),
(11, 'El Yangtsé', 0),
(11, 'El Misisipi', 0),

(12, 'África', 1),
(12, 'Asia', 0),
(12, 'América', 0),
(12, 'Oceanía', 0),

(13, 'Tokio', 1),
(13, 'Kioto', 0),
(13, 'Osaka', 0),
(13, 'Hiroshima', 0),

(14, 'Egipto', 1),
(14, 'Sudán', 0),
(14, 'Marruecos', 0),
(14, 'Etiopía', 0),

(15, 'China', 1),
(15, 'India', 0),
(15, 'Estados Unidos', 0),
(15, 'Indonesia', 0),


(16, 'Johnny Depp', 1),
(16, 'Orlando Bloom', 0),
(16, 'Keira Knightley', 0),
(16, 'Geoffrey Rush', 0),

(17, '1997', 1),
(17, '1998', 0),
(17, '1996', 0),
(17, '1995', 0),

(18, 'Spider-Man', 1),
(18, 'Superman', 0),
(18, 'Batman', 0),
(18, 'Iron Man', 0),

(19, 'Parasite', 1),
(19, '1917', 0),
(19, 'Joker', 0),
(19, 'Ford v Ferrari', 0),

(20, 'Hugh Jackman', 1),
(20, 'Patrick Stewart', 0),
(20, 'James McAvoy', 0),
(20, 'Ian McKellen', 0),


(21, '11', 1),
(21, '10', 0),
(21, '12', 0),
(21, '9', 0),

(22, '1896', 1),
(22, '1900', 0),
(22, '1888', 0),
(22, '1904', 0),

(23, 'Argentina', 1),
(23, 'Brasil', 0),
(23, 'España', 0),
(23, 'Francia', 0),

(24, 'Bádminton', 1),
(24, 'Voleibol', 0),
(24, 'Tenis', 0),
(24, 'Críquet', 0),

(25, 'Francia', 1),
(25, 'Alemania', 0),
(25, 'Argentina', 0),
(25, 'Brasil', 0),


(26, 'Leonardo da Vinci', 1),
(26, 'Miguel Ángel', 0),
(26, 'Raphael', 0),
(26, 'Donatello', 0),

(27, 'Museo del Louvre', 1),
(27, 'Museo del Prado', 0),
(27, 'Museo de Arte Moderno', 0),
(27, 'Galería Uffizi', 0),

(28, 'Cubismo', 1),
(28, 'Impresionismo', 0),
(28, 'Realismo', 0),
(28, 'Surrealismo', 0),

(29, 'Vincent van Gogh', 1),
(29, 'Claude Monet', 0),
(29, 'Pablo Picasso', 0),
(29, 'Salvador Dalí', 0),

(30, 'Miguel Ángel', 1),
(30, 'Donatello', 0),
(30, 'Bernini', 0),
(30, 'Rodin', 0),


(31, 'Thor', 1),
(31, 'Odin', 0),
(31, 'Loki', 0),
(31, 'Baldur', 0),

(32, 'Quimera', 1),
(32, 'Hidra', 0),
(32, 'Esfinge', 0),
(32, 'Cerbero', 0),

(33, 'Hades', 1),
(33, 'Zeus', 0),
(33, 'Poseidón', 0),
(33, 'Hermes', 0),

(34, 'Pegaso', 1),
(34, 'Centauro', 0),
(34, 'Grifo', 0),
(34, 'Minotauro', 0),

(35, 'Horus', 1),
(35, 'Anubis', 0),
(35, 'Ra', 0),
(35, 'Set', 0),


(36, 'Alan Turing', 1),
(36, 'Charles Babbage', 0),
(36, 'Steve Jobs', 0),
(36, 'Bill Gates', 0),

(37, '2007', 1),
(37, '2006', 0),
(37, '2008', 0),
(37, '2005', 0),

(38, 'HyperText Transfer Protocol', 1),
(38, 'HyperLink Text Protocol', 0),
(38, 'Hyper Transfer Text Protocol', 0),
(38, 'HighText Transfer Protocol', 0),

(39, 'JavaScript', 1),
(39, 'Python', 0),
(39, 'Ruby', 0),
(39, 'PHP', 0),

(40, 'Un sistema de seguridad de red', 1),
(40, 'Un navegador web', 0),
(40, 'Un servidor web', 0),
(40, 'Un sistema operativo', 0);


CREATE TABLE partida (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         puntuacion INT NOT NULL DEFAULT 0,
                         usuario_FK INT NOT NULL,
                         estado INT NOT NULL DEFAULT 1,
                         FOREIGN KEY (usuario_FK) REFERENCES usuario(id),
                         fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
