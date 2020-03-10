jQuery(function($){
  $(function() {
    $('.pz-lkc-tab').on('click', function() {
      $('.pz-lkc-item').removeClass("pz-lkc-item-active");
      $($(this).attr("href")).addClass("pz-lkc-item-active");
      $('.pz-lkc-tab').removeClass('pz-lkc-tab-active');
      $(this).addClass('pz-lkc-tab-active');
      return false;
    });
  });
});
