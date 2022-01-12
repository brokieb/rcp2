// $(".month-details").click(function () {
//   var przycisk = $(this);
//   $.ajax({
//     type: "GET",
//     url: "ajax/month-details.php",
//     data: {
//       monthe: $(this).data("month"),
//     },
//     dataType: "html",
//     success: function (zmienna) {
//       if (przycisk.siblings(".month-details-content").length) {
//         przycisk.siblings(".month-details-content").remove();
//       } else {
//         przycisk
//           .parent()
//           .append("<div class='month-details-content'>" + zmienna + "</div>");
//       }
//     },
//   });
// });
console.log("A");
$(".select-this-month-details").on('change',function(){
  var przycisk = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/show_this_month_details.php",
    data: {
      month: $(this).val(),
    },
    dataType: "html",
    success: function (zmienna) {
      $(".month-details-table tbody").html(zmienna)
    },
  });
})

$(".accept-record").click(function () {
  var przycisk = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/accept-record.php",
    data: {
      content: $(this).data("json"),
    },
    dataType: "html",
    success: function (zmienna) {
      if ((zmienna = "OK")) {
        przycisk.parent().html("OK");
      }
    },
  });
});

$(".reject-record").click(function () {
  var przycisk = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/reject-record.php",
    data: {
      content: $(this).data("json"),
    },
    dataType: "html",
    success: function (zmienna) {
      if ((zmienna = "OK")) {
        przycisk.parent().html("OK");
      }
    },
  });
});

$(".add-new-address").click(function () {
  var przycisk = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/add-new-address.php",
    data: {
      address: $(this).siblings("input[name='new-address']").val(),
    },
    dataType: "html",
    success: function (zmienna) {
      if (zmienna == "BLAD") {
        przycisk
          .animate({
            backgroundColor: "red",
          })
          .delay("100")
          .animate({
            backgroundColor: "initial",
          });
      } else {
        przycisk
          .closest("tr")
          .before("<tr><td></td><td>" + zmienna + "</td><td></td></tr>");
      }
    },
  });
});

const exampleModal = document.getElementById('exampleModal');
exampleModal.addEventListener('show.mdb.modal', (event) => {
  const button = event.relatedTarget
  const imie = button.getAttribute('data-imie')
  $.ajax({
    type: "GET",
    url: "ajax/user-details.php",
    data: {
      id: button.getAttribute('data-id'),
    },
    dataType: "html",
    success: function (zmienna) {
      $(".modal-header").html("Szczegóły pracownika "+imie)
      $(".modal-body").html(zmienna)
load_js("user_details_js");
load_js("main_js");
document.querySelectorAll(".modal-content .form-outline").forEach((formOutline) => {
  new mdb.Input(formOutline).init();
});


    },
  });
})


$(".add-time button").click(function () {
  var area = $(this);
  if ($(this).parents(".add-time").find("input[name='minus']").is(":checked")) {
    var ans = 0;
  } else {
    var ans = 1;
  }
  $.ajax({
    type: "GET",
    url: "ajax/add-hours.php",
    data: {
      czas: $(this).parents(".add-time").find("input[name='added-time']").val(),
      accept_id: $(this).parents(".add-time").find("input[name='accept-id']").val(),
      znak: ans,
    },
    dataType: "html",
    success: function (zmienna) {

      if ((zmienna = "OK")) {
        area
          .closest("tr")
          .css("overflow", "hidden")
          .animate(
            {
              backgroundColor: "Lime",
            },
            {
              complete: function () {
                $(this).remove();
              },
            }
          );
      }
    },
  });
});

$(".show-comment-form").click(function () {

  var a = $(this).siblings("input");

  if ($(this).siblings("input").length > 0) {
    var a = $(this).siblings("input").val();
    var prev = $(this).siblings("input").data("val");
    var i = 0;
    $(this)
      .closest("td")
      .find("i")
      .each(function () {
        if ($(this).text() == a) {
          i = 1;
        }
      });

    if (i == 0 && prev != a) {
      $(this)
        .siblings("input")
        .replaceWith("<i>" + a + "</i>");
      var text = $(this).siblings("i").text();
      $.ajax({
        type: "GET",
        url: "ajax/add-comment.php",
        data: {
          comment:
            "<i>U#" +
            $("input[name=session_id]").val() +
            " : " +
            text +
            "</i>",
          record_id: $(this).data("id"),
        },
        dataType: "html",
        success: function (zmienna) {

          if ((zmienna = "OK")) {
            $(this).closest("td").css("background", "red");
          }
        },
      });
    } else {
    }
  } else {
    if ($(this).siblings("i").text().length > 0) {
      $(this).before(
        "<input type='text' data-val='" +
          $(this).siblings("i").text() +
          "' autocomplete='off' name='comment' value='" +
          $(this).siblings("i").text() +
          "'>"
      );
    } else {
      $(this).before(
        "<input type='text' data-val='.' autocomplete='off' name='comment' value='" +
          $(this).siblings("i").text() +
          "'>"
      );
    }

    $(this).siblings("i").remove();
  }
});

$(".set-config").click(function(){

  var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/change-config.php",
    data: {
      id: $(this).siblings("input[name=status]").val(),
      new: $(this).siblings("input[name=new]").val()
    },
    dataType: "json",
    success: function (zmienna) {
      if(zmienna['ans']==1){
        btn.html("OK!");
      }
    },
  });

})

$(".remove-address").click(function () {
  var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/remove-address.php",
    data: {
      id: $(this).data("id"),
    },
    dataType: "html",
    success: function (zmienna) {
      btn.closest("tr").animate(
        {
          backgroundColor: "lime",
        },
        {
          complete: function () {
            $(this).remove();
          },
        }
      );
    },
  });
});


$(".repair-day").click(function(){

  var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/repair-day.php",
    data: {
      id: $(this).data("id"),
      date: $(this).data("date"),
      praca:$(this).data("praca"),
      przerwa:$(this).data("przerwa"),
      magazyn:$(this).data("magazyn"),
      time:$(this).data("last-time")
    },
    dataType: "html",
    success: function (zmienna) {
     btn.closest("tr").animate(
      {
        backgroundColor: "lime",
      },
      {
        complete: function () {
          $(this).remove();
        },
      }
    );
    },
  });

})

$(".add-comment").click(function(){
  var przycisk = $(this);
  $.ajax({
      type: "GET",
      url: "ajax/add-comment.php",
      data: {
          "record_id": $(this).data('record-id'),
          "comment": $(this).siblings("input").val()
      },
      dataType: "html",
      success: function (zmienna) {
          console.log(zmienna);
          if(zmienna="OK"){
              
              przycisk.css('background','green');
          }else{
              przycisk.css('background','red');
          }
      }
  });

})

$("#accept-zest").on('submit',function(e){
  e.preventDefault();
  var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/accept-zest.php",
    data: {
      code: $(this).find('input[name="zest-accept"]').val()
    },
    dataType: "json",
    success: function (zmienna) {
      console.log(zmienna);
     if(zmienna['ans']==0){
       btn.find(".alert-section").html("<div class='alert alert-dismissible fade show alert-danger' role='alert'>Nieprawidłowy kod ;(<button type='button' class='btn-close' data-mdb-dismiss='alert' aria-label='Close'></button></div>");
     }else{
       alert("potwierdzono!");
       btn.closest("section").remove();
     }
    },
  });
})