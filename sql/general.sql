CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    birthdate DATE,
    notes TEXT,
    profile_image VARCHAR(255),
    attachment VARCHAR(255)
);

CREATE TABLE interactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT,
    date DATETIME,
    type ENUM('ligação', 'reunião', 'observação'),
    description TEXT,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE
);

