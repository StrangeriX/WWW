window.onload = function() {
    $("#content").load("home.html");
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })   
      
}

$("a").click(function(e) {
    var ten = $(this);
    var href = ten.attr('href')
    $("#content").load(href);
    e.preventDefault();
    
});

