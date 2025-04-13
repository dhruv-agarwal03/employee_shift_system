CREATE TABLE weeks (
    week_id INT AUTO_INCREMENT PRIMARY KEY,
    start_date DATE NOT NULL UNIQUE,
    end_date DATE NOT NULL
);
CREATE TABLE employees(
	id int AUTO_INCREMENT PRIMARY KEY,
    full_name varchar(30) ,
    email varchar(200) UNIQUE,
    mobile varchar(15),
    city varchar(20),
    password varchar(200),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE schedule(
	scheduleId INT AUTO_INCREMENT PRIMARY KEY,
    weekID int,
    employeeId int NOT NULL,
    day int NOT NULL,
    shift char(1),
    holiday BOOLEAN DEFAULT 0,
    FOREIGN KEY (employeeId) REFERENCES	employees (id)
);

CREATE TABLE shiftRequest (
	shiftChangeId int AUTO_INCREMENT PRIMARY KEY,
    from_emp int ,
    to_emp int,
    week_id int,
    day int,
    shift char(1) ,
    status char(1) DEFAULT 'p',                    -- p: pending a:approved r:rejected
    create_date TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    response_date TIMESTAMP NULL,
    FOREIGN KEY (from_emp) REFERENCES employees (id),
    FOREIGN KEY (to_emp) REFERENCES employees (id),
    FOREIGN KEY (week_id) REFERENCES weeks(week_id)
);

CREATE TABLE holidayRequest (
	holidayChangeId int AUTO_INCREMENT PRIMARY KEY,
    from_emp int ,
    to_emp int,
    from_emp_shift varchar(1) ,
    to_emp_shift varchar(1),
    week_id int,
    day int, 	
    status char(1) DEFAULT 'p',                    -- p: pending a:approved r:rejected
    create_date TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    response_date TIMESTAMP NULL,
    FOREIGN KEY (from_emp) REFERENCES employees (id),
    FOREIGN KEY (to_emp) REFERENCES employees (id),
    FOREIGN KEY (week_id) REFERENCES weeks(week_id)
);