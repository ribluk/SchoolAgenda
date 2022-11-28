SET
    FOREIGN_KEY_CHECKS = 0;

DROP DATABASE IF EXISTS SchoolAgenda;

CREATE DATABASE IF NOT EXISTS SchoolAgenda;

USE SchoolAgenda;

SET
    FOREIGN_KEY_CHECKS = 1;

CREATE TABLE User(
    email VARCHAR(20),
    password CHAR(40) NOT NULL,
    name VARCHAR(20) NOT NULL,
    surname VARCHAR(20) NOT NULL,
    address VARCHAR(30) NOT NULL,
    dateob DATE NOT NULL,
    type ENUM ('alumn', 'teacher', 'admin') NOT NULL,
    PRIMARY KEY (email)
);

CREATE TABLE Class(
    id VARCHAR(4),
    classroom INT NOT NULL,
    capacity INT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (classroom)
);

CREATE TABLE Teacher_Class(
    teacher VARCHAR(20),
    class VARCHAR(5),
    subject VARCHAR(20),
    PRIMARY KEY (teacher, class, subject),
    FOREIGN KEY (teacher) REFERENCES User(email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (class) REFERENCES Class(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Alumn_Class(
    alumn VARCHAR(20),
    class VARCHAR(5),
    PRIMARY KEY (alumn, class),
    FOREIGN KEY (alumn) REFERENCES User(email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (class) REFERENCES Class(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE (alumn)
);

CREATE TABLE Assignment(
    id INT NOT NULL AUTO_INCREMENT,
    teacher VARCHAR(20),
    subject VARCHAR(20) NOT NULL,
    description VARCHAR(40) NOT NULL,
    deadline DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (teacher) REFERENCES User(email) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Alumn_Assignment(
    alumn VARCHAR(20),
    assignment INT,
    PRIMARY KEY (alumn, assignment),
    FOREIGN KEY (alumn) REFERENCES User(email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (assignment) REFERENCES Assignment(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------------------------------------------------------------------------------------
-- DATA
USE schoolagenda;

INSERT INTO
    user
VALUES
    (
        'admin@mail.com',
        'd033e22ae348aeb5660fc2140aec35850c4da997',
        'admin',
        ' ',
        ' ',
        ' ',
        'admin'
    ),
    (
        'alumn1@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'alumn',
        '1',
        '1, alumn st.',
        '2003-11-01',
        'alumn'
    ),
    (
        'alumn2@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'alumn',
        '2',
        '1, alumn st.',
        '2003-11-02',
        'alumn'
    ),
    (
        'alumn3@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'alumn',
        '3',
        '3, alumn st.',
        '2003-11-03',
        'alumn'
    ),
    (
        'alumn4@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'alumn',
        '4',
        '4, alumn st.',
        '2003-11-04',
        'alumn'
    ),
    (
        'alumn5@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'alumn',
        '5',
        '5, alumn st.',
        '2003-11-05',
        'alumn'
    ),
    (
        'teacher1@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'teacher',
        '1',
        '1, teacher st.',
        '1903-11-01',
        'teacher'
    ),
    (
        'teacher2@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'teacher',
        '2',
        '2, teacher st.',
        '1903-11-02',
        'teacher'
    ),
    (
        'teacher3@mail.com',
        '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
        'teacher',
        '3',
        '3, teacher st.',
        '1903-11-03',
        'teacher'
    );


INSERT INTO
    class
VALUES
    ('1CLS', 1, 10),
    ('2CLS', 2, 20),
    ('3CLS', 3, 30);

INSERT INTO
    teacher_class
VALUES
    ('teacher1@mail.com', '1CLS', 'Math'),
    ('teacher1@mail.com', '1CLS', 'Algebra'),
    ('teacher1@mail.com', '2CLS', 'Algebra'),
    ('teacher2@mail.com', '1CLS', 'English'),
    ('teacher2@mail.com', '2CLS', 'English'),
    ('teacher2@mail.com', '3CLS', 'English'),
    ('teacher3@mail.com', '3CLS', 'Physics'),
    ('teacher3@mail.com', '3CLS', 'Chemistry'),
    ('teacher3@mail.com', '3CLS', 'Biology');

INSERT INTO
    alumn_class
VALUES
    ('alumn1@mail.com', '1CLS'),
    ('alumn2@mail.com', '1CLS'),
    ('alumn3@mail.com', '2CLS'),
    ('alumn4@mail.com', '2CLS'),
    ('alumn5@mail.com', '3CLS');

INSERT INTO
    assignment(teacher, subject, description, deadline)
VALUES
    (
        'teacher1@mail.com',
        'Algebra',
        'algebra assignment',
        '2022-05-05 13:00:00'
    ),
    (
        'teacher1@mail.com',
        'Math',
        'math assignment',
        '2022-04-04 12:00:00'
    ),
    (
        'teacher3@mail.com',
        'Physics',
        'physics assignment',
        '2022-05-06 18:00:00'
    );

INSERT INTO
    alumn_assignment
VALUES
    ('alumn3@mail.com', 1),
    ('alumn4@mail.com', 1),
    ('alumn1@mail.com', 2),
    ('alumn2@mail.com', 2),
    ('alumn5@mail.com', 3);