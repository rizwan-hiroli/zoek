// setting up active menu for add/edit url.
$(document).ready(function() {
    //$('.pre-loader').removeClass('show').addClass('hidden');
    
    //$('#loader').hide();
    // find nav element with exact match.
    var $cur_menu = $SIDEBAR_MENU.find('a').filter(function () { 
        return this.href == CURRENT_URL;
    });

    // if no exact match, try to find best match
    if ($cur_menu.length == 0) { 
        var $cur_menu = $SIDEBAR_MENU.find('a').filter(function () {
            return CURRENT_URL.startsWith(this.href) && this.href != '';
        });
        // get ONLY one with longest href as best match
        if ($cur_menu.length > 1) { 
            var l = 0;
            for (var i = 0; i < $cur_menu.length; i++) {
                if ($cur_menu.eq(l).attr('href').length < $cur_menu.eq(i).attr('href').length) l = i;
            }
            $cur_menu = $cur_menu.eq(l);
        }
    }
    // original code below, but executed for $cur_menu
    $cur_menu.parent('li').addClass('current-page').parents('ul').slideDown(function() {
        // setContentHeight();
    }).parent().addClass('active');


    $('#cancel').on('click',function(e){
        e.preventDefault();
        var pathArray = window.location.pathname.split( '/' )[2];
        window.location.href='/admin/'+pathArray;
        // location.reload();
    });

    //Adding preview button to ckeditor. 
    $("#descriptionPreview").append($("#previewForm"));

});
$(window).load(function(){
    $('#loader').hide();
});