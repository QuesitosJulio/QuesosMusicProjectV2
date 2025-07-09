CREATE DATABASE music_db;
USE music_db;

CREATE TABLE canciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    artista VARCHAR(100) NOT NULL,
    album VARCHAR(100) DEFAULT NULL,
    duracion VARCHAR(10)
);

-- Canciones de Clancy (Twenty One Pilots)
INSERT INTO canciones (titulo, artista, album, duracion) VALUES
('Overcompensate', 'Twenty One Pilots', 'Clancy', '3:36'),
('Next Semester', 'Twenty One Pilots', 'Clancy', '4:12'),
('Backslide', 'Twenty One Pilots', 'Clancy', '3:48'),
('Vignette', 'Twenty One Pilots', 'Clancy', '2:54'),
('The Craving', 'Twenty One Pilots', 'Clancy', '3:19'),
('Lavish', 'Twenty One Pilots', 'Clancy', '3:42'),
('Navigating', 'Twenty One Pilots', 'Clancy', '4:01'),
('Snap Back', 'Twenty One Pilots', 'Clancy', '3:27'),
('Oldies Station', 'Twenty One Pilots', 'Clancy', '3:58'),
('Paladin Strait', 'Twenty One Pilots', 'Clancy', '5:15');


-- Canciones de Radical Optimism (Dua Lipa)
INSERT INTO canciones (titulo, artista, album, duracion) VALUES
('End Of An Era', 'Dua Lipa', 'Radical Optimism', '3:25'),
('Houdini', 'Dua Lipa', 'Radical Optimism', '3:04'),
('Training Season', 'Dua Lipa', 'Radical Optimism', '3:42'),
('These Walls', 'Dua Lipa', 'Radical Optimism', '3:17'),
('Whatcha Doing', 'Dua Lipa', 'Radical Optimism', '2:58'),
('French Exit', 'Dua Lipa', 'Radical Optimism', '3:11'),
('Illusion', 'Dua Lipa', 'Radical Optimism', '3:10'),
('Falling Forever', 'Dua Lipa', 'Radical Optimism', '3:29'),
('Anything For Love', 'Dua Lipa', 'Radical Optimism', '3:38'),
('Maria', 'Dua Lipa', 'Radical Optimism', '4:02'),
('Happy For You', 'Dua Lipa', 'Radical Optimism', '3:56');


ALTER TABLE canciones ADD COLUMN video_url VARCHAR(255);
-- Enlaces de las canciones
UPDATE canciones SET video_url = 'https://youtu.be/53tgVlXBZVg?si=fjwJ2MOXJjXLMcpU' WHERE titulo = 'Overcompensate';
UPDATE canciones SET video_url = 'https://youtu.be/a5i-KdUQ47o?si=Kw-Yky594D-ej32X' WHERE titulo = 'Next Semester';
UPDATE canciones SET video_url = 'https://youtu.be/YAmLMohrus4?si=aGAHuBr8i6T2Dj6i' WHERE titulo = 'Backslide';
UPDATE canciones SET video_url = 'https://youtu.be/eoEKwwbPfvc?si=BCDsJOd9KT6ky-EI' WHERE titulo = 'Vignette';
UPDATE canciones SET video_url = 'https://youtu.be/yN6OQncqqI0?si=QaXf98Lq7jahZfzt' WHERE titulo = 'The Craving';
UPDATE canciones SET video_url = 'https://youtu.be/flYgpeWsC2E?si=nVCrrMFkb_P-FR1o' WHERE titulo = 'Lavish';
UPDATE canciones SET video_url = 'https://youtu.be/07YtBj3BEBQ?si=Nmp2QdNGRUc7rzaN' WHERE titulo = 'Navigating';
UPDATE canciones SET video_url = 'https://youtu.be/eZptwvjKjk4?si=L5rwWFbWS_ZWID_n' WHERE titulo = 'Snap Back';
UPDATE canciones SET video_url = 'https://youtu.be/fBE_2sHDt4E?si=p4se28kByvZGBNb3' WHERE titulo = 'Oldies Station';
UPDATE canciones SET video_url = 'https://youtu.be/mix9YfaaNa0?si=OjoxCl1IfQPnWgw7' WHERE titulo = 'Paladin Strait';
UPDATE canciones SET video_url = 'https://youtu.be/hWw3dS2cyLc?si=Crt3oLDgTnSfZH_H' WHERE titulo = 'End Of An Era';
UPDATE canciones SET video_url = 'https://youtu.be/suAR1PYFNYA?si=qmvj4BeJ5waJSwE6' WHERE titulo = 'Houdini';
UPDATE canciones SET video_url = 'https://youtu.be/ZjBZ8MUnB0E?si=4E4ECQ3FgzqpyUq7' WHERE titulo = 'Training Season';
UPDATE canciones SET video_url = 'https://youtu.be/1TtvG18iSxY?si=7xPeJYo2vvKEhmB2' WHERE titulo = 'These Walls';
UPDATE canciones SET video_url = 'https://youtu.be/7x08rpZtzDg?si=iEg-u0BXPGDLwEiz' WHERE titulo = 'Whatcha Doing';
UPDATE canciones SET video_url = 'https://youtu.be/r9vNgw93VA4?si=4THhKrvkjpm9bGRV' WHERE titulo = 'French Exit';
UPDATE canciones SET video_url = 'https://youtu.be/a9cyG_yfh1k?si=D21yi5VTLJSH6jpt' WHERE titulo = 'Illusion';
UPDATE canciones SET video_url = 'https://youtu.be/O6s8mY0P5xA?si=U4puM6_XAInM8gnJ' WHERE titulo = 'Falling Forever';
UPDATE canciones SET video_url = 'https://youtu.be/XZds6pHwad4?si=f76ZQqHt-4Ea7VDY' WHERE titulo = 'Anything For Love';
UPDATE canciones SET video_url = 'https://youtu.be/gpu4f-8vk-I?si=xLZ0qP26LU506z1a' WHERE titulo = 'Maria';
UPDATE canciones SET video_url = 'https://youtu.be/uZ5RcAqYym0?si=X5etV884qa5xrtVn' WHERE titulo = 'Happy For You';

