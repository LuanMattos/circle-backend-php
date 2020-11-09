<div class="col-lg-9 col-md-7 config-itens" style="display: none" id="div-geral-mudar-senha">
    <div class="setting-form">
        <form action="<?= site_url("account_settings/Account_settings/acao_salvar_nova_senha") ?>" method="POST" id="form-mudar-senha">
            <div class="user-data full-width">
                <div class="about-left-heading">
                    <h3>Mudar senha</h3>
                </div>
                <div class="prsnl-info">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Senha antiga*</label>
                                <input class="payment-input" type="Password" placeholder="Senha antiga" name="senha_antiga">
                            </div>
                            <div class="form-group">
                                <label>Nova Senha*</label>
                                <input class="payment-input" type="Password" placeholder="Nova senha" name="senha">
                            </div>
                            <div class="form-group">
                                <label>Rep. nova Senha*</label>
                                <input class="payment-input" type="Password" placeholder="Rep. nova senha" name="rep_senha">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-crdt-amnt">
                <button class="setting-save-btn" type="button" @click.prevent="acao_salvar_nova_senha()">Salvar alterações</button>
            </div>
            <div v-if="nova_senha">
                <span style="color:#00abef;font-size:14px">
                    {{nova_senha}}
                </span>
            </div>
        </form>
    </div>
</div>