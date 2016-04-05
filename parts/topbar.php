<?php
/**
 * Topbar
 */
?>
    <nav id="topmenu" class="navbar navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><?php bloginfo('name'); ?></a>
          <img class="navbar-brand" src="/images/logo24.png">
          <div id="btn-container" class="clearfix">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            </div>
          </div>
          <div id="navbar" class="middle navbar-collapse collapse">
            <?php 
              if (has_nav_menu('primary')) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'depth'          => '2', 
                    'link_before'    => '<span>', 
                    'link_after'     => '</span>',
                    'items_wrap'     => '<ul class="nav navbar-nav">%3$s</ul>',
                    'walker'         => new Top_Bar_Walker()
                ) );
              }
            ?>
          </div>
      </div><!--/.container-fluid -->
    </nav>

