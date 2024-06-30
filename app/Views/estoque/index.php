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

        <div class="timeline">
          <!-- Timeline time label -->
          <div class="time-label">
            <span class="bg-green">15 Jun. 2024</span>
          </div>
          <div>
            <!-- Before each timeline item corresponds to one icon on the left scale -->
            <i class="fas fa-handshake bg-green"></i>
            <!-- Timeline item -->
            <div class="timeline-item">

              <!-- Header. Optional -->
              <h3 class="timeline-header">Veículo vendido</h3>
              <!-- Body -->
              <div class="timeline-body">
                Comprador: Fulano de Tal.
              </div>
            </div>
          </div>

          <!-- Timeline time label -->
          <div class="time-label">
            <span class="bg-gray">12 Jun. 2024</span>
          </div>
          <div>
            <!-- Before each timeline item corresponds to one icon on the left scale -->
            <i class="fas fa-shower bg-light-gray"></i>
            <!-- Timeline item -->
            <div class="timeline-item">

              <!-- Header. Optional -->
              <h3 class="timeline-header">Serviço de higienização</h3>
              <!-- Body -->
              <div class="timeline-body">
                Limpeza do veículo para ser colocado a venda.
              </div>
            </div>
          </div>

          <!-- Timeline time label -->
          <div class="time-label">
            <span class="bg-gray">10 Jun. 2024</span>
          </div>
          <div>
            <!-- Before each timeline item corresponds to one icon on the left scale -->
            <i class="fas fa-tools bg-light-gray"></i>
            <!-- Timeline item -->
            <div class="timeline-item">

              <!-- Header. Optional -->
              <h3 class="timeline-header">Serviço de elétrica</h3>
              <!-- Body -->
              <div class="timeline-body">
                Troca das lâmpadas do painel do ar condicionado; Sensor do freio de mão.
              </div>

            </div>
          </div>

          <div class="time-label">
            <span class="bg-primary">07 Jun. 2024</span>
          </div>
          <div>
            <!-- Before each timeline item corresponds to one icon on the left scale -->
            <i class="fas fa-cart-plus bg-blue"></i>
            <!-- Timeline item -->
            <div class="timeline-item">
              <!-- Header. Optional -->
              <h3 class="timeline-header">Compra do veículo</h3>
              <!-- Body -->
              <div class="timeline-body">
                Arranhados no parachoque dianteiro; pneus desgastados.
              </div>

            </div>
          </div>
          <!-- The last icon means the story is complete -->
          <div>
            <i class="fas fa-clock bg-gray"></i>
          </div>
        </div>

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