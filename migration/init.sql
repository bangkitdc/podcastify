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
    avatar_url          VARCHAR(255),
    last_login          TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    role_id             INT             NOT NULL,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

INSERT INTO users (email, username, password, first_name, last_name, avatar_url, role_id) VALUES
    ('admin@podcastify.com', 'admin', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'admin', 'podcastify', NULL, 1),
    ('user@gmail.com', 'user', '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa', 'user', 'podcastify', NULL, 2);

CREATE TABLE podcasts (
    podcast_id          INT             AUTO_INCREMENT      PRIMARY KEY,
    title               VARCHAR(255)    UNIQUE NOT NULL,
    description         VARCHAR(255)     NOT NULL,
    creator_name        VARCHAR(255)    NOT NULL,
    total_eps           INT             NOT NULL DEFAULT 0,
    image_url           VARCHAR(255),
    liked_count         INT             NOT NULL DEFAULT 0,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO podcasts (title, description, creator_name) VALUES
    ('Close The Door Podcast', '3 2 1 Close the door!', 'Deddy Corbuzier'),
    ('Teman Tidur', 'Mengantarkan kamu ke dunia mimpi.', 'Dera Firmansyah');

CREATE TABLE categories (
    category_id         INT             AUTO_INCREMENT      PRIMARY KEY,
    name                VARCHAR(255)    UNIQUE NOT NULL
);

INSERT INTO categories (name) VALUES
    ('Talk Show'),
    ('Comedy'),
    ('Education'),
    ('Entertainment'),
    ('Business');

CREATE TABLE episodes (
    episode_id          INT             AUTO_INCREMENT      PRIMARY KEY,
    podcast_id          INT             NOT NULL,
    category_id         INT             NOT NULL,
    title               VARCHAR(255)    UNIQUE NOT NULL,
    description         VARCHAR(255)     NOT NULL,
    duration            INT             NOT NULL,
    image_url           VARCHAR(255),
    audio_url           VARCHAR(255)    NOT NULL,
    liked_count         INT             NOT NULL DEFAULT 0,
    created_at          TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (podcast_id) REFERENCES podcasts(podcast_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

INSERT INTO episodes (podcast_id, category_id, title, description, duration, audio_url) VALUES
    (1, 1, 'KISAH WANITA BERMATA TUJUH!', 'Ada yang LASER!! Ghina Khansa', 3000, ''),
    (2, 4, 'Jalanin terus, mau sampe kapan?', 'Malam hari ini ada cerita dari Anka (namanya sudah disamarkan) Anka menceritakan hubungan tanpa status yang dijalani dengan sahabat dari mantan pacarnya. Seperti apa ceritanya? Selamat mendengarkan dan selamat tidur!', 1800, '');
