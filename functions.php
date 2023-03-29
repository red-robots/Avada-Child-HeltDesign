<?php

function theme_enqueue_styles() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js', false, '3.6.3', false);
  wp_enqueue_script('jquery');
  
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );

  wp_enqueue_script( 
    'fancybox', 
    get_stylesheet_directory_uri() . '/js/fancybox.js', 
    array(), '20230329', true 
  );
  wp_enqueue_script( 
    'carousel', 
    get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', 
    array(), '20230329', true 
  );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );


//Preview for FAQs and Portfolio items fix
function avada_post_format_parameter( $url ) {
 $url = remove_query_arg( 'post_format', $url );
    return $url;
}
add_filter( 'preview_post_link', 'avada_post_format_parameter', 9999 );

require_once('portfolio-info.php');
/*
if (!(is_admin() )) {
	function defer_parsing_of_js ( $url ) {
	  if ( FALSE === strpos( $url, '.js' ) ) return $url;
	  if ( strpos( $url, 'jquery.js' ) ) return $url;
	    return "$url' defer ";
	}
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
} */

//** *Enable upload for webp image files.*/
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

//** * Enable preview / thumbnail for webp image files.*/
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
   global $post;
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }
    if(is_page() && $post) {
      $classes[] = $post->post_name;
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


add_action('admin_head','custom_admin_css');
function custom_admin_css() { 
  global $post;
  $post_slug = (isset($post->post_name)) ? $post->post_name : '';

  if( $post_slug=='developers'  ) { ?>
    <style>
      #fusion_builder_layout,
      .fusion-builder-toggle-buttons {
        display: none!important;
      }
      .acf-field[data-name="icons"] [data-name="icon"] img {
        max-width: 50px!important;
      }
    </style>
  <?php }
}

add_action('wp_head', 'custom_head_function');
function custom_head_function() { ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/css/custom.css' ?>">
<?php }


function extractURLFromString($string) {
  $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
  if(preg_match($reg_exUrl, $string, $url)) {
      return ($url) ? $url[0] : '';
  } else {
      return '';
  }
}


function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}


add_shortcode( 'developers_display_content', 'developers_display_content_func' );
function developers_display_content_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'numcol'=>3
  // ), $atts );
  // $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $content = '';
  ob_start();
  include( locate_template('parts/content-developers.php') );
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

