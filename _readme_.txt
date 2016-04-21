Parent theme: Clound Servers
Parent plugin: Resellerspanel

// Enabling logo in the header
1. Uncomment adding logo section to the theme options in parent theme's functions.php file
2. Add header.php to the theme including <img> element (and modifying the reast as needed):
	<?php if (get_option('rpwp_logo_url')) : ?>
		<img src="<?php echo get_option('rpwp_logo_url'); ?>">
	<?php endif; ?>
	
// [Optional] Give back access to Reach Editor - TinyMCE
3. Switch false to true in 'plugins/resellerspanel/lib/rp_skip_filters.php'
	function rp_remove_can_richedit( $can ) 
	{
	    return true;	//switch to true
	}
	add_filter( 'user_can_richedit', 'rp_remove_can_richedit' );
4. Now should be able to add sidebars to content. However, DO NOT AMEND RP CONTENT IN VISUAL MODE! Use HTML instead.

//This is an older version (v1.3.19.3) which does not allow to bring up overlay content more than once
//The latest versions (from 1.5.14) resolves this problem: http://www.jacklmoore.com/colorbox/
5. Update colobox jQuery plugin in themes/cloud-servers/js/jquery.colorbox-min.js
6. Add the following CSS rule
	#cboxClose {
	    border: none;
	}
//domain-tld-banner
7. Replace "resellerspanel\templates\domains\domain_names_sole_hosting_banner.php" with own version to be mobile friendly
	<div id="domain-tld-banner-2">
		<div id="pw_domain-tld">Get a unique<br />
			<span class="tld">.<?=$tld?></span><br />
			Domain Name</div>
		<div width="140" class="arrow"></div>
		<div id="pw_domain-offer">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<?php if($domain['prices']['period_'.$GLOBALS['rp_info']['domains_info'][$tld]['years'][0]*12][$domain['store_currency']]==0){?>
				<tr>
					<td>&nbsp;</td>
					<td class="free-domain">FREE</td>
					<td class="domain-tld-banner-text">with <br />
						hosting plan</td>
				</tr>
				<tr>
					<td height="70" colspan="3" align="center" class="or-color">or</td>
					</tr>
				<? } ?>
				<tr>
					<td class="domain-currency"><?php echo _rp_get_currency_symbol($domain['store_currency']);?></td>
					<td class="domain-price"><?php echo sprintf('%0.2f', get_domain_price($tld)); ?></td>
					<td class="domain-tld-banner-text"><?php if($GLOBALS['rp_info']['domains_info'][$tld]['years'][0]>1){?>per <?php echo $GLOBALS['rp_info']['domains_info'][$tld]['years'][0];?> years<?php }else{?>per year<?php }?><br />
						domain only</td>
				</tr>
			</table>
		</div>
	</div>
	
8. Amend "resellerspanel\templates\domains\prices_box.php"
<h3>.<?=strtoupper($tld)?> Specification</h3>
    <div style="padding:5px;">
    <strong>Registration period:</strong> <?=($GLOBALS['rp_info']['domains_info'][$tld]['years'][0]==1)?'1 year':$GLOBALS['rp_info']['domains_info'][$tld]['years'][0].' years'?><br />
	<strong>Transfer option:</strong> <?=($GLOBALS['rp_info']['domains_info'][$tld]['transfer'])?'Yes':'No'?><br />
	<strong>Edit WHOIS:</strong> <?=($GLOBALS['rp_info']['domains_info'][$tld]['whois'])?'Yes':'No'?><br />
	<strong>ID Protection:</strong> <?=($GLOBALS['rp_info']['domains_info'][$tld]['id_protect'])?'Yes':'No'?><br />
   </div>
   <div id="sidebar_accordion">
	<h4>.<?=strtoupper($tld)?> Pricing</h4>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" id="domain_years_short_<?=$tld?>">
    <? 
	$br=0;
	foreach($GLOBALS['rp_info']['domains_info'][$tld]['years'] as $years){if($br==3) break; $br++; ?>
      <tr style="background:<?=($br%2==0)?'#F1F1F1':'#FFF'?>;">
        <td class="year"><?=($years==1)?'1 year':$years.' years'?></td>
        <td class="price" align="right"><span class="tld-price-currency"><?php echo _rp_get_currency_symbol($GLOBALS['rp_info']['store_currency']);?></span><?php echo sprintf('%0.2f',get_domain_price($tld,$years*12)); ?></td>
      </tr>
   <? } ?>
    </table>
    <? if(count($GLOBALS['rp_info']['domains_info'][$tld]['years'])>3){ ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" id="domain_years_long_<?=$tld?>" style="display:none">
    <? 
	$br=0;
	foreach($GLOBALS['rp_info']['domains_info'][$tld]['years'] as $years){$br++; ?>
      <tr style="background:<?=($br%2==0)?'#F1F1F1':'#FFF'?>;">
        <td class="year"><?=($years==1)?'1 year':$years.' years'?></td>
        <td class="price" align="right"><span class="tld-price-currency"><?php echo _rp_get_currency_symbol($GLOBALS['rp_info']['store_currency']);?></span><?php echo sprintf('%0.2f',get_domain_price($tld,$years*12)); ?></td>
      </tr>
   <? } ?>
    </table>
    <p align="center"><a href="#" tld="<?php echo $tld;?>" rel="expand_domain_years">View All Prices</a></p>
    <p align="center"><a href="#" tld="<?php echo $tld;?>" rel="collapse_domain_years" style="display:none">Collapse Prices</a></p>
    <? } ?>
    </div>
    
9. Amend templates/order.php to get inline css adjusted to your theme

<?php 
$orderObj = get_page(get_option('rp_order_form'));
$order_url = get_permalink(get_option('rp_order_form'));
$order_path = parse_url($order_url,PHP_URL_PATH);
$permalink_structure = get_option('permalink_structure');

if($page == 'rp_shared_order_form') $pt = "&plan_type=shared_hosting";
if($page == 'rp_vps_virtuozzo_order_form') $pt = "&plan_type=vps";
if($page == 'rp_vps_openvz_order_form') $pt = "&plan_type=openvz_vps";
if($page == 'rp_semi_dedicated_order_form') $pt = "&plan_type=semi_dedicated";
if($page == 'rp_dedicated_order_form') $pt = "&plan_type=dedicated";

$order_query = parse_url($order_url,PHP_URL_QUERY);
$return = '&return_url='.urlencode($order_url.(($order_query)?'&return=thankyou':'?return=thankyou')).'&cancel_url='.urlencode($order_url.(($order_query)?'&return=cancel':'?return=cancel'));

if(!empty($permalink_structure) and stristr($order_path, $orderObj->post_name.'/')){?>
<style type="text/css" media='all'>
body {	font-size:14px; }
.ui-widget { font-family: Arial, sans-serif; font-size: 0.9em; }
.ui-widget .ui-widget { font-size: 0.9em;}
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-size: 0.9em; }
.clear {clear:both;height:8px;}
#orderForm.clear {clear:both;height:0px;overflow:0px;} 
#all_pm{overflow:hidden;}
</style>
<?=file_get_contents('http://'.$rp_info['store_name'].'.duoservers.com/hosting-order/?template_only=1&'.$_SERVER['QUERY_STRING'].'&remote_addr='.$_SERVER['REMOTE_ADDR'].$pt.$return)?> 
<?php }else{?>
<iframe frameborder='0' style='width: 950px; height: 1200px' src='http://<?=$rp_info['store_name']?>.duoservers.com/hosting-order/?template_only=1&<?=$_SERVER['QUERY_STRING'].$pt?>'></iframe>
<?php }?>

10. Add/Amend the following options with the values corresponding toy your order forms
     rp_order_form
     rp_shared_order_form
     pweb_shared
     pweb_domains
     
     Example: INSERT INTO `ihortom_pweb2`.`pweb_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES (NULL, 'pweb_shared', '402', 'yes'), (NULL, 'pweb_domains', '389', 'yes')
     
     Links to own pages could be referenced like <a href="[pweb_page_link key='pweb_domains']">domain names</a>
     
11. Remove echo '<br>' from loop.php in parent theme
 
//get top-level domains of our preference
12. Amend resellespanel/js/ajax.js to include our choice domain including .ca
 
    if (q.length>2) {
	var str_com = '<div class="live-search-res">'+q+'.com <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	var str_net = '<div class="live-search-res">'+q+'.net <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	var str_org = '<div class="live-search-res">'+q+'.org <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	var str_biz = '<div class="live-search-res">'+q+'.biz <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	var str_info = '<div class="live-search-res">'+q+'.info <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	var str_ca = '<div class="live-search-res">'+q+'.ca <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	var str_diff = '';
	if(tld !='com' && tld !='net' && tld !='org' && tld !='biz' && tld !='info' && tld !='ca')
			str_diff =  '<div class="live-search-res">'+q+'.'+tld+' <img src="'+template_directory+'/images/ajax-loader.gif" /></div>';
	if(typeof(ajaxRequest)!=='undefined') ajaxRequest.abort();
	liveSearch.html(str_diff+str_com+str_net+str_org+str_biz+str_info+str_ca);
	showLiveSearch();
    }
13. Ament rp_quick_domain_check() in resellerspanel.php to get results for the same list of top-level domains.
    $tldpromos = array('com','net','biz','org','info', 'ca'); //the order will be the same in GUI

//make app installer pages content mobile friendly    
14. Modify teplates/script_hosting_banner.php to make it mobile-friendly

....
   <? }else{ ?>
	<div id="script-banner-plan-features"><h3 class="script-banner-title"><?php echo $type_label;?> Hosting Plan</h3>
    <ul>
    	<li><?php echo __rp_value($banner_plan[$plan]['value']['services']['disk_space'],'disk_space');?> Disk Space</li>
        <li><?php echo __rp_value($banner_plan[$plan]['value']['services']['traffic'],'traffic');?> Traffic</li>
        <li><? if(!empty($banner_plan[$plan]['value']['free_domains'])){ ?>FREE Domain Name<? }else{ ?>Multi-lingual Control Panel<? } ?></li>
        <li><?=(($banner_plan[$plan]['value']['services']['domain'] == 99999) ? 'Unlimited' : $banner_plan[$plan]['value']['services']['domain']) ?> <? if($banner_plan[$plan]['value']['services']['domain'] == 1){ ?>Domain<? }else{ ?>Domains<? } ?> Hosted</li>
        <li><?=(($banner_plan[$plan]['value']['services']['mailbox'] >= 999) ? 'Unlimited' : $banner_plan[$plan]['value']['services']['mailbox']) ?> Email <?php echo ($banner_plan[$plan]['value']['services']['mailbox']>1)?'Accounts':'Account';?></li>
    </ul>
	</div>    
  <div id="script-banner-price" class="script-banner-price"><span class="currency"><?php echo _rp_get_currency_symbol($banner_plan[$plan]['value']['store_currency']);?></span><span class="price-value"><?php echo sprintf('%0.2f',$banner_plan[$plan]['value']['prices']['period_1'][$banner_plan[$plan]['value']['store_currency']]); ?></span><br /><span class="period">per month</span><br /><br />
    <form method="get" class="pr_rp_sing_up_form" action="<?php echo $rp_signup_url?>">
		<button class="rpwp-button colorize"><span class="gloss"></span>order now</button>
        <?php if ($get_params_string):foreach ($get_params as $name=>$value):?>
        <input name="<?php echo $name?>" type="hidden" value="<?php echo $value?>" />
        <?php endforeach; endif;?>
        <input name="plan" type="hidden" value="<?php echo $plan;?>" />
	</form></div>  
    <? } ?>
    <div id="script-banner-img"><img src="<?php bloginfo('template_directory') ?>/images/script-hosting/<?php echo $type; ?>.png" width="365" height="auto" /></div>
 </div>
 
 //improve page load speed
 15. Comment out the reference to bootom.js/bottom.php in resellerspanel.php as shown below:
 	//wp_enqueue_script( 'resellerspanel-bottom', plugin_dir_url( __FILE__ ) . 'js/bottom.js', array(), '3.5', true );