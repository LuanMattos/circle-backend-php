<div class="col-lg-9 col-md-7 config-itens" style="display: none" id="div-geral-config-email">
    <div class="setting-form">
        <form action="<?= site_url("account_settings/Account_settings/acao_salvar_email_conta") ?>" method="POST" id="form-geral-config-email-conta">
            <div class="user-data full-width">
                <div class="about-left-heading">
                    <h3>E-mail da conta</h3>
                </div>
                <div class="prsnl-info">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>E-mail antigo*</label>
                                <input class="payment-input" type="text" placeholder="Confirme o antigo E-mail" autocomplete="off" name="email_antigo">
                            </div>
                            <div class="form-group">
                                <label>Senha*</label>
                                <input class="payment-input" type="password" placeholder="Senha" autocomplete="off" name="senha">
                            </div>
                            <div class="form-group">
                                <label>Novo E-mail*</label>
                                <input class="payment-input" type="text" placeholder="Novo E-mail" autocomplete="off" name="novo_email">
                            </div>
                            <div class="form-group">
                                <label>Rep. Novo E-mail*</label>
                                <input class="payment-input" type="text" placeholder="Confirmar novo E-mail" autocomplete="off" name="rep_novo_email">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-crdt-amnt">
                <button class="setting-save-btn" type="button" @click.prevent="acao_salvar_email_conta()">Salvar alterações</button>
            </div>
            <div v-if="email_conta">
                <span style="color:#00abef;font-size:14px" v-html="email_conta">
                </span>
            </div>
        </form>
    </div>
</div>