CREATE DATABASE BUR;

USE BUR;

CREATE TABLE PATIENT
    (Id         INT                 NOT NULL    AUTO_INCREMENT,
     Fname      VARCHAR(15)         NOT NULL,
     Lname      VARCHAR(15)         NOT NULL,
     Age        INT                 NOT NULL,
     Date       DATE                NOT NULL,
     Phone      VARCHAR(10)         NOT NULL,
     Priority   INT                 NOT NULL,
     PRIMARY KEY (Id)
    );

CREATE TABLE BATCH
    (Id             INT             NOT NULL    AUTO_INCREMENT,
     Manufacturer   VARCHAR(15)     NOT NULL,
     Expiredate     DATE            NOT NULL,
     PRIMARY KEY (Id)
    );

CREATE TABLE DOSE
    (Tno    INT     NOT NULL    AUTO_INCREMENT,
     Bid    INT     NOT NULL,
     PRIMARY KEY (Tno),
     FOREIGN KEY (Bid) REFERENCES BATCH (Id) ON DELETE CASCADE
    );

CREATE TABLE APPOINTMENT
    (Id     INT     NOT NULL    AUTO_INCREMENT,
     Pid    INT     NOT NULL,
     Date   DATE    NOT NULL,
     Tno   INT     NOT NULL,
     PRIMARY KEY (Id),
     FOREIGN KEY (Tno) REFERENCES DOSE (Tno) ON DELETE CASCADE,
     FOREIGN KEY (Pid) REFERENCES PATIENT (Id) ON DELETE CASCADE
    );