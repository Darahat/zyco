/* Simple Color Picker JS */
(function($) {
    $.fn.colorpicker = function(options) {
        var settings = $.extend({
            colors: ['#000000', '#FFFFFF', '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF'],
            onSelect: function(color) {}
        }, options);

        return this.each(function() {
            var $input = $(this);
            var $picker = $('<div class="colorpicker"></div>');
            
            $.each(settings.colors, function(i, color) {
                var $color = $('<div class="colorpicker-color"></div>');
                $color.css('background-color', color);
                $color.on('click', function() {
                    $input.val(color);
                    settings.onSelect(color);
                    $picker.hide();
                });
                $picker.append($color);
            });
            
            $input.after($picker);
            $picker.hide();
            
            $input.on('focus', function() {
                $picker.show();
            });
        });
    };
})(jQuery);
