<?php echo $this->extend('layouts/principal'); ?>

<?php echo $this->section('conteudo'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Exclusão de cadastro de Veículo</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('/veiculos') ?>">Veículos</a></li>
          <li class="breadcrumb-item active">Exclusão</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <?php echo $this->include('layouts/mensagem'); ?>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div id="response" class="col-12"></div>

        <div class="col-12">
          <div class="card mt-3">
            <div class="card-header">
              <h4>Excluir veículo</h4>
            </div>

            <div class="card-body">
              <p class="card-title lead font-weight-bolder"><i class="fas fa-trash-alt text-danger"></i>&nbsp;Exclusão do registro:&nbsp;</p>
              <h4 class="font-weight-bolder text-danger"><?= $veiculo->modelo ?></h4>
              <hr class="my-4">
              <div class="text-center">
                <p class="lead">Confirma a exclusão do registro acima?</p>
                <a class="btn btn-secondary" href="<?= base_url('veiculos'); ?>" role="button">Cancelar</a>
                <a class="btn btn-danger" href="<?= base_url('veiculos/confirma_exclusao/' . encrypt($veiculo->id)); ?>" role="button">Excluir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="<?php echo base_url("assets/js/veiculos.js"); ?>"></script>
<?php $this->endSection(); ?>