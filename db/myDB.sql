CREATE TABLE public.user
(
	id SERIAL NOT NULL PRIMARY KEY,
	username VARCHAR(100) NOT NULL UNIQUE,
	user_password VARCHAR(100) NOT NULL,
	first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    display_color VARCHAR(100)
);



CREATE TABLE public.task
(
	id SERIAL NOT NULL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES public.user(id),
	task_text TEXT NOT NULL,
    date_added DATE NOT NULL,
    date_due DATE,
    classification VARCHAR(100) NOT NULL,
    difficulty VARCHAR(100) NOT NULL
);