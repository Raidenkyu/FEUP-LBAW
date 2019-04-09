-- Drop Types

DROP TYPE IF EXISTS List CASCADE;
DROP TYPE IF EXISTS Color CASCADE;

-- Drop Triggers


DROP TRIGGER IF EXISTS inactive_user_remove_assigns on member;
DROP TRIGGER IF EXISTS unique_forum_titles on forum;
DROP TRIGGER IF EXISTS delete_task on task;
DROP TRIGGER IF EXISTS only_manager on project_member;

DROP FUNCTION IF EXISTS inactive_user_remove_assigns();
DROP FUNCTION IF EXISTS unique_forum_titles();
DROP FUNCTION IF EXISTS delete_task();
DROP FUNCTION IF EXISTS only_manager();


-- Drop Tables

DROP TABLE IF EXISTS member, default_auth, google_auth, project, project_member, task, assigned_to, subtask, task_comment, forum, forum_comment, notification, admin CASCADE;



-- TYPES
 
CREATE TYPE List AS ENUM ('To Do', 'In Progress', 'Pending Approval', 'Done');
 
CREATE TYPE Color AS ENUM ('Orange', 'Yellow', 'Red', 'Green', 'Lilac', 'Sky', 'Blue', 'Purple', 'Emerald', 'Bordeaux', 'Golden', 'Brown');


-- TABLES
 
CREATE TABLE member (
    id_member SERIAL PRIMARY KEY,
    name text NOT NULL,
    username text NOT NULL CONSTRAINT user_username_uk UNIQUE,
    email text NOT NULL CONSTRAINT user_email_uk UNIQUE,
    about text,
    description text,
    location text,
    phone_number INTEGER,
    region_code INTEGER,
    banned BOOLEAN NOT NULL DEFAULT FALSE,
    deleted BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE default_auth (
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    password TEXT NOT NULL
);

CREATE TABLE google_auth (
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    password TEXT NOT NULL
);

CREATE TABLE project (
    id_project SERIAL PRIMARY KEY,
    name text NOT NULL,
    color Color NOT NULL DEFAULT 'Sky',
    end_date TIMESTAMP WITH TIME zone,
    deleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE project_member (
    id_project INTEGER NOT NULL REFERENCES project (id_project) ON UPDATE CASCADE,
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    manager BOOLEAN NOT NULL
);

CREATE TABLE task (
    id_task SERIAL PRIMARY KEY,
    id_project INTEGER NOT NULL REFERENCES project (id_project) ON UPDATE CASCADE,
    list_name List DEFAULT 'To Do' NOT NULL,
    name text NOT NULL,
    description text,
    creation_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    due_date TIMESTAMP WITH TIME zone,
    CONSTRAINT task_date_ck CHECK (due_date > creation_date),
    issue text
);

CREATE TABLE assigned_to (
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    id_task INTEGER NOT NULL REFERENCES task (id_task) ON UPDATE CASCADE
);

CREATE TABLE subtask(
    id_subtask SERIAL PRIMARY KEY,
    id_task INTEGER NOT NULL REFERENCES task (id_task) ON UPDATE CASCADE,
    brief text NOT NULL
);

CREATE TABLE task_comment (
    id_task_comment SERIAL PRIMARY KEY,
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    id_task INTEGER NOT NULL REFERENCES task (id_task) ON UPDATE CASCADE,
    content text NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE forum (
    id_forum SERIAL PRIMARY KEY,
    id_project INTEGER NOT NULL REFERENCES project (id_project) ON UPDATE CASCADE,
    topic text NOT NULL
);

CREATE TABLE forum_comment (
    id_forum_comment SERIAL PRIMARY KEY,
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    id_forum INTEGER NOT NULL REFERENCES forum (id_forum) ON UPDATE CASCADE,
    content text NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE notification (
    id_notification SERIAL PRIMARY KEY,
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    content text NOT NULL,
    seen BOOLEAN DEFAULT FALSE NOT NULL,
    interactable BOOLEAN NOT NULL,
    link text
);

CREATE TABLE admin (
    id_admin SERIAL PRIMARY KEY,
    username text NOT NULL CONSTRAINT admin_name UNIQUE,
    password text NOT NULL
);



-- INDEXES




-- TRIGGERS and UDFs

CREATE OR REPLACE FUNCTION inactive_user_remove_assigns()
RETURNS TRIGGER AS 
$BODY$
begin
IF NEW.banned = true THEN
    DELETE FROM assigned_to WHERE id_member = NEW.id_member;
    DELETE FROM project_member WHERE id_member = NEW.id_member;
END IF;
IF NEW.deleted = true THEN
    DELETE FROM assigned_to WHERE id_member = NEW.id_member;
    DELETE FROM project_member WHERE id_member = NEW.id_member;
END IF;
return new;
end;
$BODY$
language plpgsql;

CREATE TRIGGER inactive_user_remove_assigns
    AFTER UPDATE ON member
    FOR EACH ROW
    EXECUTE PROCEDURE inactive_user_remove_assigns();


CREATE OR REPLACE FUNCTION unique_forum_titles()
RETURNS TRIGGER AS 
$BODY$
begin
IF EXISTS (SELECT * FROM forum WHERE id_project = NEW.id_project AND topic = NEW.topic) THEN
    RAISE EXCEPTION 'A topic with the same name already exists';
END IF;
return new;
end;
$BODY$
language plpgsql;

CREATE TRIGGER unique_forum_titles
    BEFORE INSERT ON forum
    FOR EACH ROW
    EXECUTE PROCEDURE unique_forum_titles();


CREATE OR REPLACE FUNCTION delete_task()
RETURNS TRIGGER AS 
$BODY$
begin
    DELETE FROM assigned_to WHERE OLD.id_task = assigned_to.id_task;
    DELETE FROM subtask WHERE OLD.id_task = subtask.id_task;
    DELETE FROM task_comment WHERE OLD.id_task = task_comment.id_task;
return new;
end;
$BODY$
language plpgsql;

CREATE TRIGGER delete_task
    BEFORE DELETE ON task
    FOR EACH ROW
    EXECUTE PROCEDURE delete_task();


CREATE OR REPLACE FUNCTION only_manager()
RETURNS TRIGGER AS 
$BODY$
begin
    IF (SELECT COUNT(*) FROM(SELECT id_member FROM project_member WHERE id_project = NEW.id_project AND manager = true) AS id) = 1 THEN
        RAISE 'Cannot remove only manager';
    END IF;
return new;
end;
$BODY$
language plpgsql;

CREATE TRIGGER only_manager
    BEFORE UPDATE ON project_member
    FOR EACH ROW
    EXECUTE PROCEDURE only_manager();



