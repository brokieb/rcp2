dt = new Date();
datetext = dt.toTimeString();
datetext = datetext.split(" ")[0];
$(".time").text(datetext);

function load_js(id) {
  var id_val = $("#" + id).attr("id");
  var src = $("#" + id).attr("src");
  $( id).remove();
  console.log(id,id_val,src);
  // console.log(id_val);
  var script = document.createElement("script");
  script.id = id_val;
  script.src = src;
  $(".styles").append(script);
}

$(".hide-content").click(function(){
  $(".hide-me").each(function(){
    $(this).hide();
  })
  $("form").addClass("w-100");
})
// $(document).ready(function () {
//   $(window).keydown(function (event) {
//     if (event.keyCode == 13) {
//       event.preventDefault();
//       return false;
//     }
//   });
// });

setInterval(function () {
  dt = new Date();
  datetext = dt.toTimeString();
  datetext = datetext.split(" ")[0];
  $(".time").text(datetext);
}, 1000);
$(".menu-toggle").click(function () {
  $(".slidingMenu").stop(true, true).toggle("slide");
  if ($("main").css("overflow") == "hidden") {
    $("main").css({ overflow: "initial" });
  } else {
    $("main").css({ overflow: "hidden" });
  }
});

$("main").click(function () {
  if ($(".slidingMenu").css("display") == "block") {
    $(".slidingMenu").toggle("slide");
    $("main").css({ overflow: "initial" });
  }
});

$(".group-toggle").hover(function () {
  $(this).children("ul").stop().slideDown("fast");
});
$(".group-toggle").mouseleave(function () {
  $(this).children("ul").stop().slideUp("fast");
});

$("input[name=added-time]").on("change", function () {
  a = $(this).val().split(":");
  h = a[0];
  m = a[1];
  b =
    "2010-04-14 " +
    $(this).parents("tr").find(".saved-time").data("time") +
    ":00";
  if ($(this).parents("td").find("input[name='minus']").is(":checked")) {
    $(this)
      .parents("tr")
      .find(".saved-time span")
      .html(moment(b).subtract({ minutes: m, hours: h }).format("HH:mm"));
  } else {
    $(this)
      .parents("tr")
      .find(".saved-time span")
      .html(moment(b).add({ minutes: m, hours: h }).format("HH:mm"));
  }
  // console.log(a,b);
  // console.log("H:",a.split(":")[1])
});

console.log($("section").length);
if (
  $(window).width() > 1200 &&
  $("section").length > 1 &&
  !$("section").hasClass("noMasonry")
) {
  $("section").addClass("masonry");
  $("main").masonry({
    // set itemSelector so .grid-sizer is not used in layout
    itemSelector: "section",
    // use element for option
    columnWidth: "section",
    fitWidth: true,
  });
}
if ($("input[name='user-desc']").length > 0) {
  $.ajax({
    type: "GET",
    url: "ajax/user-details.php",
    data: {
      id: $("input[name='user-desc']").val(),
    },
    dataType: "html",
    success: function (zmienna) {
      console.log(zmienna);
      if (zmienna.includes("BLADAX111") === false) {
        $(".modal-header").html("Szczegóły pracownika ");
        $(".modal-body").html(zmienna);
      }
    },
  });
}

$(".all-export").change(function () {
  if ($(".all-export:checked").length) {
    $(".this-export").each(function () {
      $(this).prop("checked", true);
    });
  } else {
    $(".this-export").each(function () {
      $(this).prop("checked", false);
    });
  }
});
