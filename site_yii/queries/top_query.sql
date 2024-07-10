CREATE TABLE u1471742_index.files_tmp (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          table_name VARCHAR(255) NOT NULL,
                                          table_row_id INT NOT NULL,
                                          file_type VARCHAR(255) NOT NULL,
                                          filepath VARCHAR(255) NOT NULL
);
CREATE TABLE u1471742_index.files_tmp_2 (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            table_name VARCHAR(255) NOT NULL,
                                            table_row_id INT NOT NULL,
                                            file_type VARCHAR(255) NOT NULL,
                                            filepath VARCHAR(255) NOT NULL
);
CREATE TABLE u1471742_index.files_tmp_3 (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            table_name VARCHAR(255) NOT NULL,
                                            table_row_id INT NOT NULL,
                                            file_type VARCHAR(255) NOT NULL,
                                            filepath VARCHAR(255) NOT NULL
);

INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT 'document_in', `id`, 'doc', `doc`
FROM `document_in`
WHERE `doc` != '';

INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT 'document_in', `id`, 'scan', `scan`
FROM `document_in`
WHERE `scan` != '';

INSERT INTO u1471742_index.files_tmp (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT 'document_in', `id`, 'application', `applications`
FROM `document_in`
WHERE `applications` != '';

INSERT INTO u1471742_index.files_tmp_2 (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT `table_name`, `table_row_id`, `file_type`, SUBSTRING_INDEX(SUBSTRING_INDEX(`filepath`, ' ', n), ' ', -1) AS filepath
FROM files_tmp, (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) numbers
WHERE n <= 1 + (LENGTH(`filepath`) - LENGTH(REPLACE(`filepath`, ' ', '')));

INSERT INTO u1471742_index.files_tmp_3 (`table_name`, `table_row_id`, `file_type`, `filepath`)
SELECT `table_name`, `table_row_id`, `file_type`, `filepath`
FROM u1471742_index.files_tmp_2
WHERE `filepath` != '';
