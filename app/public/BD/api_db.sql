CREATE DATABASE api_db;

USE api_db;

CREATE TABLE aeronaves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(255) NOT NULL,
    fabricante VARCHAR(255) NOT NULL,
    ano_fabricacao YEAR NOT NULL,
    matricula VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE ordens_servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao TEXT NOT NULL,
    status VARCHAR(50) NOT NULL,
    data_criacao DATE,
    aeronave_id INT,
    FOREIGN KEY (aeronave_id) REFERENCES aeronaves(id) ON DELETE CASCADE
);