-- Drop Types

DROP TYPE IF EXISTS List CASCADE;
DROP TYPE IF EXISTS Color CASCADE;

-- Drop Tables

DROP TABLE IF EXISTS member, defaultAuth, googleAuth, project, projectMember, task, assignTo, subtask, taskComment, forum, forumComment, notification, admin CASCADE;

-- Types
 
CREATE TYPE List AS ENUM ('To Do', 'In Progress', 'Pending Approval', 'Done');
 
CREATE TYPE Color AS ENUM ('Orange', 'Yellow', 'Red', 'Green', 'Lilac', 'Sky', 'Blue', 'Purple', 'Emerald', 'Bordeaux', 'Golden', 'Brown');

--CREATE TYPE Today DATE DEFAULT CURRENT_DATE;



-- Tables
 
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
    banned BOOLEAN DEFAULT FALSE
);

CREATE TABLE default_auth (
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    password TEXT NOT NULL
);

CREATE TABLE google_auth (
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
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
    id_project INTEGER REFERENCES project (id_project) ON UPDATE CASCADE,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    manager BOOLEAN NOT NULL
);

CREATE TABLE task (
    id_task SERIAL PRIMARY KEY,
    id_project INTEGER REFERENCES project (id_project) ON UPDATE CASCADE,
    list_name List NOT NULL,
    name text NOT NULL,
    description text NOT NULL,
    creation_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    due_date TIMESTAMP WITH TIME zone NOT NULL,
    CONSTRAINT task_date_ck CHECK (due_date > creation_date),
    issue text
);

CREATE TABLE assign_to (
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    id_task INTEGER REFERENCES task (id_task) ON UPDATE CASCADE
);


CREATE TABLE subtask(
    id_subtask INTEGER PRIMARY KEY,
    id_task INTEGER REFERENCES task (id_task) ON UPDATE CASCADE,
    brief text NOT NULL
);



CREATE TABLE task_comment (
    id_task_comment SERIAL PRIMARY KEY,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    id_task INTEGER REFERENCES task (id_task) ON UPDATE CASCADE,
    content text NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);


CREATE TABLE forum (
    id_forum SERIAL PRIMARY KEY,
    id_project INTEGER REFERENCES project (id_project) ON UPDATE CASCADE,
    topic text NOT NULL
);



CREATE TABLE forum_comment (
    id_forum_comment SERIAL PRIMARY KEY,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    id_forum INTEGER REFERENCES forum (id_forum) ON UPDATE CASCADE,
    content text NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);


CREATE TABLE notification (
    id_notification SERIAL PRIMARY KEY,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    content text NOT NULL,
    seen BOOLEAN DEFAULT FALSE NOT NULL,
    interactable BOOLEAN NOT NULL
);

CREATE TABLE admin (
    id_admin SERIAL PRIMARY KEY,
    username text NOT NULL CONSTRAINT admin_name UNIQUE,
    password text NOT NULL
);

