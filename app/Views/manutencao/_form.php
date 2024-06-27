<div class="row">
  <div class="col-lg-6 col-sm-12">
    <label for="idveiculo" class="form-label mt-2">Veículo <small class="text-danger">*</small></label>
    <select name="idveiculo" id="idveiculo" class="form-control ">
      <option value="" selected>Selecione...</option>
      <?php foreach ($veiculos as $veiculo) : ?>
        <option value="<?php echo $veiculo->id; ?>" <?php echo ($veiculo->id == $estoque->id) ? 'selected' : ''; ?>>
          <?php echo $veiculo->modelo; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-lg-4 col-sm-12">
    <label for="idtipomanut" class="form-label mt-2">Tipo de manutenção <small class="text-danger">*</small></label>
    <select name="idtipomanut" id="idtipomanut" class="form-control ">
      <option value="" selected>Selecione...</option>
      <?php foreach ($tipos as $tipo) : ?>
        <option value="<?php echo $tipo->id; ?>" <?php echo ($tipo->id == $manutencao->idtipomanut) ? 'selected' : ''; ?>>
          <?php echo $tipo->tipo_manu; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="row">
  <div class="form-group col-lg-2 col-sm-12">
    <label for="data_manu" class="form-label mt-2">Data</label>
    <input type="date" class="form-control" id="data_manu" name="data_manu" value="<?php echo '' ?>">
  </div>

  <div class="form-group col-lg-2 col-sm-12">
    <label for="preco" class="form-label mt-2">Preço <small class="text-danger">*</small></label>
    <input type="text" class="form-control money" id="preco" aria-describedby="preco" name="preco" value="<?php echo ''/*esc($estoque->preco_compra)*/; ?>">
  </div>
</div>


<div class="row">
  <div class="form-group mt-2 col-lg-8 col-sm-12 mt-3">
    <label for="obs" class="form-label mt-2">Descrição do serviço</label>
    <textarea id="obs" name="obs" cols="30" rows="5" placeholder="Descrição do serviço executado" class="form-control"><?php  ?></textarea>
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