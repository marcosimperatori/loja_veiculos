$(function () {
  const table = $("#lista-fabricante").DataTable({
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
          $("#novoModal").modal("show");
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
      url: "fabricantes_all",
      beforeSend: function () {
        $("#lista-fabricante").LoadingOverlay("show", {
          background: "rgba(165, 190, 100, 0.5)",
        });
      },
      complete: function () {
        $("#lista-fabricante").LoadingOverlay("hide");
      },
    },
    columns: [
      {
        data: "descricao",
      },
      {
        data: "acoes",
      },
    ],
    columnDefs: [
      {
        width: "70px",
        className: "text-center",
        targets: [1],
      },
    ],
  });

  table.on("init", function () {
    table
      .buttons()
      .container()
      .appendTo("#lista-fabricante_wrapper .col-md-6:eq(0)");
  });
});

$("#cad_fabricante").on("submit", function (e) {
  e.preventDefault();
  let url = "";

  if ($("#cad_fabricante").hasClass("insert")) {
    url = "/fabricantes/criar";
  } else if ($("#cad_fabricante").hasClass("update")) {
    url = "/fabricantes/atualizar";
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
      $("#form_cad_tipo").LoadingOverlay("show", {
        background: "rgba(165, 190, 100, 0.5)",
      });
    },
    success: function (data) {
      $("[name=csrf_test_name]").val(data.token);
      //tudo certo na atualização, redirecionar o usuário
      window.location.href = data.redirect_url;
    },
    error: function () {
      alert(
        "Não foi possível concluir a operação, tente novamente mais tarde!"
      );
    },
    complete: function () {
      $("#cad_fabricante").LoadingOverlay("hide");
    },
  });
});

function editarFabricante(id) {
  // Abrir o modal
  $("#novoModal").modal("show");
  $.ajax({
    url: "/fabricantes/editar/" + id,
    type: "GET",
    dataType: "json",
    beforeSend: function () {
      $("#response").html("");
      $("#novoModal").LoadingOverlay("show", {
        background: "rgba(165, 190, 100, 0.5)",
      });
    },
    success: function (data) {
      $("#fabricante").val(data.fabricante);
      $("#cad_fabricante").removeClass("insert").addClass("update");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(
        "Erro ao buscar os dados do fabricante:",
        textStatus,
        errorThrown
      );
    },
    complete: function () {
      $("#cad_fabricante").removeClass("update").addClass("insert");
      $("#novoModal").LoadingOverlay("hide");
    },
  });
}

$("#lista-fabricante").on("click", "#fabri", function () {
  const id = $(this).data("id");
  editarFabricante(id);
});
