# ChatBook
Aplikacja webowa umożliwiająca interaktywne poznawanie książki z AI\

## Zmiany:
v0.02 - prosty interfejs umożliwiający pisanie z lokalnym modelem AI wzbogacony o animacje\
v0.03 - system logowania i zapis historii chatu do bazy danych\
v0.04 - tworzenie nowych konwersacji\

## Wymagania:
1. PHP 8.24 (xampp)
2. Python 3.13.2
3. LM Studio 0.3.13 + Python SDK
4. meta-llama-3.1-8b-instruct (lub inny wybrany model, wymagana zmiana w connect.py)

## Instalacja:
1. Uruchom LM Studio lub z poziomu terminala załaduj model "meta-llama-3.1-8b-instruct".
2. Stwórz i uruchom środowisko wirtualne "chbk-env".
3. Zainstaluj lmstudio-python w środowisku wirtualnym.
4. Stwórz baze danych ChatBook w phpMyAdmin.
5. Uruchom index.php.

## Polecenia SQL do bazy danych ChatBook:
CREATE DATABASE ChatBook;

USE ChatBook;

CREATE TABLE users (\
    id_user INT AUTO_INCREMENT PRIMARY KEY,\
    username VARCHAR(50) NOT NULL,\
    email VARCHAR(100) NOT NULL UNIQUE,\
    password VARCHAR(255) NOT NULL\
);

CREATE TABLE chats (\
    id_chat INT AUTO_INCREMENT PRIMARY KEY,\
    id_user INT NOT NULL,\
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE\
);

CREATE TABLE chat_history (\
    id INT AUTO_INCREMENT PRIMARY KEY,\
    id_chat INT NOT NULL,\
    prompt TEXT NOT NULL,\
    completion TEXT NOT NULL,\
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\
    FOREIGN KEY (id_chat) REFERENCES chats(id_chat) ON DELETE CASCADE\
);
