<?php

class Tables
{
    public const ROLE_TABLE =
    "CREATE TABLE IF NOT EXISTS role (
        role_id             INT             AUTO_INCREMENT      PRIMARY KEY,
        name                VARCHAR(255)    UNIQUE NOT NULL
    );";

    public const USER_TABLE =
    "CREATE TABLE IF NOT EXISTS user (
        user_id             INT             AUTO_INCREMENT      PRIMARY KEY,
        email               VARCHAR(255)    UNIQUE NOT NULL,
        username            VARCHAR(50)     UNIQUE NOT NULL,
        password            VARCHAR(255)    NOT NULL,
        first_name          VARCHAR(255)    NOT NULL,
        last_name           VARCHAR(255)    NOT NULL,
        status              SMALLINT        NOT NULL,
        avatar_url          VARCHAR(255),
        last_login          TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
        created_at          TIMESTAMP       DEFAULT CURRENT_TIMESTAMP NOT NULL,
        updated_at          TIMESTAMP       ON UPDATE CURRENT_TIMESTAMP,
        role_id             SMALLINT        NOT NULL,
        FOREIGN KEY (role_id) REFERENCES role (role_id)
    );";
}