(function ($) {
    "use strict";

    var $debugger = $('#debugger');
    $debugger.after($('<a>clear</a>').click(function () {
        $debugger.html('');
    }));

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
                'error': function (data) {
                    ajax_test_error()
                },
                'method': 'post',
                'success': function (data) {
                    if (typeof data.post == 'object' && data.post.rand == rand) {
                        ajax_test_success();
                    } else {
                        ajax_test_error();
                    }
                },
                'url': $this.data('url')
            });
        });

        $this.html($link);
    });

    function ajax_test_error() {
        $debugger.append('something is wrong!\n\n');
    }

    function ajax_test_success() {
        $debugger.append('response correct!\n\n');
    }
})(jQuery);