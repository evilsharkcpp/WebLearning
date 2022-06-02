<?php
remove_filter('the_content', 'wpautop');
function enqueue_styles() {
	wp_enqueue_style( 'whitesquare-style', get_stylesheet_uri());
	wp_register_style('font-style', 'http://fonts.googleapis.com/css?family=Oswald:400,300');
	wp_enqueue_style( 'font-style');
    wp_enqueue_style ('customstyles', get_stylesheet_directory_uri(). '/css/slider.css');
    wp_enqueue_style ('customstyles', get_stylesheet_directory_uri(). '/css/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_scripts () {
	wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
	wp_enqueue_script('html5-shim');
    wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js');
	wp_enqueue_script('bootstrap');
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');
?>

<?php
 function getPost()
 {
    ?>
        <div class="card mb-4">
            <?php
            if (has_post_thumbnail()):
            ?>
            <a href="#!"><img class="card-img-top" src="<?=the_post_thumbnail_url();?>" alt="..." /></a>
            <?php endif;?>
            <div class="card-body">
                <div class="small text-muted"><?=the_time('Y-m-j g:i:s'); ?></div>
                <h2 class="card-title h4"><?=the_title()?></h2>
                <p class="card-text"><?=the_excerpt()?></p>
            </div>
            <a class="btn btn-primary" href="<?=the_permalink()?>"> Read more →</a>
            <?=edit_post_link('Edit','','',get_the_ID(),"btn btn-primary")?>
            <a class="btn btn-primary" href="<?=get_delete_post_link(get_the_ID())?>"> Delete </a>
        </div>
<?php
 }
 ?>

<?php
function getSlider()
{
    ?>
    <div id="block-for-slider">
                    <div id="viewport">
                    <ul id="slidewrapper">
                                <?php 
                                $i = 0;
                                
                                while($i < 3)
                                {
                                    the_post();
                                    $i++;
                                ?>
                        <li class="slide">
                            <div class="card mb-4">
                            <?php
                                if (has_post_thumbnail()):
                                ?>
                                <a href="#!"><img class="card-img-top" src="<?=the_post_thumbnail_url();?>" alt="..." /></a>
                                <?php endif;?>
                                <div class="card-body">
                                    <div class="small text-muted"><?=the_time('Y-m-j g:i:s'); ?></div>
                                    <h2 class="card-title h4"><?=the_title()?></h2>
                                    <p class="card-text"><?=the_excerpt()?></p>
                                </div>
                                <a class="btn btn-primary" href="<?=the_permalink()?>"> Read more →</a>
                                <?=edit_post_link('Edit','','',get_the_ID(),"btn btn-primary")?>
                                <a class="btn btn-primary" href="<?=get_delete_post_link(get_the_ID())?>"> Delete </a>
                            </div>
                           
                        </li>
                        
                        <?php
                                }?>
                    </ul>
                    
                        
                    </div>
                    <ul id="nav-btns">
                            <?php
                            $j=0;
                            while($j++ < $i)
                            {
                                ?>
                            <li class="slide-nav-btn"></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
}
?>
