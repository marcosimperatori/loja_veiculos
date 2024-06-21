$(function () {
  const table = $("#lista-estoque").DataTable({
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
          window.location.href = "/estoque/criar";
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
      url: "estoque_all",
      beforeSend: function () {
        $("#lista-estoque").LoadingOverlay("show", {
          background: "rgba(165, 190, 100, 0.5)",
        });
      },
      complete: function () {
        $("#lista-estoque").LoadingOverlay("hide");
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
      .appendTo("#lista-estoque_wrapper .col-md-6:eq(0)");
  });
});

$("#form_cad_estoque").on("submit", function (e) {
  e.preventDefault();
  let url = "";

  if ($("#form_cad_estoque").hasClass("insert")) {
    url = "/estoque/inserir";
  } else if ($("#form_cad_estoque").hasClass("update")) {
    url = "/estoque/atualizar";
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
      $("#form_cad_estoque").LoadingOverlay("show", {
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
      } else if (data.erro && data.erros_model.nome) {
        $("#response").html(
          '<div class="text-danger" style="font-size: 13px; margin-top:8px">' +
            data.erros_model.nome +
            "</div>"
        );
      } else if (data.erro) {
        alert("Existe erro de validação: " + data.erros_model);
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
      $("#form_cad_estoque").LoadingOverlay("hide");
    },
  });
});

function camposObrigatorios() {}

$("#lista-fabricante").on("click", "#fabri", function () {
  const id = $(this).data("id");
  editarFabricante(id);
});
