create table if not exists students
(
    studentId   int         not null,
    career      int         not null,
    firstName   varchar(50) not null,
    lastName    varchar(50) not null,
    dni         varchar(20) not null,
    fileNumber  varchar(20) not null,
    gender      varchar(50) not null,
    birthDate   datetime    not null,
    phoneNumber varchar(20) not null,
    email       varchar(50) not null,
    active      boolean     not null,
    constraint pk_studentId primary key (studentId),
    constraint unq_fileNumber unique (fileNumber),
    constraint fk_career foreign key (career) references careers (careerId)
) engine = InnoDb;


DELIMITER $$
CREATE PROCEDURE Students_Add(IN studentId int, IN career int, IN firstName varchar(50), IN lastName varchar(50),
                              IN dni VARCHAR(20), IN fileNumber varchar(20), IN gender varchar(50),
                              iN birthDate datetime, IN phoneNumber varchar(20), email varchar(50), active boolean)
BEGIN
    INSERT INTO students
    (students.studentId, students.career, students.firstName, students.lastName, students.dni, students.fileNumber,
     students.gender, students.birthDate, students.phoneNumber, students.email, students.active)
    VALUES (studentId, career, firstName, lastName, dni, fileNumber, gender, birthDate, phoneNumber, email, active);
END;
DELIMITER;


create table if not exists companies
(
    companyId      int auto_increment not null,
    name           varchar(50)        not null,
    foundationDate date               not null,
    cuit           char(11)           not null,
    aboutUs        text,
    companyLink    varchar(50)        not null,
    email          varchar(50)        not null,
    logo           int                not null,
    active         boolean            not null,
    industry       int                not null,
    city           int                not null,
    country        int                not null,
    creationAdmin  int                not null,
    constraint pk_companyId primary key (companyId),
    constraint unq_cuit unique (cuit),
    constraint fk_logo foreign key (logo) references logos (id),
    constraint fk_industry foreign key (industry) references industries (id),
    constraint fk_city foreign key (city) references cities (id),
    constraint fk_country foreign key (country) references countries (id),
    constraint fk_creationAdmin foreign key (creationAdmin) references administrators (administratorId)
) engine = InnoDb;


create table if not exists careers
(
    careerId    int auto_increment not null,
    description varchar(50)        not null,
    active      boolean            not null,
    constraint pk_careerId primary key (careerId),
    constraint unq_career unique (description, active)
) engine = InnoDb;


create table if not exists cities
(
    id   int auto_increment not null,
    name varchar(50)        not null,
    constraint pk_cityId primary key (id),
    constraint unq_city unique (name)
) engine = InnoDb;

create table if not exists countries
(
    id   int auto_increment not null,
    name varchar(50)        not null,
    constraint pk_countryId primary key (id),
    constraint unq_country unique (name)
) engine = InnoDb;

create table if not exists logos
(
    id   int auto_increment not null,
    name varchar(50)        not null,
    file longblob           not null,
    constraint pk_logoId primary key (id),
    constraint unq_logo unique (name)
) engine = InnoDb;

create table if not exists industries
(
    id   int auto_increment not null,
    type varchar(50)        not null,
    constraint pk_industryId primary key (id),
    constraint unq_industry unique (type)
) engine = InnoDb;


create table if not exists administrators
(
    administratorId int auto_increment not null,
    firstName       varchar(50)        not null,
    lastName        varchar(50)        not null,
    employeeNumber  varchar(20)        not null,
    constraint pk_administratorId primary key (administratorId),
    constraint unq_employeeNumber unique (employeeNumber)
) engine = InnoDb;


DROP procedure IF EXISTS Students_Add;
DELIMITER $$
CREATE PROCEDURE Students_Add(IN studentId int, IN career int, IN firstName varchar(50), IN lastName varchar(50),
                              IN dni VARCHAR(20), IN fileNumber varchar(20), IN gender varchar(50),
                              iN birthDate datetime, IN phoneNumber varchar(20), email varchar(50), active boolean)
BEGIN
    INSERT INTO students
    (students.studentId, students.career, students.firstName, students.lastName, students.dni, students.fileNumber,
     students.gender, students.birthDate, students.phoneNumber, students.email, students.active)
    VALUES (studentId, career, firstName, lastName, dni, fileNumber, gender, birthDate, phoneNumber, email, active);
END$$
DELIMITER;

DELIMITER $$
CREATE PROCEDURE Careers_Add(IN careerId int, IN description varchar(50), IN active boolean)
BEGIN
    INSERT INTO careers
        (careers.careerId, careers.description, careers.active)
    VALUES (careerId, description, active);
END$$
