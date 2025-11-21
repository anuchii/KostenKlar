-- Es ist after password damit der insert vom register passt, 
--bzw. die Reihenfolge von den Daten vom insert 
-- gebdatum passt dann mit den variablen vom Code
-- Die neuen Spalten (gebdatum und geschlecht) dürfen am Anfang leer sein.
-- damit sich alte User weiter einloggen können ohne Fehlermeldung.
-- dann, wenn wir alle User aktualisiert haben, kann man einstellen,
--dass die Felder nicht mehr leer sein dürfen. 
ALTER TABLE users
ADD COLUMN gebdatum DATE NULL AFTER password,
ADD COLUMN geschlecht ENUM('weiblich', 'männlich', 'divers') NULL AFTER gebdatum;