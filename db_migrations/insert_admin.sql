USE kostenklar;

/* PASSWORD: HASH (BCRYPT)
	password#admin: $2y$10$fMFXBdT0IwUifR2ZLen4/uPXRLUxMqQmB/NUxYdFfnOymP1Aegnc.
*/

INSERT INTO users (first_name, last_name, email, password, gebdatum, geschlecht, role, status)
	VALUES
		('Erika', 'Mustermann', 'erika.mustermann@kostenklar.at', '$2y$10$fMFXBdT0IwUifR2ZLen4/uPXRLUxMqQmB/NUxYdFfnOymP1Aegnc.', '1986-02-18', 'weiblich', 'admin', 'active');