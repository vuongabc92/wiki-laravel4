/**
 *  @name confirmation
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'confirmation';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var element = this.element,
            msg = element.attr('data-msg');

        element.on('click', function(){
            return confirm(msg);
        });


    },
    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    option: 'value'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));


/**
 *  @name kingActive
 *  @description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'kingActive';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var element = this.element,
            url = element.attr('data-activeurl'),
            eParent = element.parent('.active-container');

        element.on('click', function(){
            $.ajax({
                type: 'get',
                url: url,
                success: function(response){
                    if(parseInt(response) === 1){
                        element.text('active');
                        element.removeClass('label-warning');
                        element.addClass('label-success');
                    }
                    if(parseInt(response) === 0){
                        element.text('disable');
                        element.removeClass('label-success');
                        element.addClass('label-warning');
                    }
                }
            });
        });


    },
    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    option: 'value'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));
