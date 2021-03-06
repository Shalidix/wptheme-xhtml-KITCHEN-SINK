<?php
/**
 * Media Attachments template
 *  
 * @package WordPress
 * @subpackage kitchenSinkTheme
 * 
 * Based on kitchenSink theme Version 0.3 and ZUI by zoe somebody http://beingzoe.com/zui/
 */
 
get_header();

?>

<div id="bd" class="hfeed">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <div id="attachment-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <h1 class="entry-title">
            <?php the_title(); ?>
        </h1>

        <div class="wp_entry_header">
            <?php echo __( 'Originally posted in ', 'twentyten' ); ?>
            <a 
                href="<?php echo get_permalink( $post->post_parent ); ?>" 
                title="<?php esc_attr( printf( __( 'Go to %s', 'twentyten' ), get_the_title( $post->post_parent ) ) ); ?>" 
                rel="gallery">
                    <?php
                        /* translators: %s - title of parent post */
                        printf( __( '%s', 'twentyten' ), get_the_title( $post->post_parent ) );
                    ?></a>
                    
            <?php
            /* Author by line */
            /* get extra hcard meta data */
            $author_website = ( get_the_author_meta( 'user_url' ) )
                ? "<a class=\"hmeta url\" href=\"" . get_the_author_meta( 'user_url' ) . "\"> &raquo; </a>"
                : '';
            printf(__('<span class="wp_entry_meta wp_entry_meta_author vcard">by %1$s </span>', 'twentyten'),
                    sprintf( '<span class="author"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a>%4$s</span>',
                        get_author_posts_url( get_the_author_meta( 'ID' ) ),
                        sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
                        get_the_author(),
                        $author_website
                    )
                );
            
                echo ' | ';
            
                /* date */
                printf( __('<span class="wp_entry_meta wp_entry_meta_date">Published %1$s', 'twentyten'),
                    sprintf( '<abbr class="published" title="%1$s">%2$s</abbr></span>',
                        esc_attr( get_the_time("Y-m-d\TH:i:s\Z") ),
                        get_the_date()
                    )
                );
                if ( wp_attachment_is_image() ) {
                    echo ' | ';
                    $metadata = wp_get_attachment_metadata();
                    printf( __( 'Full size is %s pixels', 'twentyten'),
                        sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
                            wp_get_attachment_url(),
                            esc_attr( __('Link to full-size image', 'twentyten') ),
                            $metadata['width'],
                            $metadata['height']
                        )
                    );
                }
            ?>
            <?php edit_post_link( __( 'Edit', 'twentyten' ), '| <span class="edit-link">', '</span>' ); ?>
        </div><!-- .wp_entry_header -->

        <div class="wp_entry entry-content">
						
<?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 image attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image attachment, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
            <div class="wp_attachment">
                <a 
                    href="<?php echo $next_attachment_url; ?>" 
                    title="<?php echo esc_attr( get_the_title() ); ?>" 
                    rel="attachment"
                    ><?php
                        $attachment_size = apply_filters( 'twentyten_attachment_size', 900 );
                        echo wp_get_attachment_image( $post->ID, array( $attachment_size, 9999 ) ); // filterable image width with, essentially, no limit for image height.
                    ?></a>
                <?php if ( !empty( $post->post_excerpt ) ) { ?>
                    <div class="wp_caption entry-summary"><?php the_excerpt(); ?></div>
                <?php } ?>
            </div>
						
<?php else : ?>
            
            <?php
            if ( get_post_mime_type( $ID ) == 'audio/mpeg' ) {
                $mp3_uri = wp_get_attachment_url();
                if (array_key_exists('mp3player', $shortcode_tags))
                    echo do_shortcode( "[mp3player mp3=\"{$mp3_uri}\"]" );
            }
            ?>
            <p>Download: <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a></p>
<?php endif; ?>
						
				

<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>

					</div><!-- .wp_entry -->
					
					<?php include ('include_entry_footer.php'); ?>
					
				</div><!-- .attachment -->
				
				<?php if ( wp_attachment_is_image() ) { ?>
				    <h3>More from this post</h3>
                    <?php echo do_shortcode( "[gallery id=\"{$post->post_parent}\" exclude=\"$post->ID\" columns=\"0\"]" ); ?>
                <?php } ?>

            <?php comments_template( '', true ); ?>

<?php endwhile; ?>
    
</div><!-- close #bd -->

<?php get_footer(); ?>
