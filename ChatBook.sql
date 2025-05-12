CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE chats (
    id_chat SERIAL PRIMARY KEY,
    id_user INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

CREATE TABLE chat_history (
    id SERIAL PRIMARY KEY,
    id_chat INT NOT NULL,
    prompt TEXT NOT NULL,
    completion TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_chat) REFERENCES chats(id_chat) ON DELETE CASCADE
);

CREATE TABLE activity (
    id_activity SERIAL PRIMARY KEY,
    id_user INT NOT NULL,
    logged TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    logout TIMESTAMP NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

CREATE TABLE interests (
    id_interest SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE prompt_suggestions (
    id_prompt SERIAL PRIMARY KEY,
    id_interest INT NOT NULL,
    prompt TEXT NOT NULL,
    FOREIGN KEY (id_interest) REFERENCES interests(id_interest) ON DELETE CASCADE
);

CREATE TABLE user_interests (
    id_user_interest SERIAL PRIMARY KEY,
    id_user INT NOT NULL,
    id_interest INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_interest) REFERENCES interests(id_interest) ON DELETE CASCADE
);

INSERT INTO interests (name) VALUES
('Sztuka'),
('Filmy'),
('Muzyka'),
('Jedzenie'),
('Sport'),
('Nauka'),
('Podróże'),
('Technologia');

-- Jedzenie

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Podaj przepis na jabłecznik'
FROM interests WHERE name = 'Jedzenie';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak zrobić kotlet schabowy?'
FROM interests WHERE name = 'Jedzenie';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak powinna wyglądać zdrowa cytryna?'
FROM interests WHERE name = 'Jedzenie';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jakie są najczęstsze alergie pokarmowe?'
FROM interests WHERE name = 'Jedzenie';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Podaj najlepsze przepisy na dania z grzybami'
FROM interests WHERE name = 'Jedzenie';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Ile się gotuje jajka na twardo?'
FROM interests WHERE name = 'Jedzenie';

-- Muzyka

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak nastroić pianino?' FROM interests WHERE name = 'Muzyka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak zagrać podstawowe akordy na gitarze?' FROM interests WHERE name = 'Muzyka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Najlepsze albumy jazzowe' FROM interests WHERE name = 'Muzyka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Podaj najlepsze utwory rockowe' FROM interests WHERE name = 'Muzyka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Kim był Fryderyk Chopin?' FROM interests WHERE name = 'Muzyka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Kto jest wokalistą Republiki?' FROM interests WHERE name = 'Muzyka';

-- Filmy

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Top 10 filmów komediowych' FROM interests WHERE name = 'Filmy';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jakie filmy polecasz na wieczór?' FROM interests WHERE name = 'Filmy';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Kiedy wyszedła pierwsza część Gwiezdnych Wojen?' FROM interests WHERE name = 'Filmy';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jakie filmy zrobił Andrzej Wajda?' FROM interests WHERE name = 'Filmy';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'O czym był pierwszy nakręcony film w historii?' FROM interests WHERE name = 'Filmy';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Kiedy wyszedła pierwsza część Gwiezdnych Wojen?' FROM interests WHERE name = 'Filmy';

-- Sztuka

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak narysować portret?' FROM interests WHERE name = 'Sztuka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jakie są najlepsze galerie sztuki w Paryżu?' FROM interests WHERE name = 'Sztuka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Historia najważniejszych przedmiotów sztuki' FROM interests WHERE name = 'Sztuka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jakie są najsłynniejsze dzieła Vincenta van Gogha?' FROM interests WHERE name = 'Sztuka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Ile jest części Dziadów?' FROM interests WHERE name = 'Sztuka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'O czym jest Balladyna?' FROM interests WHERE name = 'Sztuka';

-- Sport

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak zacząć biegać?' FROM interests WHERE name = 'Sport';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Najlepsze ćwiczenia na siłę' FROM interests WHERE name = 'Sport';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak trenować do maratonu?' FROM interests WHERE name = 'Sport';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Ile na klatę mordo?' FROM interests WHERE name = 'Sport';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Gdzie odbyły się ostatnie igrzyska olimpijskie?' FROM interests WHERE name = 'Sport';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jakie jest dzienne zapotrzebowanie kaloryczne u sportowców?' FROM interests WHERE name = 'Sport';

-- Nauka

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak nauczyć się programować w Pythonie?' FROM interests WHERE name = 'Nauka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Podaj mi 10 najważniejszych faktów z historii matematyki' FROM interests WHERE name = 'Nauka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak przygotować się do matury z języka polskiego?' FROM interests WHERE name = 'Nauka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak obliczyć deltę?' FROM interests WHERE name = 'Nauka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Podaj pierwsze prawo Newtona' FROM interests WHERE name = 'Nauka';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Ile wynosi prędkość światła?' FROM interests WHERE name = 'Nauka';

-- Podróże

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Podaj najlepsze miejsca do zwiedzania w Japonii' FROM interests WHERE name = 'Podróże';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak planować bezpieczną podróż za granicę?' FROM interests WHERE name = 'Podróże';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Rekomenduj mi trasy rowerowe w Włoszech' FROM interests WHERE name = 'Podróże';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Co zabrać ze sobą na biwak?' FROM interests WHERE name = 'Podróże';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak długo czeka się na wizę do USA?' FROM interests WHERE name = 'Podróże';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Gdzie się wybrać na majówkę?' FROM interests WHERE name = 'Podróże';

-- Technologia

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak zainstalować system operacyjny Linux?' FROM interests WHERE name = 'Technologia';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Kto wynalazł Internet?' FROM interests WHERE name = 'Technologia';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak zabezpieczyć swoje hasła online?' FROM interests WHERE name = 'Technologia';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak działa silnik parowy?' FROM interests WHERE name = 'Technologia';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Kim był Alan Turing?' FROM interests WHERE name = 'Technologia';

INSERT INTO prompt_suggestions (id_interest, prompt)
SELECT id_interest, 'Jak zbudowano piramidy?' FROM interests WHERE name = 'Technologia';
