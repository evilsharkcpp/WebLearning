<?php get_header();?>
<?php
if( is_front_page() ){
        ?>
<div class="container"><?php getSlider();?> </div>
<?php }?>
<div class="container">

        <div class="col-lg-8">
         
<section>
        <?php $i=0 ?>
			  <?php if (have_posts()):?>
            <div class="row">
                
					<?php while (have_posts()):
                        $post = null;
                        if( $i == 0 || $i == 2)
                        {
                        ?> 
                        <div class="col-lg-6">
                            <?php } ?>
                        <div class="card mb-4">
                        <?php
                        the_post($post);
                        getPost();
                        $i++;
                        ?>
                        </div>
                        <?php if($i==0 || $i==2){ ?>
                        </div>
                        <?php } ?>                      
 <?php endwhile; ?>
               
            </div>
 <?php endif; ?>
				  <?php //verb_pagination();?>
 
    </section>
                    </div>
                    </div>

<?php get_footer(); ?>
