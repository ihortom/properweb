<?php 
get_header();

remove_filter ('the_content', 'wpautop');
?>

<div id="default_content" <?php if(isset($left_menu) && $left_menu) echo 'class="rpwp_content_with_left_menu"'?>>

<div class="pw-panel pw-boxes">
    <div class="row">	
        <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 with-cussion">
            <div class="panel panel-default">
                <div class="panel-heading box-header">Page Not Found</div>
                <div class="panel-body panel-text">
                    <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Please try the following:
                        <ul class="text-left">
                        <li>If you typed the page address in the Address bar, make sure that it is spelled correctly</li>
                        <li>Open the www.your-site.com home page, and then look for links to the information you want</li>
                        <li>Click the « Back button to try another link</li>
                        </ul>
                    </p>
                </div>
            </div>
	</div><!-- row -->
    </div>
</div>
<?php get_footer(); ?>
