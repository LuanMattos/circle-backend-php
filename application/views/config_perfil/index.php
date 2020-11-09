<div class="col-lg-9 col-md-7 config-itens" style="display: none" id="div-geral-config-perfil-index">
    <form action="<?= site_url("account_settings/Account_settings/acao_salvar_perfil") ?>" method="POST"
          id="form-geral-config-perfil">
        <div class="user-data full-width ">
            <div class="about-left-heading">
                <h3>Perfil</h3>
            </div>
            <div class="prsnl-info">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Descrição*</label>
                            <textarea class="replt-comnt" placeholder="Sobre mim" name="sobre_mim">
                            <?= set_val($data['sobre_mim']) ?>
                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Gênero*</label>
                            <div class="select-bg">
                                <select class="wide" name="genero">
                                    <option value="a" <?= isset($data['genero']) && $data['genero'] == 'a' ? 'selected' : '' ?>>
                                        Masculino
                                    </option>
                                    <option value="b" <?= isset($data['genero']) && $data['genero'] == 'b' ? 'selected' : '' ?>>
                                        Feminino
                                    </option>
                                    <option value="c" <?= isset($data['genero']) && $data['genero'] == 'c' ? 'selected' : '' ?>>
                                        Intersexo
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>Status*</label>
                            <div class="select-bg">
                                <select class="wide" name="status">
                                    <option value="a" <?= isset($data['status']) && $data['status'] == 'a' ? 'selected' : '' ?>>
                                        Solteiro(a)
                                    </option>
                                    <option value="b" <?= isset($data['status']) && $data['status'] == 'b' ? 'selected' : '' ?>>
                                        Casado(a)
                                    </option>
                                    <option value="c" <?= isset($data['status']) && $data['status'] == 'c' ? 'selected' : '' ?>>
                                        Namorando
                                    </option>
                                    <option value="d" <?= isset($data['status']) && $data['status'] == 'd' ? 'selected' : '' ?>>
                                        Divorciado(a)
                                    </option>
                                    <option value="e" <?= isset($data['status']) && $data['status'] == 'e' ? 'selected' : '' ?>>
                                        Viúvo(a)
                                    </option>
                                    <option value="f" <?= isset($data['status']) && $data['status'] == 'f' ? 'selected' : '' ?>>
                                        Complicado
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-crdt-amnt float-left" style="padding-bottom: 15px;padding-left: 15px">
                <button class="setting-save-btn" type="button" @click.prevent="acao_salvar_perfil()">Salvar alterações
                </button>
                <div class="success-save" style="color:blue;font-size:12px;padding: 10px">
                    {{success_save}}
                </div>
            </div>
        </div>
    </form>
</div>