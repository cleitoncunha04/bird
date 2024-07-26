DROP DATABASE IF EXISTS bird;
CREATE DATABASE IF NOT EXISTS bird;
USE bird;

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT AUTO_INCREMENT NOT NULL,
    nome_usuario VARCHAR(50) NOT NULL, 
    email_usuario VARCHAR(50) NOT NULL,
    senha_usuario VARCHAR(255) NOT NULL,
    nivel_usuario INT NOT NULL,
    PRIMARY KEY (id_usuario),
    UNIQUE (email_usuario)
);

CREATE TABLE IF NOT EXISTS email_valido (
    id_email_valido INT NOT NULL AUTO_INCREMENT,
    email_email_valido VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_email_valido),
    UNIQUE (email_email_valido)
);

CREATE TABLE IF NOT EXISTS disciplina (
    id_disciplina INT AUTO_INCREMENT NOT NULL,
    nome_disciplina VARCHAR(25) NOT NULL,
    PRIMARY KEY (id_disciplina)
);

CREATE TABLE IF NOT EXISTS tema (
    id_tema INT AUTO_INCREMENT NOT NULL,
    nome_tema VARCHAR(25) NOT NULL,
    PRIMARY KEY (id_tema)
);

CREATE TABLE IF NOT EXISTS disciplina_has_tema (
    disciplina_id_disciplina INT NOT NULL,
    tema_id_tema INT NOT NULL,
    PRIMARY KEY (disciplina_id_disciplina, tema_id_tema),
    FOREIGN KEY (disciplina_id_disciplina) REFERENCES disciplina (id_disciplina) ON DELETE CASCADE,
    FOREIGN KEY (tema_id_tema) REFERENCES tema (id_tema) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS arquivo (
    id_arquivo INT AUTO_INCREMENT NOT NULL,
    nome_arquivo VARCHAR(25) NOT NULL,
    tema_id_tema INT NOT NULL,
    PRIMARY KEY (id_arquivo),
    FOREIGN KEY (tema_id_tema) REFERENCES tema (id_tema) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tipo (
    id_tipo INT NOT NULL,
    nome_tipo VARCHAR(20),
    PRIMARY KEY (id_tipo)
);

CREATE TABLE IF NOT EXISTS arquivo_has_tipo (
    arquivo_id_arquivo INT NOT NULL,
    tipo_id_tipo INT NOT NULL,
    PRIMARY KEY (arquivo_id_arquivo, tipo_id_tipo),
    FOREIGN KEY (arquivo_id_arquivo) REFERENCES arquivo (id_arquivo),
    FOREIGN KEY (tipo_id_tipo) REFERENCES tipo (id_tipo)
);

INSERT INTO email_valido (email_email_valido) VALUES ('teste01@gmail.com');

DELIMITER //

-- procedure para permitir a insercao de um usuario se o email informado ja estiver cadastrado na tabela email_valido
CREATE PROCEDURE insert_usuario(
    IN p_nome_usuario VARCHAR(50),
    IN p_email_usuario VARCHAR(50),
    IN p_senha_usuario VARCHAR(255),
    IN p_nivel_usuario INT
)
BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*) INTO v_count
    FROM email_valido
    WHERE email_email_valido = p_email_usuario;

    IF v_count = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'E-mail não é válido';
    ELSE
        INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, nivel_usuario)
        VALUES (p_nome_usuario, p_email_usuario, p_senha_usuario, p_nivel_usuario);
    END IF;
END;
//

DELIMITER //


-- trigger para ver se há somente 1 id_disciplina ligado ao tema, caso haja, ambos são excluídos
CREATE TRIGGER before_delete_disciplina
BEFORE DELETE ON disciplina
FOR EACH ROW
BEGIN
    DECLARE tema_id INT;
    DECLARE done INT DEFAULT 0;

    DECLARE tema_cursor CURSOR FOR 
    SELECT tema_id_tema 
    FROM disciplina_has_tema 
    WHERE disciplina_id_disciplina = OLD.id_disciplina;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN tema_cursor;

    read_loop: LOOP
        FETCH tema_cursor INTO tema_id;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        IF (SELECT COUNT(*) FROM disciplina_has_tema WHERE tema_id_tema = tema_id) = 1 THEN
            DELETE FROM tema WHERE id_tema = tema_id;
        END IF;
    END LOOP;
    
    CLOSE tema_cursor;
END;
//

CALL insert_usuario('Teste', 'teste01@gmail.com', 'senha123', 1);
-- CALL insert_usuario('Carlitos Teves', 'teste02@gmail.com', 'senha123', 1);

SELECT * FROM usuario;

insert into disciplina(nome_disciplina) values ("Física");
insert into tema(nome_tema) values ("Logaritmo");
insert into disciplina_has_tema(disciplina_id_disciplina, tema_id_tema) values (3, 2);

SELECT 
    d.id_disciplina, 
    d.nome_disciplina, 
    t.id_tema, 
    t.nome_tema
FROM 
    disciplina d
INNER JOIN 
    disciplina_has_tema dht ON d.id_disciplina = dht.disciplina_id_disciplina
INNER JOIN 
    tema t ON dht.tema_id_tema = t.id_tema;
    
delete from disciplina where id_disciplina=2;
select * from disciplina;
select * from tema;
