/* Merchants page JS: loads merchant list via AJAX */
(function(window, $){
  'use strict';

  // Safe console
  var log = (window.console && console.log) ? function(){ try{ console.log.apply(console, arguments); }catch(e){} } : function(){};

  // Build post data with safe defaults
  function buildPostData(page){
    page = page || 1;

    // Read current UI selections if present; else defaults
    var filter = '';
    try {
      var $activeFilter = $('.tab-filter.btn-success');
      if ($activeFilter.length) filter = $activeFilter.attr('id') || '';
    } catch(e){}

    var sort = 'all';
    try {
      var s = $('#record_sort_by').val();
      if (s && s.length) sort = s;
    } catch(e){}

    var type = 'all';
    try {
      var t = $('#record_sort_by_type').val();
      if (t && t.length) type = t;
    } catch(e){}

    var perpage = 20;
    try {
      var p = parseInt($('#perpage').val(), 10);
      if (!isNaN(p) && p > 0) perpage = p;
    } catch(e){}

    var data = {
      action: 'dataList',
      library: 'merchant',
      result_type: 'filter',
      filter: filter,
      sort: sort,
      type: type,
      search_key: '',
      perpage: perpage,
      page: page
    };

    return data;
  }

  // Public: requestMerchantsList
  window.requestMerchantsList = function(page){
    var $container = $('#display_records');
    if (!$container.length) { return; }

    var postData = buildPostData(page);

    // Loading state
    $container.html('<div class="text-info"><i class="fa fa-refresh fa-spin"></i> Please Wait! Records Loading...</div>');

    $.ajax({
      type: 'POST',
      url: 'ajax_request/data_actions.php',
      data: postData,
      success: function(html){
        try {
          // Server returns rendered HTML list via include of merchant_list.php
          $container.html(html);
        } catch (e) {
          log('render error', e);
          $container.html('<div class="alert alert-danger">Failed to render records.</div>');
        }
      },
      error: function(xhr){
        log('ajax error', xhr && xhr.status, xhr && xhr.responseText);
        $container.html('<div class="alert alert-danger">Unable to load records. Please try again.</div>');
      }
    });
  };

})(window, jQuery);
