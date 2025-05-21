# ChatBook

ChatBook to aplikacja webowa do interakcji z lokalnym modelem sztucznej inteligencji. Oferuje system logowania i rejestracji użytkowników, zapisuje ich zainteresowania oraz sugeruje przykładowe zapytania dla modelu AI na podstawie zainteresowań użytkowników.

## Zmiany

v0.02 - prosty interfejs umożliwiający pisanie z lokalnym modelem AI wzbogacony o animacje\
v0.03 - system logowania i zapis historii chatu do bazy danych\
v0.04 - tworzenie nowych konwersacji\
v0.05 - dodano logi aktywności użytkoników, zachowanie kontekstu rozmowy\
v0.06 - dodano wybór zainteresowań, poprawiono błędy\
v0.07 - zmieniono system baz danych z MySQL na PostgreSQL\
v0.08 - poprawione UI, dodano procedury składowane\
v0.1 - dodano procedury składowane dla sugestii

## Wymagania

1. PHP 8.4.7 (z obsługą zapytań PostgreSQL)
2. PostgreSQL 17.4
3. Python 3.13.3
4. LM Studio 0.3.15 + Python SDK
5. llama-3.2-3b-instruct (lub inny wybrany model, wymagana zmiana w connect.py)

## Instalacja

1. Uruchom LM Studio lub z poziomu terminala załaduj model "llama-3.2-3b-instruct".
2. Stwórz i uruchom środowisko wirtualne "chbk-env".
3. Zainstaluj lmstudio-python w środowisku wirtualnym.
4. Stwórz baze danych ChatBook.
5. Uruchom index.php.

## Polecenia SQL do stworzenia bazy danych **ChatBook** i procedur składowanych podane są w ChatBook.sql i procedures.sql
