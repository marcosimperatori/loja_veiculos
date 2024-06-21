<div class="row">
  <div class="col-lg-4 col-sm-12">
    <label for="idveiculo" class="form-label mt-2">Veículo <small class="text-danger">*</small></label>
    <select name="idveiculo" id="idveiculo" class="form-control ">
      <option value="" selected>Selecione...</option>
      <?php foreach ($veiculos as $veiculo) : ?>
        <option value="<?php echo $veiculo->id; ?>" <?php echo ($veiculo->id == $estoque->idveiculo) ? 'selected' : ''; ?>>
          <?php echo $veiculo->modelo; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group col-lg-4 col-sm-12">
    <label for="versao" class="form-label mt-2">Versão </label>
    <input type="text" class="form-control" id="versao" aria-describedby="versao" name="versao" value="<?php echo esc($estoque->versao); ?>" placeholder="Ex.: Confort">
  </div>

  <div class="form-group col-lg-2 col-sm-12">
    <label for="motor" class="form-label mt-2">Motor</label>
    <input type="text" class="form-control" id="motor" aria-describedby="motor" name="motor" value="<?php echo esc($estoque->motor); ?>" placeholder="Ex.: 1.6">
  </div>

  <div class="form-group col-lg-2 col-sm-12">
    <label for="ano" class="form-label mt-2">Ano</label>
    <input type="text" class="form-control" id="ano" aria-describedby="ano" name="ano" value="<?php echo esc($estoque->ano); ?>" placeholder="Ex.: 2024">
  </div>
</div>

<div class="row">
  <div class="form-group col-lg-2 col-sm-12">
    <label for="portas" class="form-label mt-2">Portas</label>
    <input type="money" class="form-control" id="portas" aria-describedby="portas" name="portas" value="<?php echo esc($estoque->portas); ?>" placeholder="Ex.: 4">
  </div>

  <div class="form-group col-lg-3 col-sm-12">
    <label for="cor" class="form-label mt-2">Cor</label>
    <input type="money" class="form-control" id="cor" aria-describedby="cor" name="cor" value="<?php echo esc($estoque->cor); ?>" placeholder="Ex.: Cinza">
  </div>

  <div class="form-group col-lg-3 col-sm-12">
    <label for="tipo" class="form-label mt-2">Tipo <small class="text-danger">*</small></label>
    <select name="tipo" id="tipo" class="form-control ">
      <option value="" selected>Selecione...</option>
      <option value="Hatch" <?php echo ($estoque->tipo === "Hatch") ? 'selected' : ''; ?>>Hatch</option>
      <option value="Sedan" <?php echo ($estoque->tipo === "Sedan") ? 'selected' : ''; ?>>Sedan</option>
      <option value="SUV" <?php echo ($estoque->tipo === "SUV") ? 'selected' : ''; ?>>SUV</option>
      <option value="Crossover" <?php echo ($estoque->tipo === "Crossover") ? 'selected' : ''; ?>>Crossover</option>
      <option value="Coupe" <?php echo ($estoque->tipo === "Coupe") ? 'selected' : ''; ?>>Coupe</option>
      <option value="Convertible" <?php echo ($estoque->tipo === "Convertible") ? 'selected' : ''; ?>>Convertible</option>
      <option value="Minivan" <?php echo ($estoque->tipo === "Minivan") ? 'selected' : ''; ?>>Minivan</option>
      <option value="Station Wagon" <?php echo ($estoque->tipo === "Station Wagon") ? 'selected' : ''; ?>>Station Wagon</option>
      <option value="Outro" <?php echo ($estoque->tipo === "Outro") ? 'selected' : ''; ?>>Outro</option>
    </select>
  </div>

  <div class="form-group col-lg-4 col-sm-12">
    <label for="combustivel" class="form-label mt-2">Combustível <small class="text-danger">*</small></label>
    <select name="combustivel" id="combustivel" class="form-control ">
      <option value="" selected>Selecione...</option>
      <option value="Gasolina" <?php echo ($estoque->combustivel === "Gasolina") ? 'selected' : ''; ?>>Gasolina</option>
      <option value="Etanol" <?php echo ($estoque->combustivel === "Etanol") ? 'selected' : ''; ?>>Etanol</option>
      <option value="Diesel" <?php echo ($estoque->combustivel === "Diesel") ? 'selected' : ''; ?>>Diesel</option>
      <option value="Flex" <?php echo ($estoque->combustivel === "Flex") ? 'selected' : ''; ?>>Flex</option>
      <option value="GNV" <?php echo ($estoque->combustivel === "GNV") ? 'selected' : ''; ?>>GNV</option>
      <option value="Elétrico" <?php echo ($estoque->combustivel === "Elétrico") ? 'selected' : ''; ?>>Elétrico</option>
      <option value="Híbrido" <?php echo ($estoque->combustivel === "Híbrido") ? 'selected' : ''; ?>>Híbrido</option>
      <option value="Híbrido Plug-in" <?php echo ($estoque->combustivel === "Híbrido Plug-in") ? 'selected' : ''; ?>>Híbrido Plug-in</option>
    </select>
  </div>

</div>

<div class="row">
  <div class="form-group col-lg-2 col-sm-12">
    <label for="direcao" class="form-label mt-2">Direção</label>
    <select name="direcao" id="direcao" class="form-control ">
      <option value="Manual" selected>Manual</option>
      <option value="Hidráulica" <?php echo ($estoque->direcao === "Hidráulica") ? 'selected' : ''; ?>>Hidráulica</option>
      <option value="Elétrica" <?php echo ($estoque->direcao === "Elétrica") ? 'selected' : ''; ?>>Elétrica</option>
      <option value="Eletro-hidráulica" <?php echo ($estoque->direcao === "Eletro-hidráulica") ? 'selected' : ''; ?>>Eletro-hidráulica</option>
    </select>
  </div>

  <div class="form-group col-lg-2 col-sm-12">
    <label for="data_compra" class="form-label mt-2">Data</label>
    <input type="date" class="form-control" id="data_compra" name="data_compra" value="<?php echo $estoque->data_compra ?>">
  </div>

  <div class="form-group col-lg-2 col-sm-12">
    <label for="preco_compra" class="form-label mt-2">Preço compra <small class="text-danger">*</small></label>
    <input type="text" class="form-control money" id="preco_compra" aria-describedby="preco_compra" name="preco_compra" value="<?php echo esc($estoque->preco_compra); ?>">
  </div>

  <div class="col-lg-6 col-sm-12">
    <label for="idcliente" class="form-label mt-2">Comprado de <small class="text-danger">*</small></label>
    <select name="idcliente" id="idcliente" class="form-control ">
      <option value="" selected>Selecione...</option>
      <?php foreach ($clientes as $cliente) : ?>
        <option value="<?php echo $cliente->id; ?>" <?php echo ($cliente->id == $estoque->idcliente) ? 'selected' : ''; ?>>
          <?php echo $cliente->nome; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="row mt-3">
  <div class="form-group">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="ar" id="ar" class="custom-control-input">
      <label for="ar" class="custom-control-label mr-3">Ar condicionado</label>
    </div>
  </div>

  <div class="form-group">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="vidro" id="vidro" class="custom-control-input">
      <label for="vidro" class="custom-control-label mr-3">Vidro-elétrico</label>
    </div>
  </div>

  <div class="form-group">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="alarme" id="alarme" class="custom-control-input">
      <label for="alarme" class="custom-control-label mr-3">Alarme/Trava</label>
    </div>
  </div>
</div>

<div class="row">
  <div class="form-group mt-2 col-lg-8 col-sm-12 mt-3">
    <label for="obs" class="form-label mt-2">Descrição das condições do veículo</label>
    <textarea id="obs" name="obs" cols="30" rows="5" placeholder="Descrição da situação do veículo (arranhados, amassado, etc.)" class="form-control"><?php echo esc($estoque->obs); ?></textarea>
  </div>
  <script>
    ClassicEditor
      .create(document.querySelector('#obs'))
      .then(editor => {
        console.log(editor);
      })
      .catch(error => {
        console.error(error);
      });
  </script>
</div>