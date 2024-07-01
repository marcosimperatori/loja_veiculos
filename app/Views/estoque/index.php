<?php echo $this->extend('layouts/principal'); ?>

<?php echo $this->section('conteudo'); ?>


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Listagem do estoque</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active">Estoque</li>
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
            <table id="lista-estoque" class="table table-striped">
              <thead>
                <tr>
                  <th>Veículo</th>
                  <th>Ano</th>
                  <th>Motor</th>
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

<!-- Modal deletar -->
<div class="modal fade" id="maintenance" tabindex="-1" role="dialog" aria-labelledby="maintenance" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="maint-title">Manutenções</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <h2 id="maint-response"></h2>

        <!-- Conteúdo do modal -->
        <h2 id="fabricanteid"></h2>
        <input type="hidden" id="codFabricante">
        <p id="codigo"></p>

        <div id="timeline"></div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>

      </div>
    </div>
  </div>

  <?php $this->endSection(); ?>


  <?php echo $this->section('scripts'); ?>
  <script src="<?php echo base_url("assets/js/estoque.js"); ?>"></script>
  <?php $this->endSection(); ?>