-- tạo database

CREATE DATABASE IF NOT EXISTS `MD18102`;

-- sử dụng database

USE `MD18102`;

-- tạo bảng USERS(ID, EMAIL, PASSWORD, NAME, ROLE, AVATAR)

CREATE TABLE
    IF NOT EXISTS `USERS` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) UNIQUE NOT NULL,
        `password` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        `role` varchar(255),
        `avatar` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    );

-- tạo bảng TOPICS(ID, NAME, DESCRIPTION)

CREATE TABLE
    IF NOT EXISTS `TOPICS` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `NAME` varchar(255) NOT NULL,
        `DESCRIPTION` varchar(255) NOT NULL,
        PRIMARY KEY (`ID`)
    );

-- tạo bảng NEWS(ID, TITLE, CONTENT, CREATED_AT, USER_ID, TOPIC_ID)

CREATE TABLE
    IF NOT EXISTS `NEWS` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `TITLE` varchar(255) NOT NULL,
        `CONTENT` varchar(255) NOT NULL,
        `IMAGE` varchar(255) NOT NULL,
        `CREATED_AT` datetime DEFAULT NOW() NOT NULL,
        `CREACTED_BY` int(11) NOT NULL,
        `UPDATED_AT` datetime DEFAULT NOW() NOT NULL ON UPDATE,
        `UPDATED_BY` int(11) NOT NULL,
        `USER_ID` int(11) NOT NULL,
        `TOPIC_ID` int(11) NOT NULL,
        PRIMARY KEY (`ID`),
        FOREIGN KEY (`USER_ID`) REFERENCES `USERS`(`ID`),
        FOREIGN KEY (`TOPIC_ID`) REFERENCES `TOPICS`(`ID`)
    );

-- tạo bảng forgot_password(ID, EMAIL, TOKEN, CREATED_AT, AVAILABLE)

CREATE TABLE
    IF NOT EXISTS `FORGOT_PASSWORD` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `EMAIL` varchar(255) NOT NULL,
        `TOKEN` varchar(255) NOT NULL,
        `CREATED_AT` datetime DEFAULT NOW() NOT NULL DEFAULT CURRENT_TIMESTAMP(),
        `AVAILABLE` tinyint(1) NOT NULL DEFAULT 1,
        PRIMARY KEY (`ID`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- tạo bảng fees(ID, STUDENT_ID, TUITION_FEE, MISC_FEE, CREATED_AT)

CREATE TABLE
    IF NOT EXISTS `FEES` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `STUDENT_ID` int(11) NOT NULL,
        `TUITION_FEE` decimal(10, 2) NOT NULL,
        `MISC_FEE` decimal(10, 2) NOT NULL,
        `CREATED_AT` datetime DEFAULT NOW() NOT NULL,
        `USER_ID` int(11) NOT NULL,
        PRIMARY KEY (`ID`),
        FOREIGN KEY (`STUDENT_ID`) REFERENCES `STUDENTS`(`ID`),
        FOREIGN KEY (`USER_ID`) REFERENCES `USERS`(`ID`)
    );

-- tạo bảng STUDENTS(ID, NAME, AGE, SBD, AVATAR)

CREATE TABLE
    IF NOT EXISTS `STUDENTS` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `NAME` varchar(255) NOT NULL,
        `AGE` int(11) NOT NULL,
        `SBD` varchar(255) NOT NULL,
        `AVATAR` varchar(255) NOT NULL,
        `FEES_ID` int(11) NOT NULL,
        `USER_ID` int(11) NOT NULL,
        PRIMARY KEY (`ID`),
        FOREIGN KEY (`FEES_ID`) REFERENCES `FEES`(`ID`),
        FOREIGN KEY (`USER_ID`) REFERENCES `USERS`(`ID`)
    );

-- tạo bảng STRASCRIPTS(ID, NAME, POINT, DESCRIPTION, CREATED_AT, USER_ID)

CREATE TABLE
    IF NOT EXISTS `STRASCRIPTS` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `NAME` varchar(255) NOT NULL,
        `POINT` int(11) NOT NULL,
        `DESCRIPTION` varchar(255) NOT NULL,
        `CREATED_AT` datetime DEFAULT NOW() NOT NULL,
        `USER_ID` int(11) NOT NULL,
        PRIMARY KEY (`ID`),
        FOREIGN KEY (`USER_ID`) REFERENCES `USERS`(`ID`)
    );

-- thêm dữ liệu vào bảng STRASCRIPTS

INSERT INTO
    `STRASCRIPTS` (
        `ID`,
        `NAME`,
        `POINT`,
        `DESCRIPTION`,
        `CREATED_AT`,
        `USER_ID`
    )
VALUES (
        1,
        'PHP',
        10,
        'PHP is a server scripting language',
        '2019-11-11 00:00:00',
        1
    ), (
        2,
        'JAVA',
        10,
        'Java is a high-level programming language ',
        '2019-11-11 00:00:00',
        2
    ), (
        3,
        'PYTHON',
        10,
        'Python is a programming language',
        '2019-11-11 00:00:00',
        3
    );

-- thêm dữ liệu vào bảng USERS

INSERT INTO
    `USERS` (
        `ID`,
        `EMAIL`,
        `PASSWORD`,
        `NAME`,
        `ROLE`,
        `AVATAR`
    )
VALUES (
        1,
        'admin@gmail.com',
        '123',
        'Nguyen van a',
        'admin',
        'https://www.w3schools.com/howto/img_avatar.png'
    ), (
        2,
        'binh@gmail.com',
        '123',
        'Nguyen van b',
        'user',
        'https://www.w3schools.com/howto/img_avatar.png'
    ), (
        3,
        'khang@gmail.com',
        '123',
        'Nguyen van c',
        'user',
        'https://www.w3schools.com/howto/img_avatar.png'
    );

-- thêm dữ liệu vào bảng TOPICS

INSERT INTO
    `TOPICS` (`ID`, `NAME`, `DESCRIPTION`)
VALUES (
        1,
        'PHP',
        'PHP is a server scripting language'
    ), (
        2,
        'JAVA',
        'Java is a high-level programming language '
    ), (
        3,
        'PYTHON',
        'Python is a programming language'
    );

-- thêm dữ liệu vào bảng NEWS

INSERT INTO
    `NEWS` (
        `ID`,
        `TITLE`,
        `CONTENT`,
        `IMAGE`,
        `CREATED_AT`,
        `CREACTED_BY`,
        `UPDATED_AT`,
        `UPDATED_BY`,
        `USER_ID`,
        `TOPIC_ID`
    )
VALUES (
        1,
        'PHP',
        'PHP is a server scripting language',
        'https://www.w3schools.com/howto/img_avatar.png',
        '2019-11-11 00:00:00',
        1,
        '2019-11-11 00:00:00',
        1,
        1,
        1
    ), (
        2,
        'JAVA',
        'Java is a high-level programming language ',
        'https://www.w3schools.com/howto/img_avatar.png',
        '2019-11-11 00:00:00',
        2,
        '2019-11-11 00:00:00',
        2,
        2,
        2
    ), (
        3,
        'PYTHON',
        'Python is a programming language',
        'https://www.w3schools.com/howto/img_avatar.png',
        '2019-11-11 00:00:00',
        3,
        '2019-11-11 00:00:00',
        3,
        3,
        3
    );

-- thêm dữ liệu vào bảng FEES

INSERT INTO
    `FEES` (
        `ID`,
        `STUDENT_ID`,
        `TUITION_FEE`,
        `MISC_FEE`,
        `CREATED_AT`,
        `USER_ID`
    )
VALUES (
        1,
        1,
        1000000,
        100000,
        '2019-11-11 00:00:00',
        1
    ), (
        2,
        2,
        1000000,
        100000,
        '2019-11-11 00:00:00',
        2
    ), (
        3,
        3,
        1000000,
        100000,
        '2019-11-11 00:00:00',
        3
    );

-- thêm dữ liệu vào bảng STUDENTS

INSERT INTO
    `STUDENTS` (
        `ID`,
        `NAME`,
        `AGE`,
        `SBD`,
        `AVATAR`,
        `FEES_ID`,
        `USER_ID`
    )
VALUES (
        1,
        'Nguyen van a',
        20,
        '123',
        'https://www.w3schools.com/howto/img_avatar.png',
        1,
        1
    ), (
        2,
        'Nguyen van b',
        20,
        '123',
        'https://www.w3schools.com/howto/img_avatar.png',
        2,
        2
    ), (
        3,
        'Nguyen van c',
        20,
        '123',
        'https://www.w3schools.com/howto/img_avatar.png',
        3,
        3
    );