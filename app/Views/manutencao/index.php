<?php echo $this->extend('layouts/principal'); ?>

<?php echo $this->section('conteudo'); ?>


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Listagem de manutenções realizadas</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active">Manutenção</li>
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
        <div class="card">
          <div class="card-header">

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="lista-manutencao" class="table table-striped">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Veículo</th>
                  <th>Tipo</th>
                  <th>Serviço</th>
                  <th>Ações</th>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-12 -->

    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>
<script src="<?php echo base_url("assets/js/manutencao.js"); ?>"></script>
<?php $this->endSection(); ?>