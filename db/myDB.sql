/*A few helpful things to be aware of:

1. Don’t forget `;` at the end of your line.

2. `\q` will quit and get you back to the regular command line.

3. `\dt` will list all the tables in your current database.

psql postgres://mswvtmwuakblzn:3d807e9b9a0cab27b2a3a786ff97e2f2b24bf1a2f57b8840ea45a1d57600d790@ec2-174-129-32-37.compute-1.amazonaws.com:5432/dedvidl0uucsbs

5432 port
p4*/

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
    difficulty VARCHAR(100) NOT NULL,
    is_complete BOOLEAN NOT NULL
);

CREATE TABLE public.subtask
(
	id SERIAL NOT NULL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES public.user(id),
    task_id INT NOT NULL REFERENCES public.task(id),
	task_text TEXT NOT NULL,
    is_complete BOOLEAN NOT NULL
);

/*Insert some dummy data for testing purposes*/
INSERT into public.user(username, user_password, first_name, last_name, display_color) VALUES ('username', 'password', 'Ann', 'Halgren', 'coral');
INSERT into public.task(user_id, task_text, date_added, date_due, classification, difficulty, is_complete) VALUES (1, 'I have to complete this assignment', current_timestamp, '2018-10-20', 'urgent', 'hard', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 1, 'Insert values into my database', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 1, 'Get items from my database with php', false);