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
                        element.removeClass('label-danger');
                        element.addClass('label-success');
                    }
                    if(parseInt(response) === 0){
                        element.text('disable');
                        element.removeClass('label-success');
                        element.addClass('label-danger');
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


/**
 *  @name filehidden
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
  var pluginName = 'filehidden';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var that = this,
            element = this.element,
            idName = element.attr('data-filehiddenid'),
            id = $('#' + idName),
            clsNameError = element.attr('data-filehiddenerror'),
            clsError = $('.' + clsNameError),
            errorTxt = element.attr('data-filehiddenerrortxt'),
            ext = element.attr('data-ext'),
            filePathSplit = '',
            fileExt = '';

        element.on('click', function(){
            id.click();
        });

        id.on('change', function(){
            filePathSplit = id.val();
            filePathSplit = filePathSplit.split('.');
            fileExt = filePathSplit[filePathSplit.length - 1];
            var extArr = ext.split('|');
            if(that.checkExist(fileExt, extArr) === false){
                clsError.addClass('text text-danger');
                clsError.removeClass('_tg');
                clsError.html(errorTxt);
            }else{
                clsError.removeClass('text-danger');
                clsError.addClass('text-success');
                clsError.html('<i class="fa fa-image"></i> ' + id.val())
            }
        });

    },
    checkExist: function(ext, arrExt){
        for(var i = 0; i < arrExt.length; i++){
            if(arrExt[i] === ext){
                return true;
            }
        }
        return false;
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
 *  @name filter
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
  var pluginName = 'filter';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var element = this.element,
            classContain = $('.' + element.attr('data-filter-class')),
            aTag = (element.children('li')).children('a');

            aTag.on('click', function(e){
                classContain.html($(this).text().trim());
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
 *  @name checkall
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
  var pluginName = 'checkall';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var element = this.element,
            checkAllClass = $('.' + element.attr('data-checkallclass'));
            element.on('click', function(){

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
 *  @name categoryonefilterroot
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
  var pluginName = 'categoryonefilterroot';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var element = this.element,
            categoryOneId = $('#' + element.attr('data-categoryoneid')),
            categoryOneParent = categoryOneId.parent('div'),
            url = element.attr('data-categoryonefilterrooturl');

        element.on('change', function(){
            if($(this).val() !== ''){
                $.ajax({
                    type: 'get',
                    url: url + '/' + element.val(),
                    beforeSend: function(){
                        $('.loading').show();
                    },
                    success: function(response){
                        categoryOneParent.html(response);
                        $('.loading').hide();
                    }
                });
            }
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
 *  @name categorytwofilterone
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
  var pluginName = 'categorytwofilterone';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
        var element = this.element,
            categoryTwoId = $('#' + element.attr('data-categorytwoid')),
            categoryTwoParent = categoryTwoId.parent('div'),
            url = element.attr('data-categorytwofilteroneurl');

            $(document.body).on('change', '#' + element.attr('id') ,function(){
                var categoryTwoId = $('#' + element.attr('id')).val();
                if($(this).val() !== ''){
                    $.ajax({
                        type: 'get',
                        url: url + '/' + categoryTwoId,
                        beforeSend: function(){
                            $('.loading').show();
                        },
                        success: function(response){
                            categoryTwoParent.html(response);
                            $('.loading').hide();
                        }
                    });
                }
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