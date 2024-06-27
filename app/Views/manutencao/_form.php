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
</div>


<div class="row">
  <div class="form-group col-lg-2 col-sm-12">
    <label for="data_compra" class="form-label mt-2">Data</label>
    <input type="date" class="form-control" id="data_compra" name="data_compra" value="<?php echo $estoque->data_compra ?>">
  </div>

  <div class="form-group col-lg-2 col-sm-12">
    <label for="preco_compra" class="form-label mt-2">Preço compra <small class="text-danger">*</small></label>
    <input type="text" class="form-control money" id="preco_compra" aria-describedby="preco_compra" name="preco_compra" value="<?php echo esc($estoque->preco_compra); ?>">
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