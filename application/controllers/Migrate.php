<?php

class Migrate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
            $this->dataBaseAndSchema();
            $this->_function();
            $this->table();
            $this->_finally();
    }


    private function dataBaseAndSchema()
    {
        $this->db->query("CREATE DATABASE  Square;");
        $this->db->query("CREATE SCHEMA IF NOT EXISTS square;");
    }

    private function _function()
    {
        $this->db->query("CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
        RETURNS text AS
    $$
        BEGIN
            RETURN floor(random()* (high-low + 1) + low);
        END;
        $$ language 'plpgsql' STRICT;");
    }

    private function table()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.user (
                                           user_id serial PRIMARY KEY,
                                           user_name VARCHAR(30) NOT NULL UNIQUE,
                                           user_email VARCHAR(255) NOT NULL,
                                           user_password VARCHAR(255) NOT NULL,
                                           user_full_name VARCHAR(40) NOT NULL,
                                           user_join_date TIMESTAMP DEFAULT current_timestamp
                                           );");
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.photo (
                                            photo_id SERIAL PRIMARY KEY,
                                            photo_post_date TIMESTAMP NOT NULL,
                                            photo_url TEXT NOT NULL,
                                            photo_description TEXT DEFAULT ('') NOT NULL,
                                            photo_allow_comments INTEGER NOT NULL DEFAULT (1),
                                            photo_likes BIGINT NOT NULL DEFAULT (0),
                                            user_id INTEGER,
                                            FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
                                            );");
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.comment (
                                              comment_id SERIAL PRIMARY KEY,
                                              comment_date TIMESTAMP NOT NULL,
                                              comment_text TEXT  DEFAULT (''),
                                              photo_id INTEGER,
                                              user_id INTEGER,
                                              FOREIGN KEY (photo_id) REFERENCES Square.photo (photo_id) ON DELETE CASCADE,
                                              FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
                                              );");
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.like (
                                           like_id SERIAL PRIMARY KEY,
                                           photo_id INTEGER,
                                           user_id  INTEGER,
                                           like_date TIMESTAMP DEFAULT current_timestamp,
                                           UNIQUE(user_id, photo_id ),
                                           FOREIGN KEY (photo_id) REFERENCES Square.photo (photo_id) ON DELETE CASCADE,
                                           FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
                                           );");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN IF NOT EXISTS name_folder VARCHAR(255) DEFAULT NULL;");
        $this->db->query("ALTER TABLE Square.photo ADD COLUMN IF NOT EXISTS photo_comments BIGINT;");
        $this->db->query("ALTER TABLE Square.photo ADD COLUMN IF NOT EXISTS photo_public BIGINT;");
        $this->db->query("ALTER TABLE Square.photo ADD COLUMN IF NOT EXISTS photo_public BIGINT default 1;");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS address varchar(500);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS description varchar(100);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_avatar_url varchar(1000);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_cover_url varchar(1000);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_photo ON square.user (user_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_user_full_name ON square.user (user_full_name);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_user_name ON square.user (user_name);");
        $this->db->query("CREATE INDEX IF NOT EXISTS  idx_photo ON square.photo (photo_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_photo_user_id ON square.photo (user_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_photo_id ON square.photo (photo_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_like_photo_id ON square.like (photo_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_like_user_id ON square.like (user_id);");
        $this->db->query("CREATE INDEX idx_comment_date ON square.comment (comment_date DESC);");
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.follower (
                                               follower_id serial PRIMARY KEY,
                                               user_id_to INTEGER,
                                               user_id_from INTEGER,
                                               follower_date TIMESTAMP DEFAULT current_timestamp,
                                               FOREIGN KEY(user_id_to) REFERENCES Square.user(user_id),
                                               FOREIGN KEY(user_id_from) REFERENCES Square.user(user_id)
                                               );");
        $this->db->query("CREATE INDEX idx_follower_user_id_to ON square.follower (user_id_to);");
        $this->db->query("CREATE INDEX idx_follower_user_id_from ON square.follower (user_id_from);");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN  IF NOT EXISTS user_followers BIGINT DEFAULT 0;");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN  IF NOT EXISTS user_following BIGINT DEFAULT 0;");
    }

    public function testDatabase()
    {
        /** 123 **/
        $pass = '$argon2i$v=19$m=65536,t=4,p=1$alYzcnZULld1ZHcvNS9HZw$MHPYWekgHfTIv3koelzk5AXm651Puo8koHqL7TCEWhQ';
        $this->db->query("DO $$
                            DECLARE
                                i INTEGER;
                            BEGIN
                                i = 1;
                                LOOP
                                    INSERT INTO square.user
                                    VALUES (
                                               i,
                                               'User' || i,
                                               'user' || i || '@circle.com',
                                               '$pass',
                                               'User ' || i,
                                               now(),
                                               null,
                                               'Adresss ' || i,
                                               'Description ' || i,
                                               'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                               'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg'
                                           );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        1,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        0,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        1,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        1,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        1,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        1,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        0,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        1,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        0,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        0,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    INSERT INTO square.photo VALUES (
                                                                        default,
                                                                        now(),
                                                                        'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
                                                                        'Description by User ' || i,
                                                                        0,
                                                                        default,
                                                                        i,
                                                                        default,
                                                                        default
                                                                    );
                                    EXIT WHEN i > 1000000;
                                    i:=i+1;
                                END LOOP;
                            END;
$$;
");
    }
    private function _finally(){
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.photo;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.user;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.comment;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.follower;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.like;");
    }


}
