<?php
if ( !is_user_logged_in() ) 
{
    $login_url = wp_login_url();
    header("Location: {$login_url}");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">
    <meta http-equiv="Content-type" content="text/html; charset=<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php wp_title('«', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?=home_url();?>">Evilshark news</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?=home_url();?>">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="./wp-admin/post-new.php">Add News</a></li>
                        <?php
                        if ( is_user_logged_in() ) 
                        {
                            ?>
                        <li class="nav-item"><a class="nav-link" href="<?=wp_logout_url()?>">Logout</a></li>
                        <?php } else {?>
                            <li class="nav-item"><a class="nav-link" href="<?=wp_login_url()?>">Login</a></li>
                            <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="py-5 bg-light border-bottom mb-4">
        </header>