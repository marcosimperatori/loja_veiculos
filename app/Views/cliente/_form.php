<div class="row">
  <div class="form-group col-lg-12">
    <label for="nome" class="form-label mt-2">Nome <small class="text-danger">*</small></label>
    <input type="text" class="form-control" id="nome" aria-describedby="razao" name="nome" value="<?php echo esc($cliente->nome); ?>" placeholder="Informe a razão social">
  </div>
</div>

<div class="row">
  <div class="form-group col-lg-5">
    <label for="cnpj" class="form-label mt-2">CNPJ|CPF <small class="text-danger">*</small></label>
    <input type="text" class="form-control cpfcnpj" id="cnpj_cpf" name="cnpj_cpf" value="<?php echo esc($cliente->cnpj_cpf); ?>" placeholder="Digite o CNPJ|CPF">
    <div id="response2" class="mt-2"></div>
  </div>

  <div class="col-lg-3">
    <label for="telefone" class="form-label mt-2">Telefone</label>
    <input type="text" class="form-control sp_celphones" id="telefone" name="telefone" value="<?php echo esc($cliente->telefone); ?>">
  </div>
</div>


<div class="row">
  <div class="form-group col-lg-12">
    <label for="emailcli" class="form-label mt-2">Email</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="<?php echo esc($cliente->email); ?>" placeholder="Digite o email do cliente">
  </div>
</div>

<div class="row mt-2">
  <div class="custom-control custom-checkbox">
    <div class="form-check mt-2 d-flex justify-content-end">
      <input type="hidden" name="ativo" value="0">
      <input type="checkbox" name="ativo" id="ativo" value="1" <?php if ($cliente->ativo == true) : ?> checked <?php endif;  ?> class="custom-control-input">
      <label for="ativo" class="custom-control-label">&nbsp;Cliente ativo</label>
    </div>
  </div>
</div>