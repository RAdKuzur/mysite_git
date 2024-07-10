INSERT INTO docs2_db.files (`table_name`,`table_row_id`, `file_type`, `filepath`)
SELECT `table_name`,`table_row_id`, `file_type`, `filepath`
FROM u1471742_index.files;