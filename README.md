# BIRD (Base Institucional de Recursos Acadêmicos)

## Descrição do projeto:

Projeto que servirá como Trabalho de Conclusão de Curso (TCC), com o intuito de criar um repositório de materiais acadêmicos para os professores do IFSP Campus Capivari. Nele a ideia é que os docentes criem disciplinas e anexem temas a elas. Cada tema (ou tópico) terá arquivos vinculados a ela, que estarão disponíveis para download.

A ideia é que somente professores do campus tenham acesso a estes materiais, então será feita uma `whitelist` com a tabela `valid_emails` do banco de dados, para que somente e-mail dos docentes do campus sejam aceitos ao criar uma conta. Futuramente, a ideia será utilizar verificação de e-mail com o PHP Mailer

## Tecnologias utilizadas:

- HTML5
    - Semântico
- CSS3
    - Flex box
    - Grid Layout
    - Position
    - Responsividade
- Javascript
    - Animações
    - Fetch API
- PHP
    - Programação Orientada a Objetos
    - PSRs: 04, 07, 11, 12, 15 e 17
    - PDO (PHP Data Objects)
    - Criação de rotas
    - Exportação dos dados em arquivo JSON
    - Composer
- MySQL
    - DDL (*Data Definition Language*)
    - Relacionamento entre tabelas
    - Procedures
    - Triggers

## Pré-requisitos:

- Ter o `PHP 8.3` ou superior instalado na máquina, com a palavra “php” disponível nas variáveis de ambiente do sistema
    - Instalar o `Composer` e no arquivo `php.ini` , tirar os comentários das bibliotecas nativas: `pdo` , `fileinfo` e `mbstring`
- Ter o `MySQL Workbench` ou algum banco de dados SQL equivalente disponível no dispositivo

## Instalando as dependências:

- Após baixar o arquivo zipado ou fazer o `git-clone` , abra sua `IDE` de preferência ou navegue até a pasta do projeto via terminal
- Execute os comandos abaixo no terminal:

    ```
    composer install 
    
    composer update
    
    composer dump-autoload
    ```


## Criando o banco de dados:

Abra o servidor de banco de dados (`MySQL Workbench`, por exemplo) e no campo query, execute o código abaixo:

```sql
CREATE DATABASE bird;

USE bird;

CREATE TABLE IF NOT EXISTS bird.users (
    user_id INT AUTO_INCREMENT NOT NULL,
    username VARCHAR(50) NOT NULL, 
    user_email VARCHAR(50) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_level INT NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE (user_email)
);

CREATE TABLE IF NOT EXISTS bird.valid_emails (
    valid_email_id INT NOT NULL AUTO_INCREMENT,
    valid_email_email VARCHAR(50) NOT NULL,
    PRIMARY KEY (valid_email_id),
    UNIQUE (valid_email_email)
);

CREATE TABLE IF NOT EXISTS bird.disciplines (
    discipline_id INT AUTO_INCREMENT NOT NULL,
    discipline_name VARCHAR(80) NOT NULL,
    banner_image VARCHAR (80) NOT NULL,
    PRIMARY KEY (discipline_id),
    UNIQUE (discipline_name)
);

CREATE TABLE IF NOT EXISTS bird.topics (
    topic_id INT AUTO_INCREMENT NOT NULL,
    topic_name VARCHAR(80) NOT NULL,
    PRIMARY KEY (topic_id),
    UNIQUE (topic_name)
);

CREATE TABLE IF NOT EXISTS bird.disciplines_has_topics (
    discipline_id INT NOT NULL,
    topic_id INT NOT NULL,
    PRIMARY KEY (discipline_id, topic_id),
    FOREIGN KEY (discipline_id) REFERENCES disciplines (discipline_id) ON DELETE CASCADE,
    FOREIGN KEY (topic_id) REFERENCES topics (topic_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bird.files (
    file_id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(80),
    file_name VARCHAR(80) NOT NULL,
    topic_id INT NOT NULL,
    PRIMARY KEY (file_id),
    FOREIGN KEY (topic_id) REFERENCES topics (topic_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bird.types (
    type_id INT AUTO_INCREMENT NOT NULL,
    type_name VARCHAR(20) NOT NULL,
    PRIMARY KEY (type_id)
);

CREATE TABLE IF NOT EXISTS bird.files_has_types (
    file_id INT NOT NULL,
    type_id INT NOT NULL,
    PRIMARY KEY (file_id, type_id),
    FOREIGN KEY (file_id) REFERENCES files (file_id) ON DELETE CASCADE,
    FOREIGN KEY (type_id) REFERENCES types (type_id) ON DELETE CASCADE
);

INSERT INTO bird.valid_emails (valid_email_email) VALUES ('teste01@gmail.com');

DELIMITER //

CREATE PROCEDURE insert_user(
    IN p_username VARCHAR(50),
    IN p_user_email VARCHAR(50),
    IN p_user_password VARCHAR(255),
    IN p_user_level INT
)
BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*) INTO v_count
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

CREATE TRIGGER before_delete_disciplina
BEFORE DELETE ON bird.disciplines
FOR EACH ROW
BEGIN
    DELETE FROM bird.topics 
    WHERE topic_id IN (
        SELECT topic_id 
        FROM bird.disciplines_has_topics 
        WHERE discipline_id = OLD.discipline_id
        AND (SELECT COUNT(*) FROM bird.disciplines_has_topics WHERE topic_id = topics.topic_id) = 1
    );
END;
//

DELIMITER ;
```

## Alterando o usuário do banco de dados:

- No arquivo `ConnectionFactory.php`, dentro da pasta: `src` > `Model` , altere o usuário e a senha do seu banco de dados (por padrão é o `root`)

```php
<?php
namespace Cleitoncunha\Bird\Model;

use PDO;

class ConnectionFactory
{
    public static function getConnection(): PDO
    {
        $pdo = new PDO('mysql:host=localhost;dbname=bird', 'SEU USUÁRIO', 'SUA SENHA');

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
```

## Rodando o projeto:

- Para rodar o projeto, usaremos o servidor local nativo do PHP
- Para isso, no terminal cole o comando abaixo:

```
php -S localhost:8080 -t .\public\
```

- O projeto será carregado no link: http://localhost:8080/

## Observações:

- Só é possível criar contas com e-mails cadastrados na tabela do banco de dados `valid_emails`
- Por padrão, o e-mail [teste01@gmail.com](mailto:teste01@gmail.com) está disponível
- Caso queria adicionar outro e-mail, na query do seu banco de dados execute o comando abaixo:

```sql
INSERT INTO bird.valid_emails (valid_email_email) VALUES ('SEU E-MAIL');
```