CREATE OR REPLACE FUNCTION make_everyone_manager()
RETURN TRIGGER AS
$BODY$
BEGIN
    IF (old.manager = true)
    UPDATE project_member SET manager = true where id_project = old.id_project
    END IF;
END;
$BODY$
language plpgsql;


CREATE TRIGGER ban_manager
    BEFORE DELETE ON project_member
    FOR EACH ROW
    EXECUTE PROCEDURE make_everyone_manager();



