  
var Infscroll = (function() {

  var infscroll = {};
  var after;
  var lastPage = false;
  var oktoScroll = true;
  var viewportHeight;
  var lastScroll=0;
  var $navSelector, $container, itemSelector;

  infscroll.init = function(opts){
    after = opts.after
    navSelector = opts.navSelector
    loader = opts.loader
    containerSelector = opts.containerSelector
    totalPages = opts.totalPages
    itemSelector = opts.itemSelector

    $container = $(containerSelector)
    $nav = $(navSelector)
    viewportHeight = $(window).height()
    lastPage = false;
    oktoScroll=true;
    lastScroll=0;
  }

  $(window).on('resize',function(){
    viewportHeight = $(window).height()
  })


  $(window).scroll(function(e) {


    var scrolled = $(document).scrollTop();

    if(Math.abs(lastScroll-scrolled)< 300 + 200)
      return;

    /* INFINITE SCROLL*/

    docHeight = $(document).height();

    if (viewportHeight + scrolled + 300 > docHeight && oktoScroll) {

      oktoScroll = false;
      lastScroll = scrolled;

      console.log('bla')

      $nav = $(navSelector)

      // var container = $('.gridContainer');
      var totalPageCount = $nav.attr('data-pages');
      var requestUrl = $nav.attr('data-url');

      if (lastPage) {
        loader.hide().removeClass('active');
        return;
      }

      if(!requestUrl){
        lastPage = true;
        loader.hide().removeClass('active');
        return;
      }
      // if ($('#nextPage').length) {

      loader.show().addClass('active');

      setTimeout( function(){
        ajax(requestUrl)
      }, 300);
      
    }
  });

  var ajax = function(requestUrl){
    $.ajax({
        url: requestUrl,
        type: 'get',
        dataType: 'html',
        success: function(data) {

          var $data = $(data);
          var next = $data.find(navSelector);
          var items = $data.find(containerSelector).children(itemSelector);

          if(!items[0]){
            lastPage = true;
            loader.hide().removeClass('active');
            return;
          }


          $container.append(items);

          after(items);

          $nav.replaceWith(next);
          loader.hide().removeClass('active');
          oktoScroll = true;

        },
        error: function() {
          loader.hide().removeClass('active');
          oktoScroll = true;
          lastPage = true;
        }
      });
  }

  return infscroll;

})()