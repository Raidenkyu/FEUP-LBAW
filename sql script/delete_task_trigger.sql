
DROP TRIGGER IF EXISTS DeleteTask;

CREATE TRIGGER IF NOT EXISTS DeleteTask
AFTER DELETE ON task
BEGIN
    DELETE FROM assign_to WHERE old.id_task = assign_to.id_task;
    DELETE FROM subtask WHERE old.id_task = subtask.id_task;
    DELETE FROM task_comment WHERE old.id_task = task_comment.id_task;
END;