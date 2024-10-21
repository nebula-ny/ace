CREATE DATABASE ACE;

USE ACE;

CREATE TABLE users (
    nim VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
);
INSERT INTO `users`(`nim`, `password`) VALUES 
('230209500002', 'PTIKAHebat'),
('230209500003', 'PTIKAHebat'),
('230209500004', 'PTIKAHebat'),
('230209500005', 'PTIKAHebat'),
('230209500006', 'PTIKAHebat'),
('230209500007', 'PTIKAHebat'),
('230209500008', 'PTIKAHebat'),
('230209500009', 'PTIKAHebat'),
('230209500010', 'PTIKAHebat'),
('230209500011', 'PTIKAHebat'),
('230209500013', 'PTIKAHebat'),
('230209500014', 'PTIKAHebat'),
('230209500015', 'PTIKAHebat'),
('230209500016', 'PTIKAHebat'),
('230209500017', 'PTIKAHebat'),
('230209500018', 'PTIKAHebat'),
('230209500019', 'PTIKAHebat'),
('230209500020', 'PTIKAHebat'),
('230209500021', 'PTIKAHebat'),
('230209500022', 'PTIKAHebat'),
('230209500023', 'PTIKAHebat'),
('230209500024', 'PTIKAHebat'),
('230209500025', 'PTIKAHebat'),
('230209500026', 'PTIKAHebat'),
('230209500027', 'PTIKAHebat'),
('230209500028', 'PTIKAHebat'),
('230209500029', 'PTIKAHebat'),
('230209500030', 'PTIKAHebat'),
('230209500031', 'PTIKAHebat'),
('230209500032', 'PTIKAHebat'),
('230209500033', 'PTIKAHebat'),
('230209500034', 'PTIKAHebat'),
('230209500035', 'PTIKAHebat'),
('230209500036', 'PTIKAHebat'),
('230209500037', 'PTIKAHebat'),
('230209500038', 'PTIKAHebat'),
('230209552024', 'PTIKAHebat'),
('230209500042', 'PTIKAHebat'),
('230209552004', 'PTIKAHebat'),
('230209552006', 'PTIKAHebat');

CREATE TABLE candidates (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL
);

INSERT INTO candidates (id, name, photo) 
VALUES 
    (1, 'Muhammad Faiz', 'faiz.jpg'),
    (2, 'Muhammad Arjuna', 'juna.jpg'),
    (3, 'Muhammad Afif', 'afif.jpg'),
    (4, 'Insyiraah Putri', 'inci.jpg'),
    (5, 'Nurul Adha', 'adha.jpg'),
    (6, 'Indriyani Absa', 'indry.jpg');

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT NOT NULL,
    nim VARCHAR(255) NOT NULL,  -- Menambahkan kolom nim
    category ENUM('most_famous', 'most_active', 'most_friendly') NOT NULL,
    total_votes INT DEFAULT 0,
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)
);