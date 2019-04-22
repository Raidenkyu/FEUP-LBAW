-- Drop Types

DROP TYPE IF EXISTS List CASCADE;
DROP TYPE IF EXISTS Color CASCADE;

-- Drop Triggers


DROP TRIGGER IF EXISTS inactive_user_remove_assigns on member;
DROP TRIGGER IF EXISTS unique_forum_titles on forum;
DROP TRIGGER IF EXISTS only_manager on project_member;
DROP TRIGGER IF EXISTS make_everyone_manager on project_member;
DROP TRIGGER IF EXISTS create_invite_notification on invite;


DROP FUNCTION IF EXISTS inactive_user_remove_assigns();
DROP FUNCTION IF EXISTS unique_forum_titles();
DROP FUNCTION IF EXISTS only_manager();
DROP FUNCTION IF EXISTS make_everyone_manager();
DROP FUNCTION IF EXISTS create_invite_notification();


-- Drop Tables

DROP TABLE IF EXISTS member, default_auth, google_auth, project, project_member, task, assigned_to, subtask, task_comment, forum, forum_comment, notification, admin, invite CASCADE;


DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS cards CASCADE;
DROP TABLE IF EXISTS items CASCADE;

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  email VARCHAR UNIQUE NOT NULL,
  password VARCHAR NOT NULL,
  remember_token VARCHAR
);

CREATE TABLE cards (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  user_id INTEGER REFERENCES users NOT NULL
);

CREATE TABLE items (
  id SERIAL PRIMARY KEY,
  card_id INTEGER NOT NULL REFERENCES cards ON DELETE CASCADE,
  description VARCHAR NOT NULL,
  done BOOLEAN NOT NULL DEFAULT FALSE
);

INSERT INTO users VALUES (
  DEFAULT,
  'John Doe',
  'john@example.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'
); -- Password is 1234. Generated using Hash::make('1234')

INSERT INTO cards VALUES (DEFAULT, 'Things to do', 1);
INSERT INTO items VALUES (DEFAULT, 1, 'Buy milk');
INSERT INTO items VALUES (DEFAULT, 1, 'Walk the dog', true);

INSERT INTO cards VALUES (DEFAULT, 'Things not to do', 1);
INSERT INTO items VALUES (DEFAULT, 2, 'Break a leg');
INSERT INTO items VALUES (DEFAULT, 2, 'Crash the car');




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

CREATE TABLE invite (
    id_invite SERIAL PRIMARY KEY,
    id_member INTEGER NOT NULL REFERENCES member (id_member) ON UPDATE CASCADE,
    id_project INTEGER NOT NULL REFERENCES project (id_project) ON UPDATE CASCADE
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

CREATE INDEX developer_project ON project_member (id_project,manager);
CREATE INDEX task_project ON task USING hash(id_project);
CREATE INDEX member_task ON assigned_to USING hash(id_task);
CREATE INDEX task_member ON assigned_to USING hash(id_member);
CREATE INDEX subtask_task ON subtask USING hash(id_task);
CREATE INDEX comment_task ON task_comment USING hash(id_task);
CREATE INDEX forum_project ON forum USING hash(id_project);
CREATE INDEX comment_forum ON forum_comment USING hash(id_forum);
CREATE INDEX notification_member ON notification USING hash(id_member);

CREATE INDEX search_idx_name ON MEMBER USING GIST (to_tsvector('english', ' ' || name || username));
CREATE INDEX search_idx_desc ON MEMBER USING GIST (to_tsvector('english', ' ' || about || description || location));


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



CREATE OR REPLACE FUNCTION only_manager()
RETURNS TRIGGER AS 
$BODY$
begin
    IF (SELECT COUNT(*) FROM(SELECT id_member FROM project_member WHERE id_project = NEW.id_project AND manager = true) AS id) = 0 THEN
        RAISE EXCEPTION 'Cannot remove only manager';
    END IF;
return new;
end;
$BODY$
language plpgsql;

CREATE TRIGGER only_manager
    AFTER UPDATE ON project_member
    FOR EACH ROW
    EXECUTE PROCEDURE only_manager();



CREATE OR REPLACE FUNCTION make_everyone_manager()
RETURNS TRIGGER AS
$BODY$
begin
    IF (old.manager = true AND (SELECT count(*) FROM project_member WHERE id_project = old.id_project AND manager = true) = 0) THEN
    UPDATE project_member SET manager = true WHERE id_project = old.id_project;
    END IF;
return old;
end;
$BODY$
language plpgsql;


CREATE TRIGGER make_everyone_manager
    AFTER DELETE ON project_member
    FOR EACH ROW
    EXECUTE PROCEDURE make_everyone_manager();


CREATE OR REPLACE FUNCTION create_invite_notification()
RETURNS TRIGGER AS
$BODY$
begin
    INSERT INTO notification (id_member, content, interactable) VALUES (NEW.id_member, ('You have been invited to Join Project ' || (SELECT max(name) FROM project WHERE id_project = NEW.id_project)), true);
return new;
end;
$BODY$
language plpgsql;


CREATE TRIGGER create_invite_notification
    AFTER INSERT ON invite
    FOR EACH ROW
    EXECUTE PROCEDURE create_invite_notification();

-- deletes (order is important!)

DELETE FROM admin;
DELETE FROM invite;
DELETE FROM subtask;
DELETE FROM task_comment;
DELETE FROM forum_comment;
DELETE FROM default_auth;
DELETE FROM google_auth;
DELETE FROM project_member;
DELETE FROM assigned_to;
DELETE FROM task;
DELETE FROM forum;
DELETE FROM project;
DELETE FROM notification;
DELETE FROM member;

-- member (id_member, name, username, email, about, description, location, phone_number, region_code, banned)
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(1, 'Cláudio Lemos', 'claudiolemos', 'claudio@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000001', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(2, 'Fernando Alves', 'fernandoalves', 'fernando@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000002', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(3, 'João Maduro', 'joaomaduro', 'joao@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000003', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(4, 'Pedro Gonçalves', 'pedrogoncalves', 'pedro@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000004', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(5, 'Alexandra Mendes', 'alexandramendes', 'alexandra@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000005', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(6, 'Fábio Bernardo', 'fabiobernardo', 'fabio@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000006', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(7, 'Duarte Oliveira', 'duarteoliveira', 'duarte@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000007', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(8, 'Diogo Silva', 'diogosilva', 'diogo@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000008', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(9, 'Carolina Soares', 'carolinasoares', 'carolina@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000009', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(10, 'Rúben Barreiro', 'rubenbarreiro', 'ruben@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000010', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(11, 'Vitor Lopes', 'vitorlopes', 'vitor@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000011', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(12, 'António Marques', 'antoniomarques', 'antonio@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000012', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(13, 'Rita Pinto', 'ritapinto', 'rita@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000013', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(14, 'Daniela Pereira', 'danielapereira', 'daniela@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000014', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(15, 'Joana Ramos', 'joanaramos', 'joana@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000015', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(16, 'Mariana Azevedo', 'marianaazevedo', 'mariana@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000016', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(17, 'Maria Cardoso', 'mariacardoso', 'maria@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000017', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(18, 'Helena Sampaio', 'helenasampaio', 'helena@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000018', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(19, 'Paula Rocha', 'paularocha', 'paula@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000019', '351', false);
INSERT INTO member (id_member, name, username, email, about, description, location, phone_number, region_code, banned) VALUES(20, 'Beatriz Henriques', 'beatrizhenriques', 'beatriz@mail.com', 'Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod commodo velit, ut tincidunt urna consectetur eget. Aliquam vestibulum, sem et congue tincidunt, nibh ligula commodo urna, at gravida ante tortor eget magna. Curabitur euismod enim quis accumsan semper. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin.', 'Porto, Portugal', '910000020', '351', false);

SELECT setval(pg_get_serial_sequence('member', 'id_member'), (SELECT MAX(id_member) FROM member));


-- default_auth (id_member, password)
INSERT INTO default_auth (id_member, password) VALUES(1, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(2, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(3, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(4, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(5, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(6, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(7, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(8, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(9, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO default_auth (id_member, password) VALUES(10, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');


-- google_auth (id_member, password)
INSERT INTO google_auth (id_member, password) VALUES(11, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(12, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(13, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(14, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(15, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(16, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(17, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(18, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(19, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO google_auth (id_member, password) VALUES(20, '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');


-- project (id_project, name, color, end_date, deleted)
INSERT INTO project (id_project, name, color, end_date, deleted) VALUES(1, 'workpad', 'Green', '2019-06-02 12:00:00', false);
INSERT INTO project (id_project, name, color, end_date, deleted) VALUES(2, 'NIFEUP', 'Orange', '2019-06-02 12:00:00', false);
INSERT INTO project (id_project, name, color, end_date, deleted) VALUES(3, 'IEEE', 'Blue', '2019-06-02 12:00:00', false);
INSERT INTO project (id_project, name, color, end_date, deleted) VALUES(4, 'AEFEUP', 'Yellow', '2019-06-02 12:00:00', false);
INSERT INTO project (id_project, name, color, end_date, deleted) VALUES(5, 'Tuga POP', 'Red', '2019-06-02 12:00:00', false);

SELECT setval(pg_get_serial_sequence('project', 'id_project'), (SELECT MAX(id_project) FROM project));


-- project_member (id_project, id_member, manager)
INSERT INTO project_member (id_project, id_member, manager) VALUES(1, 1, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(1, 2, true);
INSERT INTO project_member (id_project, id_member, manager) VALUES(1, 3, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(1, 4, true);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 4, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 5, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 7, true);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 10, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 11, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 12, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 13, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 14, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(2, 15, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 8, true);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 9, true);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 16, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 17, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 18, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 19, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(3, 20, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 1, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 2, true);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 3, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 4, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 5, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 6, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 7, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 8, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 9, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(4, 10, false);
INSERT INTO project_member (id_project, id_member, manager) VALUES(5, 1, true);


-- task (id_task, id_project, list_name, name, description, creation_date, due_date, issue)
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(1, 1, 'To Do', 'Create database', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(2, 1, 'In Progress', 'Storyboards', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(3, 1, 'Pending Approval', 'Create workpad logo', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(4, 1, 'Done', 'Create team', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(5, 2, 'To Do', 'Start projects', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(6, 2, 'In Progress', 'Decide projects', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(7, 2, 'Pending Approval', 'Brainstorm ideas for projects', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(8, 2, 'Done', 'Create teams', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(9, 3, 'To Do', 'Start projects', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(10, 3, 'In Progress', 'Decide projects', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(11, 3, 'Pending Approval', 'Brainstorm ideas for projects', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(12, 3, 'Done', 'Create teams', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(13, 4, 'To Do', 'Book artists', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(14, 4, 'In Progress', 'Decide party themes', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(15, 4, 'Pending Approval', 'Brainstorm ideas for parties', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(16, 4, 'Done', 'Create teams', null, '2019-04-01 12:00:00', '2019-06-02 12:00:00', null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(17, 5, 'To Do', 'Choose theme', null, '2019-04-01 12:00:00', null, null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(18, 5, 'In Progress', 'Implement Wordpress', null, '2019-04-01 12:00:00', null, null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(19, 5, 'Pending Approval', 'Create logo', null, '2019-04-01 12:00:00', null, null);
INSERT INTO task (id_task, id_project, list_name, name, description, creation_date, due_date, issue) VALUES(20, 5, 'Done', 'Buy domain', null, '2019-04-01 12:00:00', null, null);

SELECT setval(pg_get_serial_sequence('task', 'id_task'), (SELECT MAX(id_task) FROM task));


-- assigned_to (id_member, id_task)
INSERT INTO assigned_to (id_member, id_task) VALUES (1,1);
INSERT INTO assigned_to (id_member, id_task) VALUES (2,2);
INSERT INTO assigned_to (id_member, id_task) VALUES (3,3);
INSERT INTO assigned_to (id_member, id_task) VALUES (4,4);
INSERT INTO assigned_to (id_member, id_task) VALUES (4,5);
INSERT INTO assigned_to (id_member, id_task) VALUES (5,6);
INSERT INTO assigned_to (id_member, id_task) VALUES (7,7);
INSERT INTO assigned_to (id_member, id_task) VALUES (10,8);
INSERT INTO assigned_to (id_member, id_task) VALUES (8,9);
INSERT INTO assigned_to (id_member, id_task) VALUES (9,10);
INSERT INTO assigned_to (id_member, id_task) VALUES (16,11);
INSERT INTO assigned_to (id_member, id_task) VALUES (17,12);
INSERT INTO assigned_to (id_member, id_task) VALUES (1,13);
INSERT INTO assigned_to (id_member, id_task) VALUES (2,14);
INSERT INTO assigned_to (id_member, id_task) VALUES (3,15);
INSERT INTO assigned_to (id_member, id_task) VALUES (4,16);
INSERT INTO assigned_to (id_member, id_task) VALUES (1,17);
INSERT INTO assigned_to (id_member, id_task) VALUES (1,18);
INSERT INTO assigned_to (id_member, id_task) VALUES (1,19);
INSERT INTO assigned_to (id_member, id_task) VALUES (1,20);


-- subtask (id_subtask, id_task, brief)
INSERT INTO subtask (id_subtask, id_task, brief) VALUES (1, 3, 'Sketch');
INSERT INTO subtask (id_subtask, id_task, brief) VALUES (2, 3, 'Vectorize');
INSERT INTO subtask (id_subtask, id_task, brief) VALUES (3, 13, 'Contact booking agencies');
INSERT INTO subtask (id_subtask, id_task, brief) VALUES (4, 13, 'Ask for price');
INSERT INTO subtask (id_subtask, id_task, brief) VALUES (5, 13, 'Email rider');

SELECT setval(pg_get_serial_sequence('subtask', 'id_subtask'), (SELECT MAX(id_subtask) FROM subtask));


-- task_comment (id_task_comment, id_member, id_task, content, date)
INSERT INTO task_comment (id_task_comment, id_member, id_task, content, date) VALUES (1, 1, 3, 'Make the w bigger. The rest is perfect. Good work!', '2019-03-25 12:00:00');

SELECT setval(pg_get_serial_sequence('task_comment', 'id_task_comment'), (SELECT MAX(id_task_comment) FROM task_comment));


-- forum (id_forum, id_project, topic)
INSERT INTO forum (id_forum, id_project, topic) VALUES (1, 1, 'General');
INSERT INTO forum (id_forum, id_project, topic) VALUES (2, 2, 'Team 1');
INSERT INTO forum (id_forum, id_project, topic) VALUES (3, 2, 'Team 2');
INSERT INTO forum (id_forum, id_project, topic) VALUES (4, 3, 'Team 1');
INSERT INTO forum (id_forum, id_project, topic) VALUES (5, 3, 'Team 2');
INSERT INTO forum (id_forum, id_project, topic) VALUES (6, 4, 'Team 1');
INSERT INTO forum (id_forum, id_project, topic) VALUES (7, 4, 'Team 2');

SELECT setval(pg_get_serial_sequence('forum', 'id_forum'), (SELECT MAX(id_forum) FROM forum));


-- forum_comment (id_forum_comment, id_member, id_forum, content, date)
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (1, 1, 1, 'Hello everyone!', '2019-03-25 12:00:00');
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (2, 7, 2, 'Hello everyone!', '2019-03-25 12:00:00');
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (3, 7, 3, 'Hello everyone!', '2019-03-25 12:00:00');
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (4, 8, 4, 'Hello everyone!', '2019-03-25 12:00:00');
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (5, 8, 5, 'Hello everyone!', '2019-03-25 12:00:00');
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (6, 2, 6, 'Hello everyone!', '2019-03-25 12:00:00');
INSERT INTO forum_comment (id_forum_comment, id_member, id_forum, content, date) VALUES (7, 2, 7, 'Hello everyone!', '2019-03-25 12:00:00');

SELECT setval(pg_get_serial_sequence('forum_comment', 'id_forum_comment'), (SELECT MAX(id_forum_comment) FROM forum_comment));


-- notification (id_notification, id_member, content, seen, interactable, link)
INSERT INTO notification (id_notification, id_member, content, seen, interactable, link) VALUES (1, 1, 'Pedro commented on your task', true, false, '/');
INSERT INTO notification (id_notification, id_member, content, seen, interactable, link) VALUES (2, 2, 'Claudio commented on your task', true, false, '/');

SELECT setval(pg_get_serial_sequence('notification', 'id_notification'), (SELECT MAX(id_notification) FROM notification));


-- invite (id_invite, id_member, id_project)

INSERT INTO invite (id_invite, id_member, id_project) VALUES (1,3,2);
INSERT INTO invite (id_invite, id_member, id_project) VALUES (2,9,2);
INSERT INTO invite (id_invite, id_member, id_project) VALUES (3,12,2);
INSERT INTO invite (id_invite, id_member, id_project) VALUES (4,15,2);

SELECT setval(pg_get_serial_sequence('invite', 'id_invite'), (SELECT MAX(id_invite) FROM invite));


-- admin (id_admin, username, password)
INSERT INTO admin (id_admin, username, password) VALUES (1, 'claudio', '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO admin (id_admin, username, password) VALUES (2, 'fernando', '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO admin (id_admin, username, password) VALUES (3, 'joao', '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');
INSERT INTO admin (id_admin, username, password) VALUES (4, 'pedro', '03AC674216F3E15C761EE1A5E255F067953623C8B388B4459E13F978D7C846F4');


