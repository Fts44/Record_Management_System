$(function() {
    // don't forget to put "d-none" on class div#content

    // check if there is a nav-link on the html page
    if ($("#content a.nav-link").length > 0){ 

        // set last active tab on localStorage
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('lastTab', $(this).attr('href'));
        });

        // get and set the last tab active
        var lastTab = localStorage.getItem('lastTab');
        lastTab = lastTab ?  $('[href="' + lastTab + '"]') : $('a[data-bs-toggle="tab"]').first();
        lastTab.tab('show');
    }

    // show the content div
    $("#content").removeClass('d-none');
}); 