<div class="col-lg-9 col-md-7 config-itens" style="display: none" id="div-geral-config-requisicoes-amizades">
    <form action="<?= site_url("account_settings/Account_settings/acao_salvar_requisicoes_amizade") ?>" method="POST"
          id="form-geral-config-requisicoes-amizade">
        <div class="user-data full-width">
            <div class="about-left-heading">
                <h3>Requisições de amizades</h3>
            </div>
            <div class="noti-sting1">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="noti-all-st form-group">
                            <ul>
                                <li>
                                    <div class="noti-st">
                                        <div class="noti-left-t">
                                            Bloquear solicitações
                                        </div>
                                        <div class="noti-right-b">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="customSwitch1"
                                                       name="bloquear_solicitacoes_amizade"
                                                    <?= isset($data['bloquear_solicitacoes_amizade']) && $data['bloquear_solicitacoes_amizade'] ? 'checked' : '' ?>
                                                >
                                                <label class="custom-control-label" for="customSwitch1"></label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-crdt-amnt float-left" style="padding-bottom: 15px;padding-left: 15px">
            <button class="setting-save-btn" type="button" @click.prevent="acao_salvar_solicitacoes_amizades()">Salvar alterações
            </button>
            <div class="success-save" style="color:blue;font-size:12px;padding: 10px">
                {{success_save}}
            </div>
        </div>
    </form>
</div>