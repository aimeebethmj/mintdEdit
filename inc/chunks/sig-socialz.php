<?php
$links = get_option('pipdig_links');
$twitter = $links['twitter'];
$instagram = $links['instagram'];
$facebook = $links['facebook'];
$google = $links['google_plus'];
$bloglovin = $links['bloglovin'];
$pinterest = $links['pinterest'];
$youtube = $links['youtube'];
$tumblr = $links['tumblr'];
$linkedin = $links['linkedin'];
$soundcloud = $links['soundcloud'];
$flickr = $links['flickr'];
$email = $links['email'];
?>
<h6><?php _e( 'Follow:', 'pipdig-textdomain' ) ?></h6>
<?php if($twitter) { ?><a href="<?php echo $twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a> <?php } // end if ?>
<?php if($instagram) { ?><a href="<?php echo $instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a> <?php } // end if ?>
<?php if($facebook) { ?><a href="<?php echo $facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a> <?php } // end if ?>
<?php if($google) { ?><a href="<?php echo $google; ?>" target="_blank"><i class="fa fa-google-plus"></i></a> <?php } // end if ?>
<?php if($bloglovin) { ?><a href="<?php echo $bloglovin; ?>" target="_blank"><i class="fa fa-plus"></i></a> <?php } // end if ?>
<?php if($pinterest) { ?><a href="<?php echo $pinterest; ?>" target="_blank"><i class="fa fa-pinterest"></i></a> <?php } // end if ?>
<?php if($youtube) { ?><a href="<?php echo $youtube; ?>" target="_blank"><i class="fa fa-youtube-play"></i></a> <?php } // end if ?>
<?php if($tumblr) { ?><a href="<?php echo $tumblr; ?>" target="_blank"><i class="fa fa-tumblr"></i></a> <?php } // end if ?>
<?php if($linkedin) { ?><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a> <?php } // end if ?>
<?php if($soundcloud) { ?><a href="<?php echo $soundcloud; ?>" target="_blank"><i class="fa fa-soundcloud"></i></a> <?php } // end if ?>
<?php if($flickr) { ?><a href="<?php echo $flickr; ?>" target="_blank"><i class="fa fa-flickr"></i></a> <?php } // end if ?>
<?php if($email) { ?><a href="mailto:<?php $email; ?>"><i class="fa fa-envelope"></i></a> <?php } // end if ?>