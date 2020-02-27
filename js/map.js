$(function(){
    var headerHeight = $('#header').outerHeight();// ナビの高さを取得 
    var windowHeight = $(window).height();// 表示画面の高さを取得
    var H = windowHeight-headerHeight-20;
    $('#mapcontainer').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定  
    $('#navi').css('height', H + 'px');
    $('#main').css('height', H + 'px');
   
});