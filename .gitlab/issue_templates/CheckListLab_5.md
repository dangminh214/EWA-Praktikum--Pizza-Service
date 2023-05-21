---
name: Checkliste Praktikum 5
about: Template zur Bewertung des Praktikums

---

# Bewertung
 
1. Funktion
Vorher: Durchführung von je einer Bestellung in 2 Browsern mit "böser" XSS-Adresse
  - [ ] Der Warenkorb erlaubt das Löschen von einzelnen Pizzen und von allen Pizzen und rechnet korrekt?  
  - [ ] Die Bestellung kann erst abgeschickt werden, wenn sich mindestens eine Pizza im Warenkorb befindet und das Adressfeld nicht leer ist? Vorher ist der "Bestellen"-Knopf deaktiviert? 
  - [ ] Wenn man 2 Bestellungen in verschiedenen Browsern abschickt, sieht der jeweilige Browser (Kunde) nur die eigene Bestellung? 
  - [ ] Die Kundenseite wird nach der Bestellung geöffnet und aktualisiert sich ohne Neuladen (mit AJAX)? 
  - [ ] Die Kundenseite kann mit F5 neu geladen werden ohne dass ein Popup erscheint (PRG-Pattern)?   
  - [ ] Statusänderung auf der Bäcker- [ ] oder Fahrerseite werden kurz darauf auf der Kundenseite angezeigt? 
  - [ ] Fertig gebackene Pizzen verschwinden erst von der Bäckerseite, wenn der Fahrer die Bestellung übernimmt (unterwegs)? 
  - [ ] Bestellungen verschwinden nach der Auslieferung von der Fahrerseite? 
  - [ ] HTML-Tags im Adressfeld einer Bestellung (XSS) werden auf der Fahrerseits nicht ausgeführt? 
  
2. Layout
  - [ ] Ansprechendes Design? 
  - [ ] Auf der Bestellseite verwenden Sie Media Queries um ansprechende Layouts für mindestens 2 Bildschirmformate umzusetzen? 
  - [ ] Der Warenkorb rutscht je nach Bildschirmbreite und Ausrichtung neben oder unter die Speisekarte? 
  - [ ] CSS-Code: Verwendung von "barrierefreien" Maßeinheiten (z.B. kein px außerhalb von Media Queries)? 
  
# Abgabe
- [ ] Die Übersichtsseite erfüllt die Kundenanforderungen
- [ ] Die Bestellseite erfüllt die Kundenanforderungen
- [ ] Die Kundenstatusseite erfüllt die Kundenanforderungen
- [ ] Die Bäckerseite erfüllt die Kundenanforderungen
- [ ] Die Fahrerseite erfüllt die Kundenanforderungen

# Bemerkungen / Hinweise
- 

# Gesamtergebnis (Ampelskala)
- 