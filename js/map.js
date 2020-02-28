$(function(){
    var headerHeight = $('#header').outerHeight();// ナビの高さを取得 
    var windowHeight = $(window).height();// 表示画面の高さを取得
    var H = windowHeight-headerHeight-20;
    $('#mapcontainer').css('height', H + 'px');// 算出した差分をヘッダーエリアの高さに指定  
    $('#main').css('height', H + 'px');
    if ((ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0) && ua.indexOf('Mobile') > 0) {
        // 
        toggleNav();
        
    }else {
        // PC用処理
        $('#navi').css('height', H + 'px');
        $('#navi').css('width', '15%');
    }
    
});


    /* SP menu */
    function toggleNav() {
    var body = document.body;
    var hamburger = document.getElementById('nav_btn');
    var blackBg = document.getElementById('nav_bg');
   
    hamburger.addEventListener('click', function() {
      body.classList.toggle('nav_open'); //メニュークリックでnav-openというクラスがbodyに付与
    });
    blackBg.addEventListener('click', function() {
      body.classList.remove('nav_open'); //もう一度クリックで解除
    });
  }
