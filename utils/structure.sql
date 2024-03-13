CREATE DATABASE portfolio;
USE portfolio;

CREATE TABLE person (
    id INT PRIMARY KEY AUTO_INCREMENT,

    fullname    VARCHAR(255),

    username    VARCHAR(24) NULL,
    email       VARCHAR(255),
    password    VARCHAR(30),

    about       TEXT,

    birthday DATE,
    picture  BLOB
);

CREATE TABLE about (
    id INT PRIMARY KEY AUTO_INCREMENT,

    title    VARCHAR(50),
    subtitle VARCHAR(120) NULL,
    content  TEXT,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);

CREATE TABLE contact (
    id INT PRIMARY KEY AUTO_INCREMENT,

    titulo  VARCHAR(30),
    content VARCHAR(30),
    link    VARCHAR(90) NULL,
    copy    VARCHAR(90) NULL,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);

CREATE TABLE resume (
    id INT PRIMARY KEY AUTO_INCREMENT,

    titulo VARCHAR(50),
    file   BLOB,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);

CREATE TABLE project (
    id INT PRIMARY KEY AUTO_INCREMENT,

    title       VARCHAR(50),
    description TEXT,
    git         VARCHAR(50), -- LINK
    preview     VARCHAR(50), -- LINK
    languages   JSON,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);

CREATE TABLE formation (
    id INT PRIMARY KEY AUTO_INCREMENT,

    institute VARCHAR(50),
    course    VARCHAR(90),

    start DATE,
    end   DATE,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);

CREATE TABLE skill (
    id INT PRIMARY KEY AUTO_INCREMENT,

    title  VARCHAR(30),
    degree INT,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);

CREATE TABLE experience (
    id INT PRIMARY KEY AUTO_INCREMENT,

    company     VARCHAR(50),
    role        VARCHAR(30),
    description TEXT,

    start DATE,
    end   DATE,

    id_person INT NOT NULL,
    FOREIGN KEY (id_person) REFERENCES person(id)
);