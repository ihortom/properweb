jQuery(document).ready(
    function($) {
        
        //promo popup
        $('[data-reveal-id="flash"]').trigger('click');
        
        //dropdown hover on large screen
        $('.nav li.dropdown').hover(
            function() {
                if (!$('.navbar-header').is(':visible')) {
                    $(this).addClass('open');
                }
            }, 
            function() {
                if (!$('.navbar-header').is(':visible')) {
                    $(this).removeClass('open');
                }
            }
        );
        
        // handle HTML popovers
        $('[rel="popover"]').popover({
            container: 'body',
            placement: 'top',
            html: true,
            title: function () {
                return $('.popover-title').html();
            },
            content: function () {
                return $('.popover-content').html();
            }
        }).on('click hover focus',function(e) {e.preventDefault(); });
        
        $(document).on( 'click', '.popover-close',
            function() {
                $(this).parents(".popover").popover('hide');
            }
        );

        //gallery pagination
        var total_pages = parseInt($('.gallery').attr('gallery-pages'));
        var imgs_per_page = parseInt($('.gallery').attr('imgs-per-page'));
        var current_page = 1;
        
        $('.gallery-fast-backward a').click(function() {
            var gallery = $(this).parents('.gallery');
            var gallery_nav = $(this).parents('.gallery-nav');
            gallery.children('.gallery-item').hide();
            gallery.children('.gallery-item').slice(0,imgs_per_page).fadeToggle();
            if (!gallery_nav.find('.gallery-fast-backward').hasClass('disabled')) {
                gallery_nav.find('.gallery-fast-backward').addClass('disabled');
            }
            if (!gallery_nav.find('.gallery-backward').hasClass('disabled')) {
                gallery_nav.find('.gallery-backward').addClass('disabled');
            }
            if (gallery_nav.find('.gallery-fast-forward').hasClass('disabled')) {
                gallery_nav.find('.gallery-fast-forward').removeClass('disabled');
            }
            if (gallery_nav.find('.gallery-forward').hasClass('disabled')) {
                gallery_nav.find('.gallery-forward').removeClass('disabled');
            }
            gallery_nav.find('.gallery_page').text('1');
            current_page = 1;
            return false;
        });
        $('.gallery-backward a').click(function() {
            var gallery = $(this).parents('.gallery');
            var gallery_nav = $(this).parents('.gallery-nav');
            if (current_page > 1) {                
                current_page--;
                gallery_nav.find('.gallery_page').text(current_page.toString());
                gallery.children('.gallery-item').hide();
                gallery.children('.gallery-item').slice((current_page-1)*imgs_per_page,(current_page-1)*imgs_per_page + imgs_per_page).fadeToggle();
                              
                if (gallery_nav.find('.gallery-forward').hasClass('disabled')) {
                    gallery_nav.find('.gallery-forward').removeClass('disabled');
                }
                if (gallery_nav.find('.gallery-fast-forward').hasClass('disabled')) {
                    gallery_nav.find('.gallery-fast-forward').removeClass('disabled');
                }
                if (current_page == 1) {
                    if (!gallery_nav.find('.gallery-fast-backward').hasClass('disabled')) {
                        gallery_nav.find('.gallery-fast-backward, #backward').addClass('disabled');
                    }
                    if (!gallery_nav.find('.gallery-backward').hasClass('disabled')) {
                        gallery_nav.find('.gallery-backward').addClass('disabled');
                    } 
                }
            }
            $(this).blur();
            return false;
        });
        $('.gallery-forward a').click(function() {
            var gallery = $(this).parents('.gallery');
            var gallery_nav = $(this).parents('.gallery-nav');
            if (current_page < total_pages) {                
                current_page++;
                gallery_nav.find('.gallery_page').text(current_page.toString());
                gallery.children('.gallery-item').hide();
                gallery.children('.gallery-item').slice((current_page-1)*imgs_per_page,(current_page-1)*imgs_per_page + imgs_per_page).fadeToggle();
                              
                if (gallery_nav.find('.gallery-backward').hasClass('disabled')) {
                    gallery_nav.find('.gallery-backward').removeClass('disabled');
                }
                if (gallery_nav.find('.gallery-fast-backward').hasClass('disabled')) {
                        gallery_nav.find('.gallery-fast-backward').removeClass('disabled');
                    }
                if (current_page == total_pages) {
                    if (!gallery_nav.find('.gallery-fast-forward').hasClass('disabled')) {
                        gallery_nav.find('.gallery-fast-forward').addClass('disabled');
                    }
                    if (!gallery_nav.find('.gallery-forward').hasClass('disabled')) {
                        gallery_nav.find('.gallery-forward').addClass('disabled');
                    } 
                }
            }
            $(this).blur();
            return false;
        });
        $('.gallery-fast-forward a').click(function() {
            var gallery = $(this).parents('.gallery');
            var gallery_nav = $(this).parents('.gallery-nav');
            current_page = total_pages;
            gallery.children('.gallery-item').hide();
            gallery.children('.gallery-item').slice((current_page-1)*imgs_per_page,(current_page-1)*imgs_per_page + imgs_per_page).fadeToggle();
            if (!gallery_nav.find('.gallery-fast-forward').hasClass('disabled')) {
                gallery_nav.find('.gallery-fast-forward').addClass('disabled');
            }
            if (!gallery_nav.find('.gallery-forward').hasClass('disabled')) {
                gallery_nav.find('.gallery-forward').addClass('disabled');
            }
            if (gallery_nav.find('.gallery-fast-backward').hasClass('disabled')) {
                gallery_nav.find('.gallery-fast-backward').removeClass('disabled');
            }
            if (gallery_nav.find('.gallery-backward').hasClass('disabled')) {
                gallery_nav.find('.gallery-backward').removeClass('disabled');
            }
            gallery_nav.find('.gallery_page').text(current_page.toString());
            return false;
        });
        
        //gallery image capture handling
        $('.gallery-item').hover(function() {
            $(this).children('.gallery-caption').fadeToggle();
        });
        $('.gallery-caption').click(function() {
            $(this).parents('.gallery-item').find('a').trigger('click');
            $(this).parents('.gallery-item').find('img').addClass('hovered');
        });
        $('.gallery-caption').hover(
            function() {
                $(this).parents('.gallery-item').find('img').addClass('hovered');
            },
            function() {
                $(this).parents('.gallery-item').find('img').removeClass('hovered');
            }
        );

        //signin
	$('#menu-form').hide();
	$('#signin').click(function() {
		$('#menu-form').slideToggle(500, "linear");
	}); //end click
	$("#webmail-btn, #forgot-btn").click(function(a){
            a.preventDefault();
            //$("#login-to-cp").animate({opacity:0,width:0}).hide();
            $("#login-to-cp").hide();
            if ($(this).attr("id")=="webmail-btn") {
                //$("#login-to-webmail").show().animate({opacity:'+=1',width:'100%'})
                $("#login-to-webmail").show();
            }
            if($(this).attr("id")=="forgot-btn") {
                //$("#forgotten-pass").show().animate({opacity:'+=1',width:'100%'})
                $("#forgotten-pass").show();
            }
	}); //end click
	$(".back-btn, #menu-form .back").click(function(a) {
		a.preventDefault();
		//$("#forgotten-pass, #login-to-webmail").animate({opacity:0,width:0}).hide();
		//$("#login-to-cp").show().animate({opacity:'+=1',width:'100%'})
            $("#forgotten-pass, #login-to-webmail").hide();
            $("#login-to-cp").show();
	}); //end click
        
        //contact
        
        $('#pwcf-submit').on('click submit', function(e) {           
            passed = true;
            prefix = '#pwcf-';
            required = ['name','email','phone','subject', 'message'];
          
            $.each(required, function(i, value) {
                var field = prefix + value;
                if (!$(field).val().trim()) { 
                    $(field).parent('.input-group, .input-item').addClass('has-error');
                    passed = false; 
                    e.preventDefault();
                }
            });
            if (passed) {
                if (!isEmailValid($('#pwcf-email').val().trim())) {
                    $('#pwcf-email').parent('.input-group').addClass('has-error');
                    e.preventDefault();
                }
                if (!isPhoneValid($('#pwcf-phone').val().trim())) {
                    $('#pwcf-phone').parent('.input-group').addClass('has-error');
                    e.preventDefault();
                }
            }
            
        });
        
        $('#pwcf input, #pwcf textarea').on('change', function() {
            $(this).parent('.input-group, .input-item').removeClass('has-error');
        });
    }
);

function isEmailValid (emailStr) {

    /* The following variable tells the rest of the function whether or not
    to verify that the address ends in a two-letter country or well-known
    TLD.  1 means check it, 0 means don't. */

    var checkTLD=1;

    /* The following is the list of known TLDs that an e-mail address must end with. */

    var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;

    /* The following pattern is used to check if the entered e-mail address
    fits the user@domain format.  It also is used to separate the username
    from the domain. */

    var emailPat=/^(.+)@(.+)$/;

    /* The following string represents the pattern for matching all special
    characters.  We don't want to allow special characters in the address. 
    These characters include ( ) < > @ , ; : \ " . [ ] */

    var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";

    /* The following string represents the range of characters allowed in a 
    username or domainname.  It really states which chars aren't allowed.*/

    var validChars="\[^\\s" + specialChars + "\]";

    /* The following pattern applies if the "user" is a quoted string (in
    which case, there are no rules about which characters are allowed
    and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
    is a legal e-mail address. */

    var quotedUser="(\"[^\"]*\")";

    /* The following pattern applies for domains that are IP addresses,
    rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
    e-mail address. NOTE: The square brackets are required. */

    var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;

    /* The following string represents an atom (basically a series of non-special characters.) */

    var atom=validChars + '+';

    /* The following string represents one word in the typical username.
    For example, in john.doe@somewhere.com, john and doe are words.
    Basically, a word is either an atom or quoted string. */

    var word="(" + atom + "|" + quotedUser + ")";

    // The following pattern describes the structure of the user

    var userPat=new RegExp("^" + word + "(\\." + word + ")*$");

    /* The following pattern describes the structure of a normal symbolic
    domain, as opposed to ipDomainPat, shown above. */

    var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");

    /* Finally, let's start trying to figure out if the supplied address is valid. */

    /* Begin with the coarse pattern to simply break up user@domain into
    different pieces that are easy to analyze. */

    var matchArray=emailStr.match(emailPat);

    if (matchArray==null) {

        /* Too many/few @'s or something; basically, this address doesn't
        even fit the general mould of a valid e-mail address. */

        //alert("Your email appears to be invalid.");
        return false;
    }
    var user=matchArray[1];
    var domain=matchArray[2];

    // Start by checking that only basic ASCII characters are in the strings (0-127).

    for (i=0; i<user.length; i++) {
    if (user.charCodeAt(i)>127) {
        //alert("Your email appears to be invalid.");
        return false;
       }
    }
    for (i=0; i<domain.length; i++) {
        if (domain.charCodeAt(i)>127) {
        //alert("Your email appears to be invalid");
        return false;
       }
    }

    // See if "user" is valid 
    if (user.match(userPat)==null) {
        //alert("Your email appears to be invalid.");
        return false;
    }

    /* if the e-mail address is at an IP address (as opposed to a symbolic
    host name) make sure the IP address is valid. */

    var IPArray=domain.match(ipDomainPat);
    if (IPArray!=null) {

    // this is an IP address

    for (var i=1;i<=4;i++) {
    if (IPArray[i]>255) {
        //alert("Destination IP address is invalid!");
        return false;
       }
    }
    return true;
    }

    // Domain is symbolic name.  Check if it's valid.

    var atomPat=new RegExp("^" + atom + "$");
    var domArr=domain.split(".");
    var len=domArr.length;
    for (i=0;i<len;i++) {
    if (domArr[i].search(atomPat)==-1) {
        //alert("Your email appears to be invalid.");
        return false;
       }
    }

    /* domain name seems valid, but now make sure that it ends in a
    known top-level domain (like com, edu, gov) or a two-letter word,
    representing country (uk, nl), and that there's a hostname preceding 
    the domain or country. */

    if (checkTLD && domArr[domArr.length-1].length!=2 && 
    domArr[domArr.length-1].search(knownDomsPat)==-1) {
        //alert("Your email appears to be invalid.");
        return false;
    }

    // Make sure there's a host name preceding the domain.

    if (len<2) {
        //alert("Your email appears to be invalid.");
        return false;
    }

    // If we've gotten this far, everything's valid!
    return true;
}

function isPhoneValid(phoneStr) {    
    var phonePat = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var matchArray=phoneStr.match(phonePat);
    if (matchArray==null) {
        return false;
    }
    return true;
}