<?php

class Migrate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_function();
        $this->table();
        $this->finallyVacuum();
        $this->finallyCreateIndex();
        echo "Fim da atualização";
    }

    private function dataBaseAndSchema()
    {
//        $this->db->query("CREATE DATABASE  Square;");
//        $this->db->query("CREATE DATABASE  Mining;");
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
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.follower (
                                               follower_id serial PRIMARY KEY,
                                               user_id_to INTEGER,
                                               user_id_from INTEGER,
                                               follower_date TIMESTAMP DEFAULT current_timestamp,
                                               FOREIGN KEY(user_id_to) REFERENCES Square.user(user_id),
                                               FOREIGN KEY(user_id_from) REFERENCES Square.user(user_id)
                                               );");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN  IF NOT EXISTS user_followers BIGINT DEFAULT 0;");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN  IF NOT EXISTS user_following BIGINT DEFAULT 0;");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN IF NOT EXISTS user_code_verification VARCHAR(50) DEFAULT NULL;");
        $this->db->query("ALTER TABLE Square.user ADD COLUMN IF NOT EXISTS user_link_forgot_password VARCHAR(500) DEFAULT NULL;");
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.user_twitter (
                                           user_id serial PRIMARY KEY,
                                           profile_banner_url VARCHAR(250),
                                           screen_name VARCHAR(255),
                                           location VARCHAR(150),
                                           description VARCHAR(500),
                                           user_twitter_id varchar(200),
                                           ids_followers varchar(500000),
                                           user_join_date TIMESTAMP DEFAULT current_timestamp
                                                );");
        $this->db->query('ALTER TABLE Square.user_twitter ADD COLUMN IF NOT EXISTS mined boolean DEFAULT false;');
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_vpi varchar(50);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_mpc varchar(50);");
        $this->db->query("CREATE TABLE IF NOT EXISTS square.user_monetization
                (
                    user_monetization_id     serial PRIMARY KEY,
                    user_guest_id            INTEGER,
                    user_id                  INTEGER,
                    created_at               TIMESTAMP DEFAULT current_timestamp,
                    updated_at               TIMESTAMP DEFAULT current_timestamp,
                    user_monetization_closed boolean   default false,
                    FOREIGN KEY (user_guest_id) REFERENCES Square.user (user_id),
                    FOREIGN KEY (user_id) REFERENCES Square.user (user_id)
                );");
        $this->db->query("CREATE TABLE IF NOT EXISTS square.trading
                    (
                        trading_id serial PRIMARY KEY,
                        trading_days varchar(20),
                        trading_mpc varchar(50),
                        trading_max_ivpi varchar(50)
                    );");
        $this->db->query("CREATE TABLE IF NOT EXISTS square.email_monetization
                (
                    email_monetization_id serial PRIMARY KEY,
                    user_name             varchar(200),
                    user_full_name        varchar(200),
                    user_id               INTEGER,
                    full_name_guest       varchar(200),
                    email_guest           varchar(200),
                    created_at            TIMESTAMP DEFAULT current_timestamp,
                    date_send             TIMESTAMP DEFAULT null
                )");
        $this->db->query("
            ALTER TABLE square.user DROP COLUMN IF EXISTS user_vpi;
            ALTER TABLE square.user DROP COLUMN IF EXISTS user_mpc;
            ALTER TABLE square.user_monetization ADD COLUMN IF NOT EXISTS user_vpi NUMERIC(3,2);
            ALTER TABLE square.user_monetization ADD COLUMN IF NOT EXISTS user_mpc NUMERIC(3,2);
        ");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS monetization_sent boolean default false;");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_send_mail_marketing_1 boolean default false");
        $this->db->query("ALTER TABLE square.photo ALTER COLUMN photo_description drop not null");
        $this->location();
    }

    private function location()
    {
        $this->db->query("
                    CREATE TABLE IF NOT EXISTS Square.error_type (
                                                       error_type_id serial PRIMARY KEY,
                                                       error_type_title VARCHAR(100)
            );
            
            CREATE TABLE IF NOT EXISTS Square.error_log (
                                                       error_log_id serial PRIMARY KEY,
                                                       user_id bigint not null,
                                                       error_type_id bigint,
                                                       error_log_date TIMESTAMP DEFAULT current_timestamp,
                                                       FOREIGN KEY(error_log_id) REFERENCES Square.error_type(error_type_id),
                                                       FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
            );
            CREATE TABLE IF NOT EXISTS Square.user_location (
                                                       user_location_id serial PRIMARY KEY,
                                                       user_id bigint not null,
                                                       user_location_date TIMESTAMP DEFAULT current_timestamp,
                                                       FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
            );
            
            CREATE TABLE IF NOT EXISTS Square.location (
                                                       location_id serial PRIMARY KEY,
                                                       location_coordinates varchar(100),
                                                       location_lat varchar(100),
                                                       location_long varchar(100),
                                                       location_city varchar(150),
                                                       location_country varchar(70),
                                                       location_state varchar(50),
                                                       location_zip_code varchar(20),
                                                       location_continent varchar(20),
                                                       location_complement varchar(200),
                                                       user_id bigint,
                                                       location_date TIMESTAMP DEFAULT current_timestamp,
                                                       FOREIGN KEY(user_id) REFERENCES Square.user(user_id)
            );
            
            CREATE TABLE IF NOT EXISTS Square.system_data_information (
                                                                system_data_information_id serial PRIMARY KEY,
                                                                user_id bigint,
                                                                system_data_information_local_storage varchar(1000),
                                                                system_data_information_cookies varchar(1000),
                                                                system_data_information_user_agent varchar(150),
                                                                system_data_information_http_origin varchar(100),
                                                                system_data_information_http_referer varchar(100),
                                                                system_data_information_remote_addr varchar(100),
                                                                system_data_information_date TIMESTAMP DEFAULT current_timestamp,
                                                                FOREIGN KEY(user_id) REFERENCES Square.user(user_id)
            
            );
            
            
            CREATE TABLE IF NOT EXISTS Square.log_access (
                                                                log_access_id serial PRIMARY KEY,
                                                                user_id bigint default null,
                                                                error_type_id bigint default null,
                                                                system_data_information_id bigint default null,
                                                                log_access_date TIMESTAMP DEFAULT current_timestamp,
                                                                FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE,
                                                                FOREIGN KEY(error_type_id) REFERENCES Square.error_type(error_type_id) ON DELETE CASCADE
            
            );
        ");
        $this->db->query("CREATE TABLE IF NOT EXISTS Square.email_marketing(
                                email_marketing_id serial PRIMARY KEY,
                                email_marketing_email varchar(100),
                                email_marketing_description varchar(150),
                                email_marketing_sent boolean,
                                email_marketing_date TIMESTAMP DEFAULT current_timestamp
    )");
        $this->db->query("ALTER TABLE Square.system_data_information ADD COLUMN IF NOT EXISTS system_data_information_host_name VARCHAR(100) DEFAULT NULL;
                      ALTER TABLE Square.system_data_information ADD COLUMN IF NOT EXISTS system_data_information_host_name_by_ip VARCHAR(100) DEFAULT NULL;
                      ALTER TABLE Square.system_data_information ADD COLUMN IF NOT EXISTS system_data_information_ip_by_host_name VARCHAR(100) DEFAULT NULL;
                      ALTER TABLE Square.location ADD COLUMN IF NOT EXISTS location_hostname VARCHAR(150) DEFAULT NULL;
                      ALTER TABLE Square.location ADD COLUMN IF NOT EXISTS location_organization VARCHAR(150) DEFAULT NULL;
                      ALTER TABLE Square.location ADD COLUMN IF NOT EXISTS location_time_zone VARCHAR(150) DEFAULT NULL;
                      ALTER TABLE Square.system_data_information ADD COLUMN IF NOT EXISTS system_data_information_http_x_forwarded_for VARCHAR(150) DEFAULT NULL;
                      ALTER TABLE square.error_type ADD COLUMN IF NOT EXISTS error_type_code bigint unique;
                      ALTER TABLE square.email_marketing ADD COLUMN IF NOT EXISTS status varchar(100);
                      ALTER TABLE square.email_marketing ADD COLUMN IF NOT EXISTS telefone varchar(80);
                      ");
        $this->db->query("
        insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'500','Falha ao criar pasta do usuário');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'501','Falha ao fazer Upload');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'502','Token Inválido');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'503','Tentativa de acesso restrito ao storage');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'504','Falha ao criar pasta no storage');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'505','Usuário incorreto');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'506','Incorrect password');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'507','Falha ao salvar os dados na configuração da conta');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'508','Falha ao postar imagem');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'509','Falha na barra de pesquisa');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'510','Falha ao carregar a imagem do perfil');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'511','Falha ao carregar a imagem de fundo');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'512','Falha ao carregar o timeline');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'514','Falha ao carregar o timeline do perfil');
insert into square.error_type  (error_type_id,error_type_code,error_type_title) values (default,'516','Falha ao carregar comentários');
        ");
        $this->db->query("ALTER TABLE square.system_data_information ADD COLUMN IF NOT EXISTS system_data_information_device_id varchar(200);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_device_id varchar(200);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_blocked boolean;");
        $this->db->query("ALTER TABLE square.photo ADD COLUMN IF NOT EXISTS photo_styles varchar(100);");
        $this->db->query("ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_token varchar(1000)");
        $this->db->query("ALTER TABLE square.photo ADD COLUMN log_error_count bigint");
        $this->db->query("CREATE TABLE IF NOT EXISTS  square.photo_statistic
            (
                photo_statistic_id serial PRIMARY KEY,
                photo_statistic_time BIGINT,
                photo_id INTEGER,
                user_id INTEGER,
                FOREIGN KEY (photo_id) REFERENCES Square.photo (photo_id) ON DELETE CASCADE,
                FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
            );
        ");
        $this->db->query("CREATE TABLE IF NOT EXISTS  square.words_user
            (
                words_user_id serial PRIMARY KEY,
                words_user_words varchar,
                user_id INTEGER,
                FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
            );
        ");
    }

    private function finallyVacuum()
    {
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.photo;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.user;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.comment;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.follower;");
        $this->db->query("VACUUM (VERBOSE, ANALYZE) square.like;");
    }

    private function finallyCreateIndex()
    {
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_follower_user_id_to ON square.follower (user_id_to);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_follower_user_id_from ON square.follower (user_id_from);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_photo ON square.user (user_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_user_full_name ON square.user (user_full_name);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_user_name ON square.user (user_name);");
        $this->db->query("CREATE INDEX IF NOT EXISTS  idx_photo ON square.photo (photo_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_photo_user_id ON square.photo (user_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_photo_id ON square.photo (photo_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_like_photo_id ON square.like (photo_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_like_user_id ON square.like (user_id);");
        $this->db->query("CREATE INDEX IF NOT EXISTS idx_comment_date ON square.comment (comment_date DESC);");
    }

    public function sizeDatabae()
    {
        $this->db->query("SELECT pg_database.datname, pg_size_pretty(pg_database_size(pg_database.datname)) AS size FROM pg_database");
    }

    public function getImageRandom()
    {
        $start = 7729;
        for ($i = $start; $i <= 10000; $i++) {
            echo $i;
            $url = "https://source.unsplash.com/random";
            $img = "storage/img_tests/img/{$i}.jpg";
            $get = file_get_contents($url);
            if ($get && !empty($get)) {
                file_put_contents($img, $get);
            }
            sleep(2);

        }
    }


}
