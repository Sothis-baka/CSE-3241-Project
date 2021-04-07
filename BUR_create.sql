
Create table if not exists PATIENT
    (Fname      VARCHAR(15)         NOT NULL,
     Lname      VARCHAR(15)         NOT NULL,
     Age        INT                 NOT NULL,
     Ssn        CHAR(9)             NOT NULL,
     Date       DATE                NOT NULL,
     Phone      VARCHAR(10)         NOT NULL,
     Priority   ENUM('1','2','3')   NOT NULL,
     Status     ENUM('waitlist','scheduled','done') DEFAULT 'waitlist',
     PRIMARY KEY (Ssn)
    );

Create table if not exists BATCH
    (Id             INT             NOT NULL,
     Manufacturer   VARCHAR(15)     NOT NULL,
     Expiredate     DATE            NOT NULL,
     PRIMARY KEY (Id)
    );

Create table if not exists DOSE
    (Tno    INT     NOT NULL,
     Status ENUM('used', 'scheduled', 'unused', 'expired')     DEFAULT 'unused',
     Bid    INT     NOT NULL,
     PRIMARY KEY (Tno),
     FOREIGN KEY (Bid) REFERENCES BATCH (Id) ON DELETE CASCADE
    );

Create table if not exists APPOINTMENT
    (Id     INT     NOT NULL,
     Pssn   CHAR(9) NOT NULL,
     Date   DATE    NOT NULL,
     Dtno   INT     NOT NULL,
     PRIMARY KEY (Id),
     FOREIGN KEY (Dtno) REFERENCES DOSE (Tno) ON DELETE CASCADE,
     FOREIGN KEY (Pssn) REFERENCES PATIENT (Ssn) ON DELETE CASCADE
    );


