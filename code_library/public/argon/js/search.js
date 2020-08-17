$(window).on('popstate', function(event) {
  url=$(location).attr("href");
  // getPage(url);
  location.reload();
});
function openNav() {
  // document.getElementById("mySidenav").style.width = "100%";
}
function closeNav() {
  // document.getElementById("mySidenav").style.width = "0";
}
$(document).on('click','.deletBtn',function(e){
  if (confirm('Are you sure you want to delete this?')) {
  }else{
    e.preventDefault();
  }
});
$(document).ready(function(){
  // var nxt = parseInt($(this).attr('href').split("page=")[1].match(/^\d*/)+1);
  // var lst = parseInt($(this).attr('href').split("page=")[1].match(/^\d*/)-1);
  // var ths = $(this).attr('href').split("page=")[0] + "page=";
  // if(lst > 0){
  //   $("a.page-link:contains('‹')").attr('href','/' + ths + lst);
  // }
  // if(nxt < $('li .page-link').length - 1){
  //   $("a.page-link:contains('›')").attr('href','/' + ths + nxt);
  // }
});
$(document).on('click','.closNv',function(){
  $('#exp').fadeOut(0);
  $('#mySidenav').width('0');
});

$(document).on('click','.exp',function(){ $('#cod').fadeOut(0);$('#exp').fadeIn(); });
$(document).on('click','.cod',function(){ $('#exp').fadeOut(0);$('#cod').fadeIn(); });

$(document).on('click','.opnv',function(){
  $('#cod').fadeIn();
  var code = $(this).attr("dataCode");
  var expln = $(this).attr("dataEx");
  $('.cd').val(code);
  $('.ex').val(expln);
  $('#mySidenav').width('100%');
});
$(document).on('click','.pagination a', function(e){
  e.preventDefault();
  var nxt = parseInt($(this).attr('href').split("page=")[1].match(/^\d*/)) + 1;
  var lst = parseInt($(this).attr('href').split("page=")[1].match(/^\d*/)) - 1;
  var ths = $(this).attr('href').split("page=")[0] + "page=";
  if(lst > 0){
    $("a.page-link:contains('‹')").attr('href','/' + ths + lst);
  }
  if(nxt < $('li .page-link').length - 1){
    $("a.page-link:contains('›')").attr('href','/' + ths + nxt);
  }
  $('.pagination a').css('background-color','#fff');
  $('.pagination a').css('color','#5e72e4');
  $(this).css('background-color','#5e72e4');
  $(this).css('color','#fff');
  pg=$(this).attr('href').split('page=')[1];
  $('#paginate').val(pg);
  getData();
});

$("a.page-link:contains('‹')").add("a.page-link:contains('›')").on('click',function(){
  // alert();
  // $("a.page-link:contains('‹')").attr('href','/' + ths + lst);
  // $("a.page-link:contains('›')").attr('href','/' + ths + nxt);
});
// $(document).on('click','.jstree-anchor', function(e){
//   e.preventDefault();
//   getData();
// });
$(document).on('submit','#searchform', function(e){
  e.preventDefault();
  getData();
});
function getData(){
  tg=$('#parent').val().replace(/\, /g , ',');
  pg=$('#paginate').val();
  sr=$('#search').val();
  if(sr==''&&tg==''&&pg==''){
    var url = '/search?s=' + sr +'&tg='+ tg +'&page='+ pg;
  }else{
    var url = '/search?s=' + sr +'&tg='+ tg +'&page='+ pg;
    window.history.pushState('object', 'New Title', url);
    $.ajax({
        url: url,
    }).done(function(data){
        $('.searchdata').html(data);
    });
  }
}
$('.maxContainer').on("click",".delete_btn", function(e) {
  e.preventDefault();
  if (confirm('Are you sure you want to delete this?')) {
     $('.done').css('display','none');
     $('.wrong').css('display','none');
     var url= $(this).attr('href');
     var sendId= $(this).attr('sendId');
     $.ajax({
         url: url,
         type: 'get',
         data: {},
         dataType:'JSON',
         contentType: false,
         cache: false,
         processData: false,
         success: function(data) {
             if(data.status==true){
                 $('.wrong').css('display','none');
                 $('.done').css('display','block');
                 $('.done').text(data.msg);
                 $('.allElements .container'+sendId).remove();
             }else{
                 $('.done').css('display','none');
                 $('.wrong').css('display','block');
                 $('.wrong').text(data.msg);
             }
             setTimeout(() => {
                 $('.done').css('display','none');
                 $('.wrong').css('display','none');
             }, 2000);
         },error: function(data) {
             $('.done').css('display','none');
             $('.wrong').css('display','block');
             $('.wrong').text('Some thing wrong, Please try again.');
             setTimeout(() => {
                 $('.done').css('display','none');
                 $('.wrong').css('display','none');
             }, 2000);
         },
     });
  }
 });
