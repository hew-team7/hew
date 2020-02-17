$(function(){
    var windowWidth = $(window).width();//表示画面の幅を取得
    $('body').css('width', windowWidth + 'px');
    $('#left').css('width', windowWidth/2 + 'px');
    $('#right').css('width', windowWidth/2 + 'px');
    $('#right').css('margin-left', windowWidth/2 + 'px');


    var headerHeight = $('#header').outerHeight();// ナビの高さを取得
    var footerHeight = $('#end').outerHeight();// 高さを取得  
    var windowHeight = $(window).height();// 表示画面の高さを取得
    var H = windowHeight - headerHeight - footerHeight;
    $('#main').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
    $('#left').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
    $('#right').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
    
 
    
   
});