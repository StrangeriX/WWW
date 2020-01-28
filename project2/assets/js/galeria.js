$(document).ready(function(){
  var currentImg = $('.active');
  var comment = $('#comment')
  comment.text(currentImg.attr('alt'));
  $('.next').on('click', function(){
    var currentImg = $('.active');
    var nextImg = currentImg.next();

    var comment = $('#comment')
    comment.text(currentImg.attr('alt'));

    if(nextImg.length){
      currentImg.removeClass('active').css('z-index', -10);
      nextImg.addClass('active').css('z-index', 10);
    }
  });

  $('.prev').on('click', function(){
    var currentImg = $('.active');
    var prevImg = currentImg.prev();
    var comment = $('#comment')
    comment.text(currentImg.attr('alt'));
    
    if(prevImg.length){
      currentImg.removeClass('active').css('z-index', -10);
      prevImg.addClass('active').css('z-index', 10);
    }
  });
});