DROP DATABASE bird;

CREATE DATABASE bird;

USE bird;

CREATE TABLE IF NOT EXISTS bird.users
(
    user_id       INT AUTO_INCREMENT NOT NULL,
    username      VARCHAR(50)        NOT NULL,
    user_email    VARCHAR(50)        NOT NULL,
    user_password VARCHAR(255)       NOT NULL,
    user_level    INT                NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE (user_email)
);

CREATE TABLE IF NOT EXISTS bird.valid_emails
(
    valid_email_id    INT         NOT NULL AUTO_INCREMENT,
    valid_email_email VARCHAR(50) NOT NULL,
    PRIMARY KEY (valid_email_id),
    UNIQUE (valid_email_email)
);

CREATE TABLE IF NOT EXISTS bird.disciplines
(
    discipline_id   INT AUTO_INCREMENT NOT NULL,
    discipline_name VARCHAR(25)        NOT NULL,
    PRIMARY KEY (discipline_id)
);

CREATE TABLE IF NOT EXISTS bird.topics
(
    topic_id   INT AUTO_INCREMENT NOT NULL,
    topic_name VARCHAR(25)        NOT NULL,
    PRIMARY KEY (topic_id)
);

CREATE TABLE IF NOT EXISTS bird.disciplines_has_topics
(
    discipline_id INT NOT NULL,
    topic_id      INT NOT NULL,
    PRIMARY KEY (discipline_id, topic_id),
    FOREIGN KEY (discipline_id) REFERENCES disciplines (discipline_id) ON DELETE CASCADE,
    FOREIGN KEY (topic_id) REFERENCES topics (topic_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bird.files
(
    file_id   INT AUTO_INCREMENT NOT NULL,
    file_name VARCHAR(25)        NOT NULL,
    topic_id  INT                NOT NULL,
    PRIMARY KEY (file_id),
    FOREIGN KEY (topic_id) REFERENCES topics (topic_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bird.types
(
    type_id   INT AUTO_INCREMENT NOT NULL,
    type_name VARCHAR(20)        NOT NULL,
    PRIMARY KEY (type_id)
);

CREATE TABLE IF NOT EXISTS bird.files_has_types
(
    file_id INT NOT NULL,
    type_id INT NOT NULL,
    PRIMARY KEY (file_id, type_id),
    FOREIGN KEY (file_id) REFERENCES files (file_id) ON DELETE CASCADE,
    FOREIGN KEY (type_id) REFERENCES types (type_id) ON DELETE CASCADE
);

-- Corrige a inserção de e-mails válidos
INSERT INTO bird.valid_emails (valid_email_email)
VALUES ('teste01@gmail.com');

DELIMITER //

-- Procedure corrigida para verificar e inserir usuário
CREATE PROCEDURE insert_user(
    IN p_username VARCHAR(50),
    IN p_user_email VARCHAR(50),
    IN p_user_password VARCHAR(255),
    IN p_user_level INT
)
BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*)
    INTO v_count
    FROM bird.valid_emails
    WHERE valid_email_email = p_user_email;

    IF v_count = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'E-mail não é válido';
    ELSE
        INSERT INTO bird.users (username, user_email, user_password, user_level)
        VALUES (p_username, p_user_email, p_user_password, p_user_level);
    END IF;
END;
//

DELIMITER //

-- Trigger para verificar e deletar tópicos ligados a apenas uma disciplina
CREATE TRIGGER before_delete_disciplina
    BEFORE DELETE
    ON bird.disciplines
    FOR EACH ROW
BEGIN
    DECLARE topic_id INT;
    DECLARE done INT DEFAULT 0;

    DECLARE topic_cursor CURSOR FOR
        SELECT topic_id
        FROM bird.disciplines_has_topics
        WHERE discipline_id = OLD.discipline_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN topic_cursor;

    read_loop:
    LOOP
        FETCH topic_cursor INTO topic_id;
        IF done THEN
            LEAVE read_loop;
        END IF;

        IF (SELECT COUNT(*) FROM bird.disciplines_has_topics WHERE topic_id = topic_id) = 1 THEN
            DELETE FROM bird.topics WHERE topic_id = topic_id;
        END IF;
    END LOOP;

    CLOSE topic_cursor;
END;
//

-- Chamada de teste para a procedure
CALL insert_user('Teste', 'teste@gmail.com', 'senha123', 1);

-- Inserção de disciplinas e tópicos
INSERT INTO bird.disciplines (discipline_name)
VALUES ('Física');
INSERT INTO bird.topics (topic_name)
VALUES ('Logaritmo');
INSERT INTO bird.disciplines_has_topics (discipline_id, topic_id)
VALUES (3, 2);

-- Correção no SELECT final
SELECT d.discipline_id,
       d.discipline_name,
       t.topic_id,
       t.topic_name
FROM bird.disciplines d
         INNER JOIN
     bird.disciplines_has_topics dht ON d.discipline_id = dht.discipline_id
         INNER JOIN
     bird.topics t ON dht.topic_id = t.topic_id;

-- Excluir disciplina
DELETE
FROM bird.disciplines
WHERE discipline_id = 2;

-- Exibir disciplinas e tópicos restantes
SELECT *
FROM bird.disciplines;
SELECT *
FROM bird.topics;
