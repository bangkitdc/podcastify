DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS podcasts;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
    role_id             INT             AUTO_INCREMENT      PRIMARY KEY,
    name                VARCHAR(255)    UNIQUE NOT NULL
);

INSERT INTO roles (name) VALUES
    ('admin'),
    ('user');

CREATE TABLE users (
    user_id             INT             AUTO_INCREMENT      PRIMARY KEY,
    email               VARCHAR(255)    UNIQUE NOT NULL,
    username            VARCHAR(50)     UNIQUE NOT NULL,
    password            VARCHAR(255)    NOT NULL,
    first_name          VARCHAR(255)    NOT NULL,
    last_name           VARCHAR(255)    NOT NULL,
    status              SMALLINT        NOT NULL DEFAULT 1,
    avatar_url          VARCHAR(255)    DEFAULT NULL,
    last_login          TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    role_id             INT             NOT NULL,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

CREATE TABLE categories (
    category_id         INT             AUTO_INCREMENT      PRIMARY KEY,
    name                VARCHAR(255)    UNIQUE NOT NULL
);

CREATE TABLE podcasts (
    podcast_id          INT             AUTO_INCREMENT      PRIMARY KEY,
    title               VARCHAR(255)    UNIQUE NOT NULL,
    description         VARCHAR(255)    NOT NULL,
    creator_name        VARCHAR(255)    NOT NULL,
    total_eps           INT             NOT NULL DEFAULT 0,
    image_url           VARCHAR(255),
    category_id         INT             NOT NULL,
    liked_count         INT             NOT NULL DEFAULT 0,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE episodes (
    episode_id          INT             AUTO_INCREMENT      PRIMARY KEY,
    podcast_id          INT             NOT NULL,
    category_id         INT             NOT NULL,
    title               VARCHAR(255)    UNIQUE NOT NULL,
    description         VARCHAR(255)    NOT NULL,
    duration            INT             NOT NULL,
    image_url           VARCHAR(255),
    audio_url           VARCHAR(255)    NOT NULL,
    liked_count         INT             NOT NULL DEFAULT 0,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (podcast_id) REFERENCES podcasts(podcast_id) ON DELETE CASCADE
);

INSERT INTO categories (name) VALUES
    ('Talk Show'),
    ('Comedy'),
    ('Education'),
    ('Entertainment'),
    ('Business');

INSERT INTO users (email, username, password, first_name, last_name, role_id) VALUES
    ('admin@podcastify.com', 'admin', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'admin', 'podcastify', 1),
    ('user@gmail.com', 'user', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'user', 'podcastify', 2),
    ('user1@gmail.com', 'user1', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'John', 'Doe', 2),
    ('user2@gmail.com', 'user2', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Jane', 'Smith', 2),
    ('user3@gmail.com', 'user3', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Alice', 'Johnson', 2),
    ('user4@gmail.com', 'user4', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Bob', 'Anderson', 2),
    ('user5@gmail.com', 'user5', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Eva', 'Miller', 2),
    ('user6@gmail.com', 'user6', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'David', 'Brown', 2),
    ('user7@gmail.com', 'user7', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Megan', 'Taylor', 2),
    ('user8@gmail.com', 'user8', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Alex', 'White', 2),
    ('user9@gmail.com', 'user9', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Sophia', 'Lee', 2),
    ('user10@gmail.com', 'user10', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Daniel', 'Wang', 2),
    ('user11@gmail.com', 'user11', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Michael', 'Johnson', 2),
    ('user12@gmail.com', 'user12', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Emma', 'Davis', 2),
    ('user13@gmail.com', 'user13', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Matthew', 'Wilson', 2),
    ('user14@gmail.com', 'user14', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Olivia', 'Thompson', 2),
    ('user15@gmail.com', 'user15', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'Christopher', 'Hill', 2);

INSERT INTO podcasts (title, description, creator_name, category_id) VALUES
    ('Close The Door Podcast', '3 2 1 Close the door!', 'Deddy Corbuzier', 1),
    ('Teman Tidur', 'Mengantarkan kamu ke dunia mimpi.', 'Dera Firmansyah', 4),
    ('Science Vs', 'The show that pits facts against popular myths and misconceptions.', 'Wondery', 2),
    ('The Joe Rogan Experience', 'Long-form conversations with celebrities, authors, scientists, and more.', 'Joe Rogan', 3),
    ('How I Built This', 'Conversations with entrepreneurs, innovators, and business leaders.', 'Guy Raz', 2),
    ('The Daily', 'A news podcast by The New York Times, covering top stories.', 'The New York Times', 5),
    ('Serial', 'A true crime podcast that tells one story over multiple episodes.', 'Sarah Koenig', 3),
    ('Radiolab', 'A journey of mind-bending scientific and philosophical ideas.', 'Jad Abumrad', 2),
    ('The Tim Ferriss Show', 'Interviews with top performers from various fields.', 'Tim Ferriss', 3),
    ('Freakonomics Radio', 'Exploring the hidden side of everyday life using economics.', 'Stephen Dubner', 2);

INSERT INTO episodes (podcast_id, category_id, title, description, duration, audio_url) VALUES
    (1, 1, 'KISAH WANITA BERMATA TUJUH!', 'Ada yang LASER!! Ghina Khansa', 3000, ''),
    (2, 4, 'Jalanin terus, mau sampe kapan?', 'Malam hari ini ada cerita dari Anka (namanya sudah disamarkan) Anka menceritakan hubungan tanpa status yang dijalani dengan sahabat dari mantan pacarnya. Seperti apa ceritanya? Selamat mendengarkan dan selamat tidur!', 1800, '');
