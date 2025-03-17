CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    type VARCHAR(50) CHECK(type IN ('Coffee', 'Tea')) NOT NULL,
    description TEXT,
    stock INT DEFAULT 0,
    image_url VARCHAR(255)
);