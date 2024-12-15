$(function(){
 $('.sub_menu').hide();
 $('.main_menu').click(function(){
  $('ul.sub_menu').slideUp();
  $('.main_menu').removeClass('open');
  if($('+ul.sub_menu',this).css('display') == 'none'){
   $('+ul.sub_menu',this).slideDown();
   $(this).addClass('open');
  }
 });
});
