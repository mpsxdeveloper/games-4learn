CREATE DATABASE games;
USE games;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    useremail VARCHAR(40) NOT NULL,
    userpassword VARCHAR(60) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(username),
    UNIQUE(useremail)
);

CREATE TABLE cargos (
    id INT NOT NULL AUTO_INCREMENT,
    descricao VARCHAR(50) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(descricao)
);

CREATE TABLE assuntos (
    id INT NOT NULL AUTO_INCREMENT,
    materia VARCHAR(50) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(materia)
);

CREATE TABLE provas (
    id INT NOT NULL AUTO_INCREMENT,
    descricao VARCHAR(50) NOT NULL,
    ano VARCHAR(4) NOT NULL,
    cargo_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (cargo_id) REFERENCES cargos(id)
);

CREATE TABLE questoes (
    id INT NOT NULL AUTO_INCREMENT,
    pergunta VARCHAR(250) NOT NULL,
    resposta1 VARCHAR(100) NOT NULL,
    resposta2 VARCHAR(100) NOT NULL,
    resposta3 VARCHAR(100) NOT NULL,
    resposta4 VARCHAR(100) NOT NULL,
    resposta5 VARCHAR(100) NOT NULL,
    gabarito ENUM('A', 'B', 'C', 'D', 'E') NOT NULL,
    prova_id INT NOT NULL,
    assunto_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (prova_id) REFERENCES provas(id) ON DELETE CASCADE,
    FOREIGN KEY (assunto_id) REFERENCES assuntos(id) ON DELETE CASCADE
);

CREATE TABLE conquistas (
    id INT NOT NULL AUTO_INCREMENT,
    tipo ENUM('BRONZE', 'PRATA', 'OURO') NOT NULL DEFAULT 'BRONZE',
    data_conquista TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    prova_id INT NOT NULL,
    usuario_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (prova_id) REFERENCES provas(id),
    FOREIGN KEY (usuario_id) REFERENCES users(id)
);