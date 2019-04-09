CREATE OR REPLACE FUNCTION make_everyone_manager()
RETURN TRIGGER AS
$BODY$
begin
    IF (old.manager = true AND (count * from project_member where manager = true) = 1)
    UPDATE project_member SET manager = true where id_project = old.id_project
    END IF;
return new;
end;
$BODY$
language plpgsql;


CREATE TRIGGER ban_manager
    BEFORE DELETE ON project_member
    FOR EACH ROW
    EXECUTE PROCEDURE make_everyone_manager();



