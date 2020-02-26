$(function(){
    var ua = navigator.userAgent;
    var windowWidth = $(window).width();//表示画面の幅を取得
    var headerHeight = $('#header').outerHeight();// ナビの高さを取得
    var footerHeight = $('#end').outerHeight();// 高さを取得  
    var windowHeight = $(window).height();// 表示画面の高さを取得
    var H = windowHeight - headerHeight - footerHeight;
    if ((ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0) && ua.indexOf('Mobile') > 0) {
        // 
        $('#right1,#left1').css('left', windowWidth/3 + 'px');
        $('#header').css('height', '100px');
        $('#right1').css('top', 3*H/10 + 'px');
        $('#left1').css('top', 6*H/10 + 'px');
        $('#right1,#left1').css('width','300px');
        $('#right1,#left1').css('height','175px');
        $('.p').css('padding-top','30px');
    }else {
        // PC用処理
        $('body1').css('width', windowWidth + 'px');
        $('#left').css('width', windowWidth/2 + 'px');
        $('#right').css('width', windowWidth/2 + 'px');
        $('#left1').css('left', windowWidth/4 - 140 + 'px');
        $('#right1').css('left', windowWidth/2 + windowWidth/4 - 140 + 'px');

        $('#left').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
        $('#right').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定
        $('#right1,#left1').css('top', H/3 + 'px');
        $('#right1,#left1').css('width','240px');
        $('#right1,#left1').css('height','125px');

        $('#header img').css('padding', '10px');
    }
    $('#main').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定

 
    
   
});