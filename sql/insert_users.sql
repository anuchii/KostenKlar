USE kostenklar;

/* PASSWORD: HASH (BCRYPT)
	password#user1: $2y$10$Zh3OB81kn4krksYP9Xe3Je7NVC4/PM7pcGUB6/hYY7qMj9s5tcS1a
	password#user2: $2y$10$wcMNBgrMK5uaJSfWVd9KtuXT3bWI0tGKPfPQDD74mYhTV6LKewCBy 
	password#user3: $2y$10$4NTXUgftj8u/TSfGiriDoOwal7I4RJC6HCXN3tyyuxFu6invbCT7u
	password#admin: $2y$10$fMFXBdT0IwUifR2ZLen4/uPXRLUxMqQmB/NUxYdFfnOymP1Aegnc.
*/

INSERT INTO users (first_name, last_name, email, password, gebdatum, geschlecht, role, status)
	VALUES
		('John', 'Doe', 'john@doe.com', '$2y$10$Zh3OB81kn4krksYP9Xe3Je7NVC4/PM7pcGUB6/hYY7qMj9s5tcS1a', '1976-05-17', 'männlich', 'user', 'active'),
		('Jane', 'Smith', 'jane.smith@test.org', '$2y$10$wcMNBgrMK5uaJSfWVd9KtuXT3bWI0tGKPfPQDD74mYhTV6LKewCBy', '1990-10-02', 'weiblich', 'user', 'active'),
		('Max', 'Mustermann', 'm.mustermann@example.at', '$2y$10$wcMNBgrMK5uaJSfWVd9KtuXT3bWI0tGKPfPQDD74mYhTV6LKewCBy', '2002-08-23', 'weiblich', 'user', 'active'),
		('Erika', 'Mustermann', 'erika.mustermann@kostenklar.at', '$2y$10$fMFXBdT0IwUifR2ZLen4/uPXRLUxMqQmB/NUxYdFfnOymP1Aegnc.', '1986-02-18', 'weiblich', 'admin', 'active');