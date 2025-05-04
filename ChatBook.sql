CREATE DATABASE ChatBook;

USE ChatBook;

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE chats (
    id_chat INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

CREATE TABLE chat_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_chat INT NOT NULL,
    prompt TEXT NOT NULL,
    completion TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_chat) REFERENCES chats(id_chat) ON DELETE CASCADE
);

CREATE TABLE activity (
    id_activity INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    logged TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    logout TIMESTAMP NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

CREATE TABLE interests (
    id_interest INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE prompt_suggestions (
    id_prompt INT AUTO_INCREMENT PRIMARY KEY,
    id_interest INT NOT NULL,
    prompt TEXT NOT NULL,
    FOREIGN KEY (id_interest) REFERENCES interests(id_interest) ON DELETE CASCADE
);

CREATE TABLE user_interests (
    id_user_interest INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_interest INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_interest) REFERENCES interests(id_interest) ON DELETE CASCADE
);

INSERT INTO interests (name) VALUES ('Sztuka');
INSERT INTO interests (name) VALUES ('Filmy');
INSERT INTO interests (name) VALUES ('Muzyka');
INSERT INTO interests (name) VALUES ('Jedzenie');
INSERT INTO interests (name) VALUES ('Sport');
INSERT INTO interests (name) VALUES ('Nauka');
INSERT INTO interests (name) VALUES ('Podróże');
INSERT INTO interests (name) VALUES ('Technologia');

SET @id_jedzenie = (SELECT id_interest FROM interests WHERE name = 'Jedzenie');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_jedzenie, 'Podaj przepis na jabłecznik');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_jedzenie, 'Jak zrobić kotlet schabowy?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_jedzenie, 'Najlepsze restauracje w moim mieście');

SET @id_muzyka = (SELECT id_interest FROM interests WHERE name = 'Muzyka');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_muzyka, 'Podaj najlepsze utwory rockowe');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_muzyka, 'Jak zagrać gitarę - podstawowe akordy');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_muzyka, 'Najlepsze albumy jazzowe');

SET @id_filmy = (SELECT id_interest FROM interests WHERE name = 'Filmy');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_filmy, 'Top 10 filmów komediowych');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_filmy, 'Jakie filmy polecasz na wieczór?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_filmy, 'Kiedy wyszedła pierwsza część Gwiezdnych Wojen?');

SET @id_sztuka = (SELECT id_interest FROM interests WHERE name = 'Sztuka');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_sztuka, 'Jak narysować portret?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_sztuka, 'Najlepsze galerie sztuki w moim mieście');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_sztuka, 'Historia najważniejszych przedmiotów sztuki');

SET @id_sport = (SELECT id_interest FROM interests WHERE name = 'Sport');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_sport, 'Jak zacząć biegać?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_sport, 'Najlepsze ćwiczenia na siłę');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_sport, 'Jak trenować do maratonu?');

SET @id_nauka = (SELECT id_interest FROM interests WHERE name = 'Nauka');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_nauka, 'Jak nauczyć się programować w Pythonie');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_nauka, 'Podaj mi 10 najważniejszych faktów z historii matematyki');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_nauka, 'Jak przygotować się do matury z języka polskiego?');

SET @id_podroze = (SELECT id_interest FROM interests WHERE name = 'Podróże');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_podroze, 'Podaj najlepsze miejsca do zwiedzania w Japonii');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_podroze, 'Jak planować bezpieczną podróż za granicę?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_podroze, 'Rekomenduj mi trasy rowerowe w Włoszech');

SET @id_technologia = (SELECT id_interest FROM interests WHERE name = 'Technologia');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_technologia, 'Jak zainstalować system operacyjny Linux?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_technologia, 'Kto wynalazł Internet?');
INSERT INTO prompt_suggestions (id_interest, prompt) VALUES (@id_technologia, 'Jak zabezpieczyć swoje hasła online?');
