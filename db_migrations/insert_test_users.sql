USE kostenklar;

/* PASSWORD: HASH (BCRYPT)
	User 1
	Password: 		password#user1
	Password hash:	$2y$10$Zh3OB81kn4krksYP9Xe3Je7NVC4/PM7pcGUB6/hYY7qMj9s5tcS1a
	User 2
	Password: 		password#user2
	Password hash: 	$2y$10$wcMNBgrMK5uaJSfWVd9KtuXT3bWI0tGKPfPQDD74mYhTV6LKewCBy
	User 3
	Password: 		password#user3
	Password hash: 	2y$10$4NTXUgftj8u/TSfGiriDoOwal7I4RJC6HCXN3tyyuxFu6invbCT7u
*/

INSERT INTO users (first_name, last_name, email, password, gebdatum, geschlecht, role, status)
	VALUES
		('John', 'Doe', 'john@doe.com', '$2y$10$Zh3OB81kn4krksYP9Xe3Je7NVC4/PM7pcGUB6/hYY7qMj9s5tcS1a', '1976-05-17', 'maennlich', 'user', 'active'),
		('Jane', 'Smith', 'jane.smith@test.org', '$2y$10$wcMNBgrMK5uaJSfWVd9KtuXT3bWI0tGKPfPQDD74mYhTV6LKewCBy', '1990-10-02', 'weiblich', 'user', 'active'),
		('Max', 'Mustermann', 'm.mustermann@example.at', '$2y$10$wcMNBgrMK5uaJSfWVd9KtuXT3bWI0tGKPfPQDD74mYhTV6LKewCBy', '2002-08-23', 'weiblich', 'user', 'active');