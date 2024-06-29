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
      url: "manutencao_all",
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
        data: "data",
      },
      {
        data: "veiculo",
      },
      {
        data: "tipo",
      },
      {
        data: "servico",
      },
      {
        data: "acoes",
      },
    ],
    columnDefs: [
      {
        width: "90px",
        type: "date",
        targets: [0],
        render: function (data, type, row) {
          // Renderizar a data no formato "YYYY-MM-DD" para ordenação
          if (type === "sort" || type === "type") {
            return data.replace(/(\d{2})\/(\d{2})\/(\d{4})/, "$3-$2-$1");
          }
          return data;
        },
      },
      {
        width: "270px",
        targets: [1],
      },
      {
        width: "100px",
        className: "text-left",
        targets: [2],
      },
      {
        width: "70px",
        className: "text-center",
        targets: [4],
      },
    ],
    order: [[0, "desc"]],
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
      '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
        "Selecione o <strong>VEÍCULO</strong>" +
        "</div>"
    );
    $("#novoModal").modal("show");
    return false;
  } else if (tipoValue === "") {
    $("#msg-modal").html(
      '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
        "Selecione o <strong>TIPO DE MANUTENÇÃO</strong> realizada" +
        "</div>"
    );
    $("#novoModal").modal("show");
    return false;
  } else if (dataCompra === "") {
    $("#msg-modal").html(
      '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
        "Informe a <strong>DATA DO SERVIÇO</strong>" +
        "</div>"
    );
    $("#novoModal").modal("show");
    return false;
  } else if (valorCompra === "" || isZero) {
    $("#msg-modal").html(
      '<div class="alert alert-info alert-dismissible fade show" role="alert">' +
        "Informe o <strong>VALOR DA MANUTENÇÃO</strong> ou preencha-o com valor diferente de zero" +
        "</div>"
    );
    $("#novoModal").modal("show");
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
              '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                data.erros_data +
                "</div>"
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
