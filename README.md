# ChatBook
Aplikacja webowa umożliwiająca interaktywne poznawanie książki z AI

## Zmiany:
v0.02 - prosty interfejs umożliwiający pisanie z lokalnym modelem AI wzbogacony o animacje\
v0.03 - system logowania i zapis historii chatu do bazy danych\
v0.04 - tworzenie nowych konwersacji\
v0.05 - dodano logi aktywności użytkoników, zachowanie kontekstu rozmowy
v0.06 - dodano wybór zainteresowań

## Wymagania:
1. PHP 8.24 (xampp)
2. Python 3.13.2
3. LM Studio 0.3.13 + Python SDK
4. meta-llama-3.1-8b-instruct (lub inny wybrany model, wymagana zmiana w connect.py)

## Instalacja:
1. Uruchom LM Studio lub z poziomu terminala załaduj model "bielik-11b-v2.3-instruct".
2. Stwórz i uruchom środowisko wirtualne "chbk-env".
3. Zainstaluj lmstudio-python w środowisku wirtualnym.
4. Stwórz baze danych ChatBook w phpMyAdmin.
5. Uruchom index.php.

## Polecenia SQL do bazy danych ChatBook podane są w ChatBook.sql
