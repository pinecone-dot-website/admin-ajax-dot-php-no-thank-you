(function ($) {
    "use strict";

    var $debugger = $('#debugger');

    $('form tr').find('td:last').each(function (i) {
        var $link = $('<a>test</a>'),
            $this = $(this);

        $link.click(function () {
            var rand = Math.random();

            $debugger.append('sending request: ' + $this.data('url') + '\n');
            $debugger.append('random number: ' + rand + '\n');

            $.ajax({
                'data': {
                    'action': 'admin-ajax-test',
                    'rand': rand
                },
                'method': 'post',
                'success': function (data) {
                    if (typeof data.post == 'object' && data.post.rand == rand) {
                        $debugger.append('response correct!\n\n');
                    } else {
                        $debugger.append('something is wrong!\n\n');
                    }
                },
                'url': $this.data('url')
            });
        });

        $this.html($link);
    });
})(jQuery);