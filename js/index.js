$(function(){
    var windowWidth = $(window).width();//表示画面の幅を取得
    $('body1').css('width', windowWidth + 'px');
    $('#left').css('width', windowWidth/2 + 'px');
    $('#right').css('width', windowWidth/2 + 'px');
    $('#left1').css('left', windowWidth/4 - 140 + 'px');
    $('#right1').css('left', windowWidth/2 + windowWidth/4 - 140 + 'px');


    var headerHeight = $('#header').outerHeight();// ナビの高さを取得
    var footerHeight = $('#end').outerHeight();// 高さを取得  
    var windowHeight = $(window).height();// 表示画面の高さを取得
    var H = windowHeight - headerHeight - footerHeight;
    $('#main').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
    $('#left').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
    $('#right').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
    $('#right1,#left1').css('top', H/3 + 'px');
 
    
   
});