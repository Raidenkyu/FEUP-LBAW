-- Drop Types

DROP TYPE IF EXISTS List CASCADE;
DROP TYPE IF EXISTS Color CASCADE;

-- Drop Tables

DROP TABLE IF EXISTS member, defaultAuth, googleAuth, project, projectMember, task, assignTo,
tasklist, subtask, taskComment, forum, forumComment, notification, admin CASCADE;

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
    phone_number INTEGER CONSTRAINT user_phone_uk UNIQUE,
    region_code INTEGER,
    banned BOOLEAN DEFAULT FALSE
);

CREATE TABLE defaultAuth (
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    password TEXT NOT NULL
);

CREATE TABLE googleAuth (
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

CREATE TABLE projectMember (
    id_project INTEGER REFERENCES project (id_project) ON UPDATE CASCADE,  -- TODO: LER DOC A TENTAR PERCEBER O PORQUE DISTO
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    manager BOOLEAN NOT NULL
);

CREATE TABLE task (
    id_task SERIAL PRIMARY KEY,
    id_project INTEGER REFERENCES project (id_project) ON UPDATE CASCADE,  -- TODO: LER DOC A TENTAR PERCEBER O PORQUE DISTO
    --id_tasklist,   -- TODO: Se faltarem tables, dividir o tasklist em 4 para cada secçao OU nem ter a tabela tasklist
    name text NOT NULL,
    description text NOT NULL,
    creation_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    due_date TIMESTAMP WITH TIME zone NOT NULL,
    CONSTRAINT task_date_ck CHECK (due_date > creation_date),
    issue text
);

CREATE TABLE assignTo (
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,
    id_task INTEGER REFERENCES task (id_task) ON UPDATE CASCADE
);


create TABLE tasklist (
    id_task INTEGER PRIMARY KEY REFERENCES task (id_task) ON UPDATE CASCADE,

);

CREATE TABLE subtask(
    id_subtask INTEGER PRIMARY KEY,
    id_task INTEGER REFERENCES task (id_task) ON UPDATE CASCADE
);



CREATE TABLE taskComment (
    id_task_comment SERIAL PRIMARY KEY,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,  -- TODO: LER DOC A TENTAR PERCEBER O PORQUE DISTO
    id_task INTEGER REFERENCES task (id_task) ON UPDATE CASCADE,
    content text NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);


CREATE TABLE forum (
    id_forum SERIAL PRIMARY KEY,
    id_project INTEGER REFERENCES project (id_project) ON UPDATE CASCADE,
    topic text NOT NULL
);



CREATE TABLE forumComment (
    id_forum_comment SERIAL PRIMARY KEY,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,  -- TODO: LER DOC A TENTAR PERCEBER O PORQUE DISTO
    id_forum INTEGER REFERENCES forum (id_forum) ON UPDATE CASCADE,
    content text NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);


CREATE TABLE notification (
    id_notification SERIAL PRIMARY KEY,
    id_member INTEGER REFERENCES member (id_member) ON UPDATE CASCADE,  -- TODO: LER DOC A TENTAR PERCEBER O PORQUE DISTO
    content text NOT NULL,
    interactable BOOLEAN NOT NULL

);

CREATE TABLE admin (
    id_admin SERIAL PRIMARY KEY,
    username text NOT NULL CONSTRAINT admin_name UNIQUE,
    password text NOT NULL
);



/*
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    email text NOT NULL CONSTRAINT user_email_uk UNIQUE,
    name text NOT NULL,
    obs text,
    password text NOT NULL,
    img text,
    is_admin BOOLEAN NOT NULL
);
 
CREATE TABLE publisher (
    id SERIAL PRIMARY KEY,
    name text NOT NULL
);
 
CREATE TABLE location (
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    address text NOT NULL,
    gps text
);
 
CREATE TABLE author (
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    img text
);
 
CREATE TABLE collection (
    id SERIAL PRIMARY KEY,
    name text NOT NULL
);
 
CREATE TABLE "work" (
    id SERIAL PRIMARY KEY,
    title text NOT NULL,
    obs text,
    img text,
    "year" INTEGER,
    id_user INTEGER REFERENCES "user" (id) ON UPDATE CASCADE,
    id_collection INTEGER REFERENCES collection (id) ON UPDATE CASCADE,
    CONSTRAINT year_positive_ck CHECK (("year" > 0))
);
 
CREATE TABLE author_work (
    id_author INTEGER NOT NULL REFERENCES author (id) ON UPDATE CASCADE,
    id_work INTEGER NOT NULL REFERENCES "work" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_author, id_work)
);
 
CREATE TABLE book (
    id_work INTEGER PRIMARY KEY REFERENCES "work" (id) ON UPDATE CASCADE,
    edition text,
    isbn BIGINT NOT NULL CONSTRAINT book_isbn_uk UNIQUE,
    id_publisher INTEGER REFERENCES publisher (id) ON UPDATE CASCADE
);
 
CREATE TABLE nonbook (
    id_work INTEGER PRIMARY KEY REFERENCES "work" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    TYPE media NOT NULL
);
 
CREATE TABLE item (
    id SERIAL PRIMARY KEY,
    id_work INTEGER NOT NULL REFERENCES "work" (id) ON UPDATE CASCADE,
    id_location INTEGER NOT NULL REFERENCES location (id) ON UPDATE CASCADE,
    code INTEGER NOT NULL,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);
 
CREATE TABLE loan (
    id SERIAL PRIMARY KEY,
    id_item INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
    id_user INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
    start_t TIMESTAMP WITH TIME zone NOT NULL,
    end_t TIMESTAMP WITH TIME zone NOT NULL,
    CONSTRAINT date_ck CHECK (end_t > start_t)
);
 
CREATE TABLE review (
    id_work INTEGER NOT NULL REFERENCES "work" (id) ON UPDATE CASCADE,
    id_user INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
    "date" TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    comment text NOT NULL,
    rating INTEGER NOT NULL CONSTRAINT rating_ck CHECK (((rating > 0) OR (rating <= 5))),
    PRIMARY KEY (id_work, id_user)
);
 
CREATE TABLE wish_list (
    id_work INTEGER NOT NULL REFERENCES "work" (id) ON UPDATE CASCADE,
    id_user INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_work, id_user)
);
*/