DROP TRIGGER IF EXISTS OnlyManager;

CREATE TRIGGER IF NOT EXISTS OnlyManager
BEFORE UPDATE ON project_member
BEGIN
  IF (SELECT COUNT(*) FROM(SELECT id_member FROM project_member WHERE id_project = NEW.id_project AND manager = true) AS id) = 1
  THEN
    RAISE 'Cannot remove only manager'
  ENDIF;
END;
