<div class="col-lg-9 col-md-7 config-itens" id="div-geral-config-informacoes-pessoais-index" style="display: none">
    <div class="setting-form">
        <form action="<?= site_url("account_settings/Account_settings/acao_salvar_informacoes_pessoais") ?>" method="POST" id="form-informacoes-pessoais">
            <div class="user-data full-width">
                <div class="about-left-heading">
                    <h3>Informações pessoais</h3>
                </div>
                <div class="prsnl-info">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Nome<span style="color:red">{{informacoes_pessoais.error.nome}}</span></label>
                                <input class="payment-input"
                                       type="text"
                                       placeholder="Nome"
                                       name="usuarios[nome]"
                                       value="<?= ucfirst(set_val($data['nome'])) ?>">

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Sobrenome<span style="color:red">{{informacoes_pessoais.error.nome}}</span></label>
                                <input class="payment-input"
                                       type="text"
                                       placeholder="Sobrenome"
                                       value="<?= ucfirst(set_val($data['sobrenome'])) ?>"
                                       name="usuarios[sobrenome]"
                                >
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label>Data de nascimento<span style="color:red">{{informacoes_pessoais.error.nome}}</span></label>
                                <input class="payment-input datepicker-here date"
                                       data-language="en"
                                       type="text"
                                       placeholder="08/29/1991"
                                       value="<?= set_val(date_to_br($data['datanasc'])) ?>"
                                       name="usuarios[datanasc]"
                                >
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12">
                            <div class="form-group">
                                <label>Onde você mora?<span style="color:red">{{informacoes_pessoais.error.descricao}}</span></label>
                                    <input class="payment-input"
                                           id="searchTextField"
                                           type="text"
                                           value="<?= set_val($location['formatted_address_google_maps']) ?>"
                                           name="location_user[descricao]"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Número de telefone<span style="color:red">{{informacoes_pessoais.error.telcel}}</span></label>
                                <input type="text"
                                       id="telcel"
                                       class="payment-input phone_ddi_br"
                                       name="usuarios[telcel]"
                                       value="<?= set_val($data['telcel']) ?>"
                                >
                            </div>
                        </div>
                        <span style="color:red;font-size: 10px">{{informacoes_pessoais.error.telceli}}</span></label>
                        <div class="about-left-heading">
                            <h3>Hobbies</h3>
                        </div>
                        <div class="prsnl-info">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Gosto musical</label>
                                        <input class="payment-input"
                                               type="text"
                                               placeholder="Rock, Rap, Solo, Hiphop"
                                               value="<?= set_val($data['gosto_musical']) ?>"
                                               name="usuarios[gosto_musical]"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Livros favoritos</label>
                                        <input class="payment-input" type="text"
                                               placeholder="Jogos, Romântico, Ciência, História"
                                               value="<?= set_val($data['livros_favoritos']) ?>"
                                               name="usuarios[livros_favoritos]"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Horas vagas</label>
                                        <input class="payment-input" type="tel"
                                               placeholder="Ler livros, dançar, academia, cantar, esportes"
                                               value="<?= set_val($data['horas_vagas']) ?>"
                                               name="usuarios[horas_vagas]"

                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-left-heading">
                            <h3>Educação</h3>
                        </div>
                        <div class="prsnl-info">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Instituição</label>
                                        <input class="payment-input" type="text" placeholder="Instituição de ensino"
                                               name="usuarios[instituicao_ensino]"
                                               value="<?= set_val($data['instituicao_ensino']) ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <input class="payment-input" type="text" placeholder="Curso"
                                               name="usuarios[curso]"
                                               value="<?= set_val($data['curso']) ?>"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-left-heading">
                            <h3>Profissão</h3>
                        </div>
                        <div class="prsnl-info">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Profissão</label>
                                        <input class="payment-input" type="text" placeholder="Engenheiro, médico, astronauta"
                                               name="usuarios[profissao]"
                                               value="<?= set_val($data['profissao']) ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <input class="payment-input" type="text" placeholder="Empresa"
                                               name="usuarios[empresa]"
                                               value="<?= set_val($data['empresa']) ?>"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-crdt-amnt">
                <button class="setting-save-btn" type="button" @click.prevent="acao_salvar_informacoes_pessoais()">Salvar alterações</button>
            </div>
            <div v-if="informacoes_pessoais.success">
                <span style="color:#00abef;font-size:14px">
                    {{informacoes_pessoais.success ?informacoes_pessoais.success:''}}
                </span>
            </div>
            <div v-else="informacoes_pessoais.error">
                <span style="color:red;font-size:10px">
                    {{informacoes_pessoais.error ?'Todos os campos com * em vermelho são obrigatórios':''}}
                </span>
            </div>
        </form>
    </div>


