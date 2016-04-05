// Parse URL Queries
function url_query( query ) {
    query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var expr = "[\\?&]"+query+"=([^&#]*)";
    var regex = new RegExp( expr );
    var results = regex.exec( window.location.href );
    if ( results !== null ) {
        return results[1];
    } else {
        return false;
    }
}

jQuery.urlParam = function(name){
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if(results) {
				return results[1] || 0;
		}
		return '';
}

function urldecode(url) {
	return decodeURIComponent(url.replace(/\+/g, ' '));
}
							
function strip_tags (input, allowed) {
	allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
	var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
		commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
		return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	});
}

////////////////////////////////////
function emailCheck (emailStr) {

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

alert("Your email appears to be invalid.");
return false;
}
var user=matchArray[1];
var domain=matchArray[2];

// Start by checking that only basic ASCII characters are in the strings (0-127).

for (i=0; i<user.length; i++) {
if (user.charCodeAt(i)>127) {
alert("Your email appears to be invalid.");
return false;
   }
}
for (i=0; i<domain.length; i++) {
if (domain.charCodeAt(i)>127) {
alert("Your email appears to be invalid");
return false;
   }
}

// See if "user" is valid 

if (user.match(userPat)==null) {

// user is not valid

alert("Your email appears to be invalid.");
return false;
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
host name) make sure the IP address is valid. */

var IPArray=domain.match(ipDomainPat);
if (IPArray!=null) {

// this is an IP address

for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("Destination IP address is invalid!");
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
alert("Your email appears to be invalid.");
return false;
   }
}

/* domain name seems valid, but now make sure that it ends in a
known top-level domain (like com, edu, gov) or a two-letter word,
representing country (uk, nl), and that there's a hostname preceding 
the domain or country. */

if (checkTLD && domArr[domArr.length-1].length!=2 && 
domArr[domArr.length-1].search(knownDomsPat)==-1) {
alert("Your email appears to be invalid.");
return false;
}

// Make sure there's a host name preceding the domain.

if (len<2) {
alert("Your email appears to be invalid.");
return false;
}

// If we've gotten this far, everything's valid!
return true;
}

// ------------ function VALIDATE ()  ------------------------
function validateSignup() {
	var passed = true;
	if (!jQuery('#first_name').val().trim()) { jQuery('#first_name').addClass('highlighted'); passed = false; }
	if (!jQuery('#last_name').val().trim()) { jQuery('#last_name').addClass('highlighted'); passed = false; }
	if (!jQuery('#reg #password').val().trim()) { jQuery('#reg #password').addClass('highlighted'); passed = false; }
	if (!jQuery('#password_confirm').val().trim()) { jQuery('#password_confirm').addClass('highlighted'); passed = false; }
	if (!jQuery('#address_1').val().trim()) { jQuery('#address_1').addClass('highlighted'); passed = false; }
	if (!jQuery('#city').val().trim()) { jQuery('#city').addClass('highlighted'); passed = false; }
	if (!jQuery('#country').val().trim()) { jQuery('#country').addClass('highlighted'); passed = false; }
	if (!jQuery('#state').val().trim()) { jQuery('#state').addClass('highlighted'); passed = false; }
	if (!jQuery('#captcha').val().trim()) { jQuery('#captcha').addClass('highlighted'); passed = false; }
	if (!jQuery('#reg #email').val().trim()) { jQuery('#reg #email').addClass('highlighted'); passed = false; }
	else { emailCheck(jQuery('#reg #email').val().trim()); }
	if (!passed) { alert ('Please, provide the missing information.'); return false; }
	else return true;
}
function validateContact1() {
	// !!! correlate with si-contact-form/class-fscf-display.php
	var passed = true;
	if (!jQuery('#fscf_f_name1').val().trim()) { jQuery('#fscf_f_name1').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_l_name1').val().trim()) { jQuery('#fscf_l_name1').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_field1_4').val().trim()) { jQuery('#fscf_field1_4').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_field1_2').val().trim()) { jQuery('#fscf_field1_2').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_field1_3').val().trim()) { jQuery('#fscf_field1_3').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_captcha_code1').val().trim()) { jQuery('#fscf_captcha_code1').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_email1').val().trim()) { jQuery('#fscf_email1').addClass('highlighted'); passed = false; }
	else { emailCheck(jQuery('#fscf_email1').val().trim()); }
	if (!passed) { alert ('Please, provide the missing information.'); return false; }
	return true;
}
function validateContact2() {
	// !!! correlate with si-contact-form/class-fscf-display.php
	var passed = true;
	if (!jQuery('#fscf_f_name2').val().trim()) { jQuery('#fscf_f_name2').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_l_name2').val().trim()) { jQuery('#fscf_l_name2').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_field2_4').val().trim()) { jQuery('#fscf_field2_4').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_field2_2').val().trim()) { jQuery('#fscf_field2_2').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_field2_3').val().trim()) { jQuery('#fscf_field2_3').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_captcha_code2').val().trim()) { jQuery('#fscf_captcha_code2').addClass('highlighted'); passed = false; }
	if (!jQuery('#fscf_email2').val().trim()) { jQuery('#fscf_email2').addClass('highlighted'); passed = false; }
	else { emailCheck(jQuery('#fscf_email2').val().trim()); }
	if (!passed) { alert ('Please, provide the missing information.'); return false; }
	return true;
}

jQuery(document).ready(function($) {
	$('iframe').load(function() {$('#loading').hide();});
	$('#reg input').each(function(){
		var v = $.urlParam(jQuery(this).attr('name'));
		if(v) {
				$(this).val(urldecode(v));
		}
	});

	var err = $.urlParam('error_msg');
	if (err) {
			jQuery('<div class="error">').text(strip_tags(urldecode(err), '')).insertBefore('#reg');
			jQuery('#captcha').addClass('highlighted');
	}
	
	$('#reg input[type=text], #reg input[type=password], #reg select, #fscf_form1 input[type=text], #fscf_form1 textarea').each(
		function() {
			$(this).on(
				'keypress paste change',
				function() { 
					jQuery(this).removeClass('highlighted'); 
				}
			);	//end keypress
		}
	);	//end each
	
	$('#reg').submit(validateSignup);
	$('#fscf_form1').submit(validateContact1);
	$('#fscf_form2').submit(validateContact2);
	
	//signin
	$('#menu-form').hide();
	$('#signin').click(function() {
		$('#menu-form').slideToggle(500, "linear");
	}); //end click
	$("#webmail-btn, #forgot-btn").click(function(a){
		a.preventDefault();
		$("#login-to-cp").animate({opacity:0,width:0}).hide();
		if ($(this).attr("id")=="webmail-btn") {
			$("#login-to-webmail").show().animate({opacity:'+=1',width:'100%'})
		}
		if($(this).attr("id")=="forgot-btn") {
			$("#forgotten-pass").show().animate({opacity:'+=1',width:'100%'})
		}
	}); //end click
	$(".back-btn, #menu-form .back").click(function(a) {
		a.preventDefault();
		$("#forgotten-pass, #login-to-webmail").animate({opacity:0,width:0}).hide();
		$("#login-to-cp").show().animate({opacity:'+=1',width:'100%'})
	}); //end click
	
	//responsive menu
	var isMenuExpanded = false;
	var isMenuLocked = false;
	$('#menu ul.dropdown li.menu-item-type-custom:first').mouseenter(
		function() {
			if (!isMenuLocked) {
				if ($('#menu.collapsed')) {
					$('#menu').removeClass('collapsed').addClass('expanded');
				}
				else if (!$('#menu.expanded')) { 
					$('#menu').addClass('expanded');
				}
				isMenuExpanded = true;
			}
		}
	); //end mouseenter
	$('#menu ul.dropdown').mouseleave(	
		function() {
			if (!isMenuLocked) {
				if ($('#menu.expanded')) {
					$('#menu').removeClass('expanded').addClass('collapsed');
				}
				else if (!$('#menu.collapsed')) { 
					$('#menu').addClass('collapsed'); 			
				}
				isMenuExpanded = false;
			}
		}
	); //end mouseleave
	$('#menu ul.dropdown li.menu-item-type-custom:first').click(
		function() {
			if (isMenuLocked) {
				if ($('#menu.expanded')) {
					$('#menu').removeClass('expanded').addClass('collapsed');
				}
				else if (!$('#menu.collapsed')) { 
					$('#menu').addClass('collapsed'); 			
				}
				isMenuLocked = false;
			}
			else {
				if ($('#menu.collapsed')) {
					$('#menu').removeClass('collapsed').addClass('expanded');
				}
				else if (!$('#menu.expanded')) { 
					$('#menu').addClass('expanded');
				}
				isMenuLocked = true;
			}
		}
	);
	
	
	
}); //end ready