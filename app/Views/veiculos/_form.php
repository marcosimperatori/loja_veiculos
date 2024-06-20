<div class="row">
  <div class="form-group col-lg-6 col-sm-12">
    <label for="modelo" class="form-label mt-2">Modelo <small class="text-danger">*</small></label>
    <input type="text" class="form-control" id="modelo" aria-describedby="razao" name="modelo" value="<?php echo esc($veiculo->modelo); ?>" placeholder="Informe o modelo">
  </div>

  <div class="col-lg-4 col-sm-12">
    <label for="idfabricante" class="form-label mt-2">Fabricante <small class="text-danger">*</small></label>
    <select name="idfabricante" id="idfabricante" class="form-control ">
      <option value="" selected>Selecione...</option>
      <?php foreach ($fabricantes as $fabric) : ?>
        <option value="<?php echo $fabric->id; ?>" <?php echo ($fabric->id == $veiculo->idfabricante) ? 'selected' : ''; ?>>
          <?php echo $fabric->fabricante; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-lg-2 col-sm-12">
    <label for="idtipo" class="form-label mt-2">Tipo <small class="text-danger">*</small></label>
    <select name="idtipo" id="idtipo" class="form-control ">
      <option value="" selected>Selecione...</option>
      <?php foreach ($tipos as $tipo) : ?>
        <option value="<?php echo $tipo->id; ?>" <?php echo ($tipo->id == $veiculo->idtipo) ? 'selected' : ''; ?>>
          <?php echo $tipo->descricao; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="row">
  <div class="form-group col-lg-3 col-sm-12">
    <label for="potencia" class="form-label mt-2">Potência </label>
    <input type="text" class="form-control" id="potencia" aria-describedby="razao" name="potencia" value="<?php echo esc($veiculo->potencia); ?>" placeholder="Exemplo: 1.0">
  </div>

  <div class="form-group col-lg-3 col-sm-12">
    <label for="combustivel" class="form-label mt-2">Combustível <small class="text-danger">*</small></label>
    <select name="combustivel" id="combustivel" class="form-control ">
      <option value="" selected>Selecione...</option>
      <option value="gasolina" <?php echo ($veiculo->combustivel === "gasolina") ? 'selected' : ''; ?>>Gasolina</option>
      <option value="etanol" <?php echo ($veiculo->combustivel === "etanol") ? 'selected' : ''; ?>>Etanol</option>
      <option value="flex" <?php echo ($veiculo->combustivel === "flex") ? 'selected' : ''; ?>>Flex</option>
      <option value="diesel" <?php echo ($veiculo->combustivel === "diesel") ? 'selected' : ''; ?>>Diesel</option>
    </select>
  </div>

  <div class="form-group col-lg-3 col-sm-12">
    <label for="portas" class="form-label mt-2">Portas </label>
    <input type="text" class="form-control" id="portas" aria-describedby="razao" name="portas" value="<?php echo esc($veiculo->portas); ?>" placeholder="Exemplo: 4">
  </div>
</div>

<div class="row mt-2">

</div>