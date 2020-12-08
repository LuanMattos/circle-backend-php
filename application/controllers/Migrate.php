<?php

class Migrate extends CI_Controller{

    public function __construct(){
        parent::__construct();
//        $this->executarDdl();

    }

    public function index()
    {
//        $this->load->library('migration');
//        if (!$this->migration->current())
//        {
//            show_error($this->migration->error_string());
//        }
    }
    protected function executarDdl(){

        $this->db->trans_start();





//        CREATE DATABASE  Square;
//CREATE SCHEMA IF NOT EXISTS square;
//CREATE TABLE IF NOT EXISTS Square.user (
//            user_id serial PRIMARY KEY,
//                                           user_name VARCHAR(30) NOT NULL UNIQUE,
//                                           user_email VARCHAR(255) NOT NULL,
//                                           user_password VARCHAR(255) NOT NULL,
//                                           user_full_name VARCHAR(40) NOT NULL,
//                                           user_join_date TIMESTAMP DEFAULT current_timestamp
//);
//CREATE TABLE IF NOT EXISTS Square.photo (
//            photo_id SERIAL PRIMARY KEY,
//                                     photo_post_date TIMESTAMP NOT NULL,
//                                     photo_url TEXT NOT NULL,
//                                     photo_description TEXT DEFAULT ('') NOT NULL,
//                                     photo_allow_comments INTEGER NOT NULL DEFAULT (1),
//                                     photo_likes BIGINT NOT NULL DEFAULT (0),
//                                     user_id INTEGER,
//                                     FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
//);
//
//CREATE TABLE IF NOT EXISTS Square.comment (
//            comment_id SERIAL PRIMARY KEY,
//                                       comment_date TIMESTAMP NOT NULL,
//                                       comment_text TEXT  DEFAULT (''),
//                                       photo_id INTEGER,
//                                       user_id INTEGER,
//                                       FOREIGN KEY (photo_id) REFERENCES Square.photo (photo_id) ON DELETE CASCADE,
//                                       FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
//);
//CREATE TABLE IF NOT EXISTS Square.like (
//            like_id SERIAL PRIMARY KEY,
//                                    photo_id INTEGER,
//                                    user_id  INTEGER,
//                                    like_date TIMESTAMP DEFAULT current_timestamp,
//                                    UNIQUE(user_id, photo_id ),
//                                    FOREIGN KEY (photo_id) REFERENCES Square.photo (photo_id) ON DELETE CASCADE,
//                                    FOREIGN KEY(user_id) REFERENCES Square.user(user_id) ON DELETE CASCADE
//);
// ALTER TABLE Square.user ADD COLUMN IF NOT EXISTS name_folder VARCHAR(255) DEFAULT NULL;
// ALTER TABLE Square.photo ADD COLUMN IF NOT EXISTS photo_comments BIGINT;
// ALTER TABLE Square.photo ADD COLUMN IF NOT EXISTS photo_public BIGINT;
//ALTER TABLE Square.photo ADD COLUMN IF NOT EXISTS photo_public BIGINT default 1;
//ALTER TABLE square.user ADD COLUMN IF NOT EXISTS address varchar(500);
//ALTER TABLE square.user ADD COLUMN IF NOT EXISTS description varchar(100);
//ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_avatar_url varchar(1000);
//ALTER TABLE square.user ADD COLUMN IF NOT EXISTS user_cover_url varchar(1000);



//INDEX
//CREATE INDEX IF NOT EXISTS idx_photo ON square.user (user_id);
//CREATE INDEX IF NOT EXISTS idx_user_full_name ON square.user (user_full_name)
//CREATE INDEX IF NOT EXISTS idx_user_name ON square.user (user_name)

//CREATE INDEX IF NOT EXISTS  idx_photo ON square.photo (photo_id);
//CREATE INDEX IF NOT EXISTS idx_photo_user_id ON square.photo (user_id);
//CREATE INDEX IF NOT EXISTS idx_photo_id ON square.photo (photo_id)

//CREATE INDEX IF NOT EXISTS idx_like_photo_id ON square.like (photo_id);
//CREATE INDEX IF NOT EXISTS idx_like_user_id ON square.like (user_id)

//CREATE INDEX idx_comment_date ON square.comment (comment_date DESC)


//        CREATE TABLE IF NOT EXISTS Square.follower (
//            follower_id serial PRIMARY KEY,
//                user_id_to INTEGER,
//                user_id_from INTEGER,
//                follower_date TIMESTAMP DEFAULT current_timestamp,
//                FOREIGN KEY(user_id_to) REFERENCES Square.user(user_id),
//                FOREIGN KEY(user_id_from) REFERENCES Square.user(user_id)
//);

//CREATE INDEX idx_follower_user_id_to ON square.follower (user_id_to);
//CREATE INDEX idx_follower_user_id_from ON square.follower (user_id_from);
//ALTER TABLE Square.user ADD COLUMN  IF NOT EXISTS user_followers BIGINT DEFAULT 0;
//ALTER TABLE Square.user ADD COLUMN  IF NOT EXISTS user_following BIGINT DEFAULT 0;














//                                )");
//        $this->db->query("CREATE OR REPLACE FUNCTION  trigger_set_timestamp() RETURNS TRIGGER AS $$ BEGIN NEW.updated_at = NOW();
//                                RETURN NEW;
//                                END;
//                                $$ LANGUAGE plpgsql");
//        $this->db->query("DROP      TRIGGER if exists  set_timestamp ON usuarios");
//        $this->db->query("CREATE    TRIGGER set_timestamp
//                                BEFORE UPDATE ON usuarios
//                                FOR EACH ROW
//                                EXECUTE PROCEDURE trigger_set_timestamp()");
//        $this->db->query("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS  __ci_last_regenerate numeric(500)");
//        $this->db->query("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS logado boolean");
//        $this->db->query("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS session_coo varchar(10000)");
//        $this->db->query("ALTER TABLE usuarios add column IF NOT EXISTS email varchar(1000)");
//        $this->db->query("ALTER TABLE usuarios add column IF NOT EXISTS datanasc date");
//        $this->db->query("ALTER TABLE usuarios add column IF NOT EXISTS telcel varchar(1000)");

        /** SMS **/
//        $this->db->query("CREATE TABLE if not exists sms_fila (
//                                                            codigo          serial not null,
//                                                            msg             varchar(1000),
//                                                            destinatario    numeric(13),
//                                                            date_to_send    timestamp default now(),
//                                                            date_send       timestamp,
//                                                            response        varchar(1000),
//                                                            created_at      timestamp default  now()
//                            )");
//        $this->db->query("CREATE TABLE if not exists provider_sms(
//                                                            codigo serial not null,
//                                                            conta varchar(500),
//                                                            senha varchar(1000)
//                                                        )");
//        $this->db->query("ALTER TABLE provider_sms add column if not exists provedor varchar(500)");


//        /**Account**/
//        $this->db->query("create table if not exists account_home(
//                                                        codigo bigserial,
//                                                        code_verification varchar(1000),
//                                                        code_restore      varchar(1000),
//                                                        created_at   timestamp default now(),
//                                                        updated_at   timestamptz default now()
//                                                    )");
//        $this->db->query("alter table account_home drop constraint if exists usuarios_pkey");
//        $this->db->query("alter table account_home add column if not exists codusuarios bigint constraint  usuarios_pkey references usuarios");
//        $this->db->query("DROP TRIGGER if exists  set_timestamp ON account_home");
//        $this->db->query("CREATE    TRIGGER set_timestamp
//                                        BEFORE UPDATE ON account_home
//                                        FOR EACH ROW
//                                        EXECUTE PROCEDURE trigger_set_timestamp()");
//        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS nome       varchar(1000)");
//        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS sobrenome  varchar(1000)");
//        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS email_hash varchar(1000)");
//        $this->db->query("ALTER TABLE account_home    ADD COLUMN IF NOT EXISTS verification_ok boolean");
//        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS emailprofissional varchar(100)");
//
//        $this->db->query("CREATE TABLE IF NOT EXISTS location_user(
//                                    codigo                          serial,
//                                    formatted_address_google_maps   varchar(300),
//                                    latitude                        varchar(500),
//                                    longitude                       varchar(500)
//                        );");
//        $this->db->query("ALTER TABLE location_user DROP constraint if exists usuarios_pkey;");
//        $this->db->query("ALTER TABLE location_user ADD COLUMN IF NOT EXISTS codusuario bigint constraint usuarios_pkey references usuarios;");
//        $this->db->query("ALTER TABLE  usuarios ADD COLUMN  IF NOT EXISTS create_folder_img boolean");


//
//        $this->db->query("delete  from provider_sms where codigo > 0");
//        $this->db->query("insert into provider_sms values (default,'luan1.smsonline','WHJM5B2EJj','zenvia');");
        $transaction = $this->db->trans_complete();


        if(!$transaction){
            $this->response("error",["msg"=>"Erro ao atualizar base de dados!"]);
        }
        $this->response("success",["msg"=>"Base Atualizada com sucesso!"]);

    }

    public function CriateUserTest(){
        //drop function random_between;
        //CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
        //    RETURNS text AS
        //$$
        //BEGIN
        //    RETURN floor(random()* (high-low + 1) + low);
        //END;

//        delete  from square.user where user_id > 0;
//-- delete  from square.photo where photo_id > 0;
//-- delete  from square.like where user_id > 0;
//-- delete  from square.comment where user_id > 0;
//--
//--
//-- DO $$
//-- DECLARE
//        --     i INTEGER;
//-- BEGIN
//--     i = 1;
//--     LOOP
//--         INSERT INTO square.user
//        --         VALUES (
//            --                 i,
//            --                 'User' || i,
//            --                 'user' || i || '@circle.com',
//            --                 '$argon2i$v=19$m=65536,t=4,p=1$alYzcnZULld1ZHcvNS9HZw$MHPYWekgHfTIv3koelzk5AXm651Puo8koHqL7TCEWhQ',
//            --                 'User ' || i,
//            --                 now(),
//            --                 null,
//            --                 'Adresss ' || i,
//            --                 'Description ' || i,
//            --                 'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
//            --                 'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg'
//            --                 );
//--         INSERT INTO square.photo VALUES (
//            --                                          i,
//            --                                          now(),
//            --                                          'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg',
//            --                                          'Description by User ' || i,
//            --                                          1,
//            --                                          default,
//--                                          i,
//--                                          default,
//--                                          default
//--                                          );
//--         INSERT INTO square.comment VALUES (i,now(),'Very Good! By User' || i,i,i);
//--         INSERT INTO square.like VALUES (i, i,i);
//--         EXIT WHEN i > 10;
//--         i:=i+1;
//--     END LOOP;
//-- END;
//-- $$;
//--
//-- select * from square.user;







            //$$ language 'plpgsql' STRICT;
            //
            //
            //CREATE OR REPLACE FUNCTION criarTabelaPopulada() RETURNS VOID AS
            //    $BODY$
            //        DECLARE
            //        i INTEGER;
            //        BEGIN
            //            i = 341021;
            //            LOOP
            //                INSERT INTO square.user VALUES (i, 'User' || i, 'user' || i || '@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$aE5JLk0vS0VCaXRJTkdFbw$vDopEoSkzics1r4SC8Vg3nbEJ/TXTYo6FzLZTfnFjEA', 'User ' || i, now(),'usertest', 'Adresss ' || i, 'Description ' || i, 'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg');
            //                INSERT INTO square.like VALUES (default, 60,i);
            //                INSERT INTO square.photo VALUES (default, now(),'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg','Description by User ' || i,1,default,default,i,default);
            //                INSERT INTO square.photo VALUES (default, now(),'https://be.mycircle.click/storage/img_tests/img/' ||  random_between(1,30) || '.jpg','Description by User ' || i,1,default,default,i,default);
            //                INSERT INTO square.comment VALUES (default,now(),'Very Good!',60,i);
            //                EXIT WHEN i > 1000000;
            //                i:=i+1;
            //            END LOOP;
            //        END;
            //    $BODY$
            //LANGUAGE plpgsql VOLATILE;
            //
            //
            //select criarTabelaPopulada() from square.user limit 1;

    }



}
