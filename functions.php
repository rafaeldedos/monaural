<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

  // wp nav menu child pages
  add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );

function bones_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Sidebar 1', 'bonestheme' ),
    'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  )); }

// SLUG TO BODY CLASS
add_filter('body_class','smartestb_pages_bodyclass');
function smartestb_pages_bodyclass($classes) {
    if (is_page()) {
        // get page slug
        global $post;
        $slug = get_post( $post )->post_name;
 
        // add slug to $classes array
        $classes[] = $slug;
        // return the $classes array
        return $classes;
    } else { 
        return $classes;
    }
}

// CATEGORY TO BODY CLASS
add_filter('body_class','add_category_to_single');
function add_category_to_single($classes) {
  if (is_single() ) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
      // add category slug to the $classes array
      $classes[] = $category->category_nicename;
    }
  }
  // return the $classes array
  return $classes;
}

// REMOVE IMAGE DIMENSIONS
/* remove image dimensions */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

// breadcrumbs
function the_breadcrumb() {
    global $post;
    echo '<nav class="breadcrumbs">';
    if (!is_home()) {
        echo '<span class="aqui">Você está aqui:</span> <span><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a> > ';
        if (is_category() || is_single()) {
            echo '<span class="category">';
            the_category(' </span> > <span class="single"> ');
            if (is_single()) {
                echo '</span> > <span>';
                the_title();
                echo '</span>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<span><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></span> > ' . $output;
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<span><strong> '.get_the_title().'</strong></span>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<span>Archive for "; the_time('F jS, Y'); echo'</span>';}
    elseif (is_month()) {echo"<span>Archive for "; the_time('F, Y'); echo'</span>';}
    elseif (is_year()) {echo"<span>Archive for "; the_time('Y'); echo'</span>';}
    elseif (is_author()) {echo"<span>Author Archive"; echo'</span>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>Blog Archives"; echo'</span>';}
    elseif (is_search()) {echo"<span>Search Results"; echo'</span>';}
    echo '</nav>';
}

/* DON'T DELETE THIS CLOSING TAG */ ?>
