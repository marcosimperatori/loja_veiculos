$(function () {
  const table = $("#lista-manutencao").DataTable({
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
          window.location.href = "/manutencao/criar";
        },
        className: "bg-gradient-primary",
      },
      {
        extend: "print",
        text: "Imprimir",
      },
    ],
    ajax: {
      url: "estoque_all",
      beforeSend: function () {
        $("#lista-manutencao").LoadingOverlay("show", {
          background: "rgba(165, 190, 100, 0.5)",
        });
      },
      complete: function () {
        $("#lista-manutencao").LoadingOverlay("hide");
      },
    },
    columns: [
      {
        data: "nome",
      },
      {
        data: "ano",
      },
      {
        data: "motor",
      },
      {
        data: "acoes",
      },
    ],
    columnDefs: [
      {
        width: "80px",
        className: "text-left",
        targets: [1],
      },
      {
        width: "70px",
        className: "text-center",
        targets: [2],
      },
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
      .appendTo("#lista-manutencao_wrapper .col-md-6:eq(0)");
  });
});

$("#form_cad_manutencao").on("submit", function (e) {
  e.preventDefault();

  const veiculoValue = $("#idestoque").val();
  const tipoValue = $("#idtipomanut").val();
  const dataCompra = $("#data_manu").val();
  const valorCompra = $("#preco").val();
  const isZero =
    /^0+([,.]0+)?$/.test(valorCompra) ||
    /^0+([.,]\d+)+[,.]0+$/.test(valorCompra);

  if (veiculoValue === "") {
    $("#msg-modal").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Selecione o veículo!" +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        "</button>" +
        "</div>"
    );
    $("#novoModal").modal("show");
    return false;
  } else if (tipoValue === "") {
    $("#msg-modal").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Selecione o tipo de manutenção realizada" +
        "</div>"
    );
    $("#novoModal").modal("show");
    return false;
  } else if (dataCompra === "") {
    $("#response").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Informe a data do serviço" +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        "</button>" +
        "</div>"
    );
    return false;
  } else if (valorCompra === "" || isZero) {
    $("#response").html(
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
        "Informe o VALOR DA MANUTENÇÃO ou preencha-o com valor diferente de zero" +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        "</button>" +
        "</div>"
    );
    return false;
  } else {
    let url = "";

    if ($("#form_cad_manutencao").hasClass("insert")) {
      url = "/manutencao/inserir";
    } else if ($("#form_cad_manutencao").hasClass("update")) {
      url = "/manutencao/atualizar";
    }
    console.log(url);

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
        $("#msg-modal").html("");
        $("#form_cad_manutencao").LoadingOverlay("show", {
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
        } else if (data.erro) {
          if (data.erros_data) {
            $("#msg-modal").html(
              '<div class="text-danger" style="font-size: 13px; margin-top:8px"><p>' +
                data.erros_data +
                "</p></div>"
            );
            $("#novoModal").modal("show");
          } else {
            alert("Existe erro de validação: " + data.erros_model);
          }
        } else {
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
        $("#form_cad_manutencao").LoadingOverlay("hide");
      },
    });
  }
});

function camposObrigatorios() {}

$("#lista-fabricante").on("click", "#fabri", function () {
  const id = $(this).data("id");
  editarFabricante(id);
});
