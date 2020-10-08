CREATE TABLE todo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  completed tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;