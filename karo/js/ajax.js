$(".nav-list a").click(function(){
      var btn = $(this);
      console.log("ASD");
      $.ajax({
        type: "GET",
        url: "ajax/"+btn.attr('id')+".php",
        dataType: "html",
        success: function (zmienna) {
            $("#content").html(zmienna);
        },
      });
});

$(".this-service").click(function(){
  var btn = $(this);
  $.ajax({
    type: "GET",
    url: "ajax/this-service-details.php",
    data: {
      instance: $(this).data("instance"),
    },
    dataType: "html",
    success: function (zmienna) {
      $("#content").html(zmienna);
    },
  });
})