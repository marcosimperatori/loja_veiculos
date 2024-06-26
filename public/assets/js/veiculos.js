$(function () {
  const table = $("#lista-veiculos").DataTable({
    oLanguage: DATATABLE_PTBR,
    responsive: true,
    lengthChange: true,
    info: true,
    deferRender: true,
    autoWidth: false,
    pagingType: $(window).width() < 768 ? "simple" : "simple_numbers",
    pageLength: 10,
    buttons: [
      {
        text: "Novo",
        action: function (e, dt, node, config) {
          window.location.href = "/veiculos/criar";
        },
        className: "bg-gradient-primary",
      },
      {
        extend: "pdf",
        text: "Exportar para PDF ",
        //orientation: "landscape",
      },
      {
        extend: "print",
        text: "Imprimir",
      },
    ],
    ajax: {
      url: "veiculos_all",
      beforeSend: function () {
        $("#lista-veiculos").LoadingOverlay("show", {
          background: "rgba(165, 190, 100, 0.5)",
        });
      },
      complete: function () {
        $("#lista-veiculos").LoadingOverlay("hide");
      },
    },
    columns: [
      {
        data: "descricao",
      },
      {
        data: "potencia",
      },
      {
        data: "combustivel",
      },
      {
        data: "acoes",
      },
    ],
    columnDefs: [
      {
        width: "70px",
        className: "text-center",
        targets: [3],
      },
    ],
  });

  table.on("init", function () {
    table
      .buttons()
      .container()
      .appendTo("#lista-veiculos_wrapper .col-md-6:eq(0)");
  });
});

$("#form_cad_veiculo").on("submit", function (e) {
  e.preventDefault();

  const fabricanteValue = $("#idfabricante").val();
  const combustivelValue = $("#combustivel").val();
  const tipoValue = $("#idtipo").val();

  if (fabricanteValue === "") {
    $("#response").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Selecione o fabricante!" +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        "</button>" +
        "</div>"
    );
    return false;
  } else if (tipoValue === "") {
    $("#response").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Selecione o tipo de veículo" +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        "</button>" +
        "</div>"
    );
    return false;
  } else if (combustivelValue === "") {
    $("#response").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Selecione o tipo de combustível" +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        "</button>" +
        "</div>"
    );
    return false;
  } else {
    let url = "";

    if ($("#form_cad_veiculo").hasClass("insert")) {
      url = "/veiculos/inserir";
    } else if ($("#form_cad_veiculo").hasClass("update")) {
      url = "/veiculos/atualizar";
    }

    $.ajax({
      type: "POST",
      url: url,
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $("#response").html("");
        $("#form_cad_veiculo").LoadingOverlay("show", {
          background: "rgba(165, 190, 100, 0.5)",
        });
      },
      success: function (data) {
        $("[name=csrf_test_name]").val(data.token);

        if (data.info) {
          $("#response").html(
            '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
              data.info +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
              '<span aria-hidden="true">&times;</span>' +
              "</button>" +
              "</div>"
          );
        } else if (data.erro && data.erros_model.modelo) {
          $("#response").html(
            '<div class="text-danger" style="font-size: 13px; margin-top:8px">' +
              data.erros_model.modelo +
              "</div>"
          );
        } else {
          console.log(data);
          //tudo certo na atualização, redirecionar o usuário
          window.location.href = data.redirect_url;
        }
      },
      error: function () {
        alert(
          "Não foi possível concluir a operação, tente novamente mais tarde!"
        );
      },
      complete: function () {
        $("#form_cad_veiculo").LoadingOverlay("hide");
      },
    });
  }
});

function camposObrigatorios() {}

$("#lista-fabricante").on("click", "#fabri", function () {
  const id = $(this).data("id");
  editarFabricante(id);
});

$("#removerFab").on("click", function () {
  const id = $("#codFabricante").val();
  $.ajax({
    url: "fabricantes/excluir/" + id,
    type: "POST",
    dataType: "json",
    beforeSend: function () {
      $("#response").html("");
      $("#mdExcluir").LoadingOverlay("show", {
        background: "rgba(165, 190, 100, 0.5)",
      });
    },
    success: function (data) {
      window.location.href = data.redirect_url;
    },
    error: function () {
      console.log("Erro ao tentar excluir fabricante");
    },
    complete: function () {
      $("#mdExcluir").LoadingOverlay("hide");
    },
  });
});
