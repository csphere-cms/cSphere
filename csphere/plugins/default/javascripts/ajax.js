function csphere_ajax_loading(place) {

    // Show a spinner
    $(place).html('<i class="fa fa-spinner fa-spin"></i>');
}

function csphere_ajax_debug(place) {

    // Update debug toolbar request type and request place
    $('#debug_request_selector').attr('data-content', place);
    $('#debug_request_type').html('AJAX');
}

function csphere_ajax_highlight(place, html) {

    // Apply a smooth fade-in effect
    $(place).hide();
    $(place).html(html);
    $(place).fadeIn(500);
}

function csphere_ajax_error(target, status, error) {

    // Message with error details
    var msg = "Status: " + status
            + "\n\nError: " + error
            + "\n\nTarget: " + target;

    alert(msg);
}

function csphere_ajax_hash(url) {

    // Get cleaned url after first slash
    var parts = url.split('#');
    var hash  = url.replace(parts[0], '');
    hash      = hash.replace('#', '');

    return hash;
}

function csphere_ajax_target(hash) {

    // Get local target and append xhr param
    var target = hash.replace(/\/$/, '');
    target     = target.split('?')[0];

    // Convert to classic url
    var parts  = target.split('/');
    var all    = parts.length;
    var concat = '';

    if (all > 0) {

        concat += '?plugin=' + parts[0];

        if (typeof parts[1] != 'undefined' && parts[1] != '') {

            concat += '&action=' + parts[1];
        }

        for (var i=2; i<all; i++) {

            concat += '&' + parts[i] + '=' + parts[(i+1)];
            i++;
        }

        concat += '&xhr=1';
    }
    else {

        concat += '?xhr=1';
    }

    // Search for dirname in source and guess it otherwise
    var dir = $('input[name="csphere_dir"]').attr('value');

    if (typeof dir == 'undefined') {

        var href = $(location).attr('href').split('#')[0];
        dir      = href.split('?')[0];
    }

    var url = dir.replace(/\/$/, '');
    target  = url + '/' + concat;

    return target;
}

function csphere_ajax_get(hash, place) {

    // Set loading indicator
    csphere_ajax_loading(place);

    // Append xhr param and improve target string
    var target = csphere_ajax_target(hash);

    // Send ajax request
    $.ajax({
        cache:    true,
        dataType: 'json',
        url:      target
    })
    .done(function(result) {

       csphere_ajax_update(result, place);
    })
    .fail(function(jqXHR, status, error) {

        csphere_ajax_error(target, status, error);
    });
}

function csphere_ajax_post(hash, formdata, place) {

    // Set loading indicator
    csphere_ajax_loading(place);

    // Append xhr param and improve target string
    var target = csphere_ajax_target(hash);

    // Send form
    $.ajax({
        url:  target,
        type: 'post',
        data: formdata
    })
    .done(function(result) {

        // Update html content parts
        csphere_ajax_update(result, place);
    })
    .fail(function(jqXHR, status, error) {

        csphere_ajax_error(target, status, error);
    });
}

function csphere_ajax_update(result, place) {

    // Update debug
    csphere_ajax_highlight('div#debug-navigation', result.debug);

    csphere_ajax_debug(place);

    // Check for box only mode
    if (result.hasOwnProperty('box')) {

        csphere_ajax_highlight(place, result.box);

    } else {

        // Update title
        $(document).attr('title', result.title);

        // Update stylesheets
        if (result.hasOwnProperty('stylesheets')) {

            jQuery.each(result.stylesheets , function(i, file) {

                if (!$('link[href="' + file + '"]').length) {

                    // Set href last for better browser compatibility
                    $('<link>').appendTo($('head'))
                        .attr('type', 'text/css')
                        .attr('rel', 'stylesheet')
                        .attr('href', file);

                        console.log('AJAX style loaded');
                }
            });
        }

        // Update javascripts
        if (result.hasOwnProperty('javascripts')) {

            jQuery.each( result.javascripts, function(i, file) {

                if (!$('script[src="' + file + '"]').length) {

                    $.ajax({
                        cache:    true,
                        dataType: 'script',
                        url:      file
                    })
                    .done(function() {

                        console.log('AJAX script loaded');
                    })
                    .fail(function(jqXHR, status, error) {

                        csphere_ajax_error(file, status, error);
                    });
                }
            });
        }

        // Update boxes
        if (result.hasOwnProperty('boxes')) {

            jQuery.each( result.boxes, function(name, content) {

                $('div.' + name).html(content);

            });
        }

        // Update content
        csphere_ajax_highlight(place, result.content);
    }

    // Init javascript functions that need to be refreshed
    csphere_ajax_ready();
}

function csphere_ajax_refresh() {

    // Get target url
    var target = $(location).attr('hash').replace('#', '');

    // Check for empty request and skip
    if (target != '' && csphere_ajax_refresh.skip != true) {

        csphere_ajax_get(target, 'div#csphere_content');
    }
}

function csphere_ajax_link(href) {

    // Get target after first hash tag
    var start  = href.split('#')[0];
    var target = csphere_ajax_hash(href);
    var hash   = '#' + target;

    // Detect problems with get params and url rewrites
    var path   = $(location).attr('pathname');
    var search = $(location).attr('search');

    if ((start != path) || (search != '')) {

        // Redirect to real path on problems
        var msg = 'Invalid URL - Performing redirect';

        alert(msg);

        window.location.replace(href);
    }
    else if($(location).attr('hash') == hash) {

        // Force reload if hash stays the same
        csphere_ajax_refresh();
    }
    else {

        // Update browser url to trigger hashchange event
        $(location).attr('hash', target);
    }
}

function csphere_ajax_box_get(plugin, box, params) {

    // Send GET request to box only
    var place = 'div.box_' + plugin + '_' + box;
    var target = plugin + '//box/' + box + '/' + params;

    csphere_ajax_get(target, place);
}

function csphere_ajax_box_post(plugin, box, params) {

    // Send POST request to box only
    var place    = 'div.box_' + plugin + '_' + box;
    var target   = plugin + '//box/' + box + '/' + params;
    var formdata = $(place).find('form').serialize();

    csphere_ajax_post(target, formdata, place);
}

function csphere_ajax_full() {

    // Ajax content for initial request
    csphere_ajax_refresh.skip = false;
    csphere_ajax_refresh();

    // Load ajax content on hash changes, e.g. history button in browser
    $(window).on('hashchange', function() {

        csphere_ajax_refresh();
    });

    // Define event for local ajax links
    $(document).on('click', 'a[href^="/"][href*="/#"]', function(event) {

        // Do not open the requested link itself
        event.preventDefault();

        // Get href and follow link
        var href = $(this).attr('href');

        csphere_ajax_link(href);
    });

    // Catch forms to send them via ajax
    $(document).on('submit', 'form[action^="/"][action*="/#"]', function(event) {

        // Do not send the requested form itself
        event.preventDefault();

        // Fetch action and serialized data
        var formdata = $(this).serialize();
        var action   = $(this).attr('action');
        var target   = csphere_ajax_hash(action);
        var hash     = '#' + target;

        csphere_ajax_post(target, formdata, 'div#csphere_content');

        // Disable refresh and update hash
        csphere_ajax_refresh.skip = true;
        $(location).attr('hash', hash);
        csphere_ajax_refresh.skip = false;
    });
}

function csphere_ajax_ready() {

    // Reload all popover elements
    $('.csphere-popover').popover({
        trigger: 'hover',
        placement: 'top',
        container: 'body'
    });
}

// Wait for the document to be ready
jQuery(document).ready(function() {

    // Set global events for ajax requests
    $(document).ajaxStart(function() {

        console.log('AJAX start');
    })
    .ajaxStop(function() {

        console.log('AJAX stop');
    });

    // Init javascript functions that need to be refreshed
    csphere_ajax_ready();

    // Disable form submit if action is empty
    $(document).on('submit', 'form:not([action])', function(event) {

        // Do not send the requested form itself
        event.preventDefault();
    });

    // Check for full ajax mode
    var full = $('input[name="csphere_ajax"]').attr('value');

    if (full == '1') {

        csphere_ajax_full();
    }
});