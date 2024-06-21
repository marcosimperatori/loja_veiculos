<?php echo $this->extend('layouts/principal'); ?>

<?php echo $this->section('conteudo'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Entrada de veículo</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/estoque') ?>">Estoque</a></li>
          <li class="breadcrumb-item active">Cadastro</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <?php echo $this->include('layouts/mensagem'); ?>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div id="response" class="col-12"></div>

        <div class="col-12">
          <div class="card mt-3">
            <div class="card-header">
              <h4>Dados da compra</h4>
            </div>

            <div class="card-body">

              <?php echo form_open('/', ['id' => 'form_cad_estoque', 'class' => 'insert'], ['id' => "$estoque->id"]) ?>

              <?php echo $this->include('estoque/_form'); ?>

              <div class="d-flex justify-content-center mt-4">
                <a href="<?php echo site_url("estoque"); ?>" id="btn-cancelar" class="btn btn-secondary btn-sm mb-2 mx-2">Cancelar</a>
                <input id="btn-salvar" type="submit" value="Gravar" class="btn btn-success btn-sm mb-2">
              </div>

              <?php form_close(); ?>
              <p><small class="text-danger">* campo(s) obrigatório(s)</small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="<?php echo base_url("assets/js/estoque.js"); ?>"></script>
<?php $this->endSection(); ?>