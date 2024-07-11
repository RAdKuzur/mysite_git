CREATE TABLE u1471742_index.files_tmp (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          table_name VARCHAR(255) NOT NULL,
                                          table_row_id INT NOT NULL,
                                          file_type VARCHAR(1000) NOT NULL,
                                          filepath VARCHAR(1000) NOT NULL
);
CREATE TABLE u1471742_index.files_tmp_2 (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            table_name VARCHAR(1000) NOT NULL,
                                            table_row_id INT NOT NULL,
                                            file_type VARCHAR(1000) NOT NULL,
                                            filepath VARCHAR(1000) NOT NULL
);
CREATE TABLE u1471742_index.files_tmp_3 (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            table_name VARCHAR(1000) NOT NULL,
                                            table_row_id INT NOT NULL,
                                            file_type VARCHAR(1000) NOT NULL,
                                            filepath VARCHAR(1000) NOT NULL
);

INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT 'document_in', `id`, 'doc', `doc`
FROM u1471742_index.`document_in`
WHERE `doc` != '';

INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT 'document_in', `id`, 'scan', `scan`
FROM u1471742_index.`document_in`
WHERE `scan` != '';

INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT 'document_in', `id`, 'application', `applications`
FROM u1471742_index.`document_in`
WHERE `applications` != '';

INSERT INTO u1471742_index.files_tmp_2 (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT `table_name`, `table_row_id`, `file_type`, SUBSTRING_INDEX(SUBSTRING_INDEX(`filepath`, ' ', n), ' ', -1) AS filepath
FROM u1471742_index.files_tmp, (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4  UNION ALL SELECT 5
                                UNION ALL SELECT 6  UNION ALL SELECT 7  UNION ALL SELECT 8  UNION ALL SELECT 9
                                UNION ALL SELECT 10  UNION ALL SELECT 11) numbers
WHERE n <= 1 + (LENGTH(`filepath`) - LENGTH(REPLACE(`filepath`, ' ', '')));

INSERT INTO u1471742_index.files_tmp_3 (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT `table_name`, `table_row_id`, `file_type`, `filepath`
FROM u1471742_index.files_tmp_2
WHERE `filepath` != '';
DELETE t1
FROM u1471742_index.files_tmp_3 t1
INNER JOIN u1471742_index.files_tmp_3 t2
WHERE t1.filepath = t2.filepath AND t1.id > t2.id;

INSERT INTO docs2_db.files (`table_name`,`table_row_id`, `file_type`, `filepath`)
SELECT `table_name`,`table_row_id`, `file_type`, `filepath`
FROM u1471742_index.files_tmp_3;

DROP TABLE u1471742_index.files_tmp;
DROP TABLE u1471742_index.files_tmp_2;
DROP TABLE u1471742_index.files_tmp_3;
