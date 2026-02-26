Note For Database  



###### Sql Command For creating database



Create database databasename;



###### Sql Command For creating table



CREATE TABLE Feedback (

&nbsp;   Feedback\_ID INT(5) AUTO\_INCREMENT PRIMARY KEY,

&nbsp;   Feedback\_date DATE,

&nbsp;   Name VARCHAR(25),

&nbsp;   Emailid VARCHAR(25),

&nbsp;   Phone VARCHAR(13),

&nbsp;   Feedback VARCHAR(100),

&nbsp;   Promotion VARCHAR(1),

&nbsp;   Channel\_S VARCHAR(1),

&nbsp;   Channel\_W VARCHAR(1),

&nbsp;   Channel\_M VARCHAR(1)

);



###### Database Configuration 



Edit feedback.php and report.php if needed:

Host: localhost

User: root

Password: Your Database Password

Database: Your Database Name

###### Accessing Admin Login

Password: 'admin123'

