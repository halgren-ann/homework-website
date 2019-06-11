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
/*
INSERT into public.user(username, user_password, first_name, last_name, display_color) VALUES ('username', 'password', 'Ann', 'Halgren', 'coral');

INSERT into public.task(user_id, task_text, date_added, date_due, classification, difficulty, is_complete) VALUES (1, 'I have to complete this assignment', current_timestamp, '2018-10-20', 'urgent', 'hard', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 1, 'Insert values into my database', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 1, 'Get items from my database with php', false);

INSERT into public.task(user_id, task_text, date_added, date_due, classification, difficulty, is_complete) VALUES (1, 'I have to pay bills', current_timestamp, '2018-10-24', 'urgent', 'medium', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 2, 'Internet', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 2, 'Water', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 2, 'Electricity', false);
INSERT into public.subtask(user_id, task_id, task_text, is_complete) VALUES (1, 2, 'Waste Management', false);

INSERT into public.task(user_id, task_text, date_added, date_due, classification, difficulty, is_complete) VALUES (1, 'Exercise!', current_timestamp, NULL, 'goal', 'hard', false);
*/



/* Tables for the "Mille Bornes - Group Play" Senior Project */
CREATE TABLE public.game
(
	game_id SERIAL NOT NULL PRIMARY KEY,
	keyword VARCHAR(100) NOT NULL UNIQUE,
	num_players INT NOT NULL,
	game_obsolete BOOLEAN NOT NULL
);

CREATE TABLE public.player
(
	player_id SERIAL NOT NULL PRIMARY KEY,
	game_id INT NOT NULL REFERENCES public.game(game_id),
	player_number INT NOT NULL,
	display_name VARCHAR(100) NOT NULL,
	is_turn BOOLEAN NOT NULL,
	score INT NOT NULL
);

CREATE TABLE public.start_state
(
	game_id INT NOT NULL REFERENCES public.game(game_id),
	card_id VARCHAR NOT NULL,
	position_in_deck INT NOT NULL
);

CREATE TABLE moves
(
	move_id SERIAL NOT NULL,
	game_id INT NOT NULL REFERENCES public.game(game_id),
	player_id INT NOT NULL REFERENCES public.player(player_id),
	card_id VARCHAR(100) NOT NULL,
	start_position VARCHAR(100) NOT NULL,
	end_position VARCHAR(100) NOT NULL
);

CREATE TABLE update_manager
(
	game_id INT NOT NULL REFERENCES public.game(game_id),
	player_id INT NOT NULL REFERENCES public.player(player_id),
	seen BOOLEAN NOT NULL,
	what VARCHAR(100) NOT NULL
);
