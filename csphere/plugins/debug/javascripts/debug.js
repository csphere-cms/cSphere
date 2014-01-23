function csphere_debug_display(name) {

    var id     = 'debug_' + name;
    var status = document.getElementById(id).style.display;
    var nav    = 'debug_' + name + '_nav';
    var active = document.getElementById(nav).className;

    status = (status == 'block') ? 'none' : 'block';

    document.getElementById(id).style.display = status;

    active = (active == 'debug_toggle') ? 'debug_active' : 'debug_toggle';

    document.getElementById(nav).className = active;
}

$(function() {
    $('.popover-nav').popover({
        trigger: 'hover',
        placement: 'top'
    })
});