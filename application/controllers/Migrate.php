<?php

class Migrate extends CI_Controller{

    public function __construct(){
        parent::__construct();
//        $this->executarDdl();
        $this->test();

    }

    public function index()
    {
        $this->test();
//        $this->load->library('migration');
//        if (!$this->migration->current())
//        {
//            show_error($this->migration->error_string());
//        }
    }
    protected function executarDdl(){

        $this->db->trans_start();





        //        CREATE DATABASE  Square;
//CREATE SCHEMA IF NOT EXISTS Square;
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

    public function test(){
        $this->load->model("likes/Likes_model");
        $this->load->model("user/User_model");

       $countMax = $this->db->query('select max(square.user.user_id) from square.user')->row();


       $names = [
         'João Silva',
         'Maria Richard',
           'Ricardo Telles',
           'José Freris',
           'Thaís Naso',
           'Adriano Serpa',
           'Eduarda Cavalheiro',
           'Eduardo',
           'Silvania',
           'Silvia',
           'Silvio Medeiros',
           'Tales Rai',
           'Maris Brandon',
           'Thery Marques',
           'Michael Sidinei',
           'John Frecks',
           'Kelly Morgan'
       ];

       $address = [
           'Porto Rico',
           'Brasil/RJ',
           'Brasilia',
           'Porto Alegre RS',
           'São Paulo',
           'San Petesburg',
           'Irã',
           'Porto Mexico'
       ];

        for ($i = (int)$countMax->max + 5;$i <= (int)$countMax->max + 10000;$i ++ ){

            $userName = "joao" . $i;
                $email = "joao".$i . "@teste.com";
                $senha = password_hash( '12345678',PASSWORD_ARGON2I );
            //$this->db->trans_start();

                $user = [
                    'user_id'=>$i,
                    'user_name'=>$userName,
                    'user_email'=>$email,
                    'user_password'=>$senha,
                    'user_full_name'=>$names[rand(0,16)] .  " $i",
                    'address'=>$address[rand(0,7)]
                ];
                $this->db->insert('user',$user);

                $like = [
                    'photo_id'=>rand(4721,11547),
                    'user_id'=>$i
                ];

                $this->Likes_model->save( $like );

                $photosUrl = [
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/b1f626b13a8e35f35bdaeef5983116f6download.jpg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/efe83f5d3c2af91908d5a407deed1903download.png',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/b125a386029b7c578f721a76f7684533Experiences_Beach.jpg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/fde331e4c5c44e8bd90aaa8e78f27f09fernando-de-noronha-o-paraiso-que-voce-precisa-conhecer.jpeg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/8c7bb9ddb37f57b51cf6963de61e999eShanghai_shutterstock_1239377482.jpg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/a55f0f8ebaa352d4f5aaff6c80bc3146images_landing_page_1314146_topo-email.jpg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/cccbec2a2b5447aa48f07b24de3f833fad15bfd7b0_50164279_rotation-galaxie-spirale-univers.jpg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/423efb493050d60896b73b027bbb5d24viagem-para-alemanha-740x360.jpeg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/e31d02642867e0a6dad782bf66c1d855homer.jpg',
                    'http://localhost/storage/img/d1e7e7064b80c97487465b7595277e65/cd3409647f5b30900c42475472c3f115uol211.jpg',
                    'https://www.newzealand.com/assets/Tourism-NZ/Fiordland/img-1536137761-110-7749-p-7ECF7092-95BD-FE18-6D4107E2E42D067E-2544003__aWxvdmVrZWxseQo_FocalPointCropWzQyNyw2NDAsNTAsNTAsODUsImpwZyIsNjUsMi41XQ.jpg',
                    'https://exame.com/wp-content/uploads/2016/09/size_960_16_9_nova-zelandia4.jpg',
                    'https://dicasnovayork.com.br/wp-content/uploads/2018/07/oquefazer_header1-1000x700.jpg',
                    'https://mundoviajar.com.br/wp-content/uploads/2016/09/grote-markt.jpg',
                    'https://i2.wp.com/turismo.eurodicas.com.br/wp-content/uploads/2018/09/turismo-na-belgica-1.jpg?fit=1360%2C907&ssl=1',
                    'https://blogdointercambio.stb.com.br/wp-content/uploads/2019/09/Curso-de-franc%C3%AAs-nas-melhores-escolas-da-Fran%C3%A7a-1.jpg',
                    'https://aventurasnahistoria.uol.com.br/media/_versions/capa_reino_unido_inglaterra_gra_bretanha_widelg.jpeg',
                    'https://www.estudopratico.com.br/wp-content/uploads/2016/07/reino-unido.jpg',
                    'https://www.foregon.com/blog/wp-content/uploads/2019/06/morar-na-inglaterra.jpg',
                    'https://s3.lufthansacc.com/wp-content/uploads/2050/11/CL%C3%81SSICO-DE-INGLATERRA-E-ESC%C3%93CIA-1.jpg',
                    'https://www.passagenspromo.com.br/blog/wp-content/uploads/2020/03/cidades-da-russia.jpg',
                    'https://www.state.gov/wp-content/uploads/2018/11/Russia-2499x1406.jpg',
                    'https://ep01.epimg.net/elviajero/imagenes/2018/11/20/album/1542734421_520813_1542734629_noticia_normal.jpg',
                    'https://www.heritage.org/sites/default/files/styles/slide_cover_xl/public/images/2018-12/hollywood.jpg?itok=Z74JKsUB',
                    'https://ca-times.brightspotcdn.com/dims4/default/092e0a4/2147483647/strip/true/crop/5000x3135+0+0/resize/1486x932!/quality/90/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fe0%2F85%2Fbf58d63d4c808009a6c4b4645f39%2Ffi-ovation-hollywood-highland-1.jpg',
                    'https://www.visiteosusa.com.br/sites/default/files/styles/hero_l_x2/public/images/hero_media_image/2018-06/0c647c1b4b1a841d3e0a1d6542875829.jpeg?itok=dnkU43w8',
                    'https://viajando.expedia.com.br/wp-content/uploads/o-que-fazer-em-miami.jpg',
                    'https://dicasdaflorida.com.br/wp-content/uploads/2018/08/miami-mar-cidade.jpg',
                    'https://images1.miaminewtimes.com/imager/u/original/9592703/independance-2016-nikki-beach-miami-34.jpg',
                    'https://cdn.filestackcontent.com/resize=w:1860/quality=v:75/auto_image/compress/qTQxQpsgSpegwybKL9sN',
                    'https://cdn.evbuc.com/eventlogos/288375840/partyboatmiamiboozecruisemiamipartybuspartyboatmiamiboozecruisemiami.jpg',
                    'https://miamibeachtimes.com/wp-content/uploads/2019/06/62116704_10161928157485241_125807297271169024_o.jpg',
                    'https://www.theplunge.com/wp-content/uploads/2017/09/Last_72_hours_miami_sls_hotel_pool_party.png',
                    'https://arbache.com/blog/wp-content/uploads/2018/09/china-990x297.png',
                    'https://afar-production.imgix.net/uploads/images/afar_post_headers/images/DA2YtCleQi/original_lede-madrid-shutterstock.jpg?auto=compress,format&fit=crop&crop=top&lossless=true&w=1600&h=700',
                    'https://i.insider.com/554b72016bb3f76124881fcd?width=1100&format=jpeg&auto=webp',
                    'https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F88474991%2F24250841862%2F1%2Foriginal.20191113-164106?w=512&auto=format%2Ccompress&q=75&sharp=10&rect=0%2C0%2C800%2C400&s=fba61863fcc17b6276efb94ff0b8ceb0',
                    'https://c8.alamy.com/comp/CAK0N6/oct-03-2007-new-york-city-ny-usa-2008-hooters-calendar-girls-vip-party-CAK0N6.jpg',
                    'https://media.guestofaguest.com/t_article_content/gofg-media/2019/08/1/52650/64940903_116226052977080_1044917097755593037_n.jpg',
                    'https://static.dw.com/image/18039867_303.jpg'
                ];

                $photo = [
                    'photo_url'=>$photosUrl[rand(0,38)],
                    'photo_description'=>'Photo posted by ' . $userName,
                    'user_id'=>$i,
                    'photo_post_date'=>date('Y-m-d H:i:s')
                ];

            for ($a = 1;$a <= rand(1,20);$a ++ ){
                $photo['photo_url']=$photosUrl[rand(0,38)];
                $this->db->insert('photo', $photo );

            }


            echo 'Migracao N° ' . $i . "</br>";
            set_time_limit(500000000000000000);

            if($i == ($countMax->max + 600)){
                header("Refresh:0");
            }

            //$this->db->trans_complete();


        }



    }



}
