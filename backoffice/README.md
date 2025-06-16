# Progetto Bool Commerce

## Obbiettivo

Riprodurre un classico sito di E-Commerce per l'acquisto di articoli di abbigliamento.

Il focus è offrire la possibilità agli utenti non loggati di poter trovare il prodotto più adatto alle proprie esigenze in base a categoria, taglia e recensioni, per poi poter creare un account utente con la possibilità di creare e gestire ordini, confermare l'avvenuta consegna per gli ordini spediti e infine lasciare recensioni per i prodotti acquistati.

Gli utenti admin potranno gestire i prodotti aggiungendone di nuovi o modificando quelli già presenti, creare ordini di prova e gestire quelli già creati dagli utenti, confermando la spedizione oppure annullandoli, lasciando opportune note per l'ordine. 

## Funzionalità

> ### Unlogged User
+ Ricerca per nome
+ Ricerca avanzata
    + Taglia disponibile
    + Nome
    + Range prezzo
    + Categoria
    + Prodotto scontato
+ Login
> ### Logged User
+ **Funzioni UnLogged User**
+ Aggiungi prodotto al carrello con selezione taglia
+ Visualizza e modifica carrello
    + Taglia
    + Quantità
    + Rimuovi prodotto dal carrello
+ Crea e modifica indirizzi di spedizione
+ Visualizza sommario ordine e conferma
+ Lista ordini
    + Prodotti
    + Data
    + Stato ordine
    + Note
    + Conferma consegna (per ordini spediti)
    + Scrivi recensione prodotto (per ordini consegnati)
+ Dettagli utente
    + User ID
    + Nome
    + Mail
    + Mail confermata
    + Data creazione utente
    + Crea o modifica indirizzi di spedizione
    + Logout
+ Crea Ordine
    + Seleziona indirizzo spedizione
    + Seleziona tipo spedizione
        + Standard
        + Standard + Track
        + Espressa
    + Visualizza fattura con dettagli ordine e totale prezzo
    + Conferma ordine 
> ### Admin User
+ **Funzioni Logged User**
+ Gestisci prodotti
    + Crea 
    + Modifica
    + Rimuovi
+ Gestisci Ordini 
    + Spedisci
    + Annulla 
    + Lascia note ordine