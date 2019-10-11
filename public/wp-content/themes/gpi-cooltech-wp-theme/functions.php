<?php
/*
 *  Author: Fabrizio Giannone
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here


$cooltech_includes = array(
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
);

foreach ( $cooltech_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
  //  add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('cooltech', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// cooltech Blank navigation
function cooltech_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
    'container_class' => 'collapse navbar-collapse',
    'container_id'    => 'navbarNavDropdown',
    'menu_class'      => 'navbar-nav ml-auto',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => new WP_Bootstrap_Navwalker()
		)
	);
}

// Load cooltech Blank scripts (header.php)
function cooltech_header_scripts()
{
				wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.4.1.min.js', array(), '4.3.0'); // Conditionizr
				wp_enqueue_script('jquery');

    	  wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('cooltechscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('cooltechscripts'); // Enqueue it!

				wp_register_script('odometerscr', get_template_directory_uri() . '/js/odometer.min.js', array('jquery'), '1.0.0'); // Custom scripts
				wp_enqueue_script('odometerscr'); // Enqueue it!

				wp_register_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), '4.3.0'); // Conditionizr
				wp_enqueue_script('bootstrapjs');

				wp_register_script('gut-js', get_template_directory_uri()  . '/assets/block-number.js', array( 'wp-blocks', 'wp-element' ));
				wp_enqueue_script('gut-js');

}

// Load cooltech Blank conditional scripts
function cooltech_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load cooltech Blank styles
function cooltech_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('cooltech', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('cooltech'); // Enqueue it!

		wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap-ct.css', array(), '1.0', 'all');
		wp_enqueue_style('bootstrap'); // Enqueue it!

		wp_register_style('odometer', get_template_directory_uri() . '/css/odometer-theme-minimal.css', array(), '1.0', 'all');
		wp_enqueue_style('odometer');

		wp_register_style('gut-css', get_template_directory_uri() . '/assets/block-number.css', array( 'wp-edit-blocks' ));
		wp_enqueue_style('gut-css');
}

// Register cooltech Blank Navigation
function register_cooltech_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'cooltech'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'cooltech'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'cooltech') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'cooltech'),
        'description' => __('Description for this widget-area...', 'cooltech'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'cooltech'),
        'description' => __('Description for this widget-area...', 'cooltech'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function cooltechwp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function cooltechwp_index($length) // Create 20 Word Callback for Index page Excerpts, call using cooltechwp_excerpt('cooltechwp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using cooltechwp_excerpt('cooltechwp_custom_post');
function cooltechwp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function cooltechwp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function cooltech_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'cooltech') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function cooltech_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function cooltechgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function cooltechcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'cooltech_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'cooltech_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'cooltech_styles'); // Add Theme Stylesheet
add_action('init', 'register_cooltech_menu'); // Add cooltech Blank Menu
add_action('init', 'create_post_type_cooltech'); // Add our cooltech Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'cooltechwp_pagination'); // Add our cooltech Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'cooltechgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'cooltech_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'cooltech_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('cooltech_cat', 'cooltech_shortcode_cat'); // You can place [cooltech_shortcode_demo] in Pages, Posts now.
add_shortcode('cooltech_shortcode_demo_2', 'cooltech_shortcode_demo_2'); // Place [cooltech_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [cooltech_shortcode_demo] [cooltech_shortcode_demo_2] Here's the page title! [/cooltech_shortcode_demo_2] [/cooltech_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called cooltech-Blank
function create_post_type_cooltech()
{

    register_post_type('cooltech', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Products', 'cooltech'), // Rename these to suit
            'singular_name' => __('Product', 'cooltech'),
            'add_new' => __('Add New', 'cooltech'),
            'add_new_item' => __('Add New Product', 'cooltech'),
            'edit' => __('Edit', 'cooltech'),
            'edit_item' => __('Edit Product', 'cooltech'),
            'new_item' => __('New Product', 'cooltech'),
            'view' => __('View Product', 'cooltech'),
            'view_item' => __('View Product', 'cooltech'),
            'search_items' => __('Search Product', 'cooltech'),
            'not_found' => __('No Product found', 'cooltech'),
            'not_found_in_trash' => __('No Product found in Trash', 'cooltech')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom cooltech Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'type'
        ) // Add Category and Post Tags support
    ));

}

add_action( 'init', 'create_cooltech_taxonomies', 0 );

// create two taxonomies, Types and writers for the post type "book"
function create_cooltech_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Types', 'taxonomy general name', 'cooltech' ),
		'singular_name'     => _x( 'Type', 'taxonomy singular name', 'cooltech' ),
		'search_items'      => __( 'Search Types', 'cooltech' ),
		'all_items'         => __( 'All Types', 'cooltech' ),
		'parent_item'       => __( 'Parent Type', 'cooltech' ),
		'parent_item_colon' => __( 'Parent Type:', 'cooltech' ),
		'edit_item'         => __( 'Edit Type', 'cooltech' ),
		'update_item'       => __( 'Update Type', 'cooltech' ),
		'add_new_item'      => __( 'Add New Type', 'cooltech' ),
		'new_item_name'     => __( 'New Type Name', 'cooltech' ),
		'menu_name'         => __( 'Type', 'cooltech' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'type' ),
	);

	register_taxonomy( 'type', array( 'cooltech' ), $args );
}

function get_type_from_slug($slug='') {


	if($slug) {
		$t=get_term_by('slug', $slug, 'type');
		$terms = get_terms( array(
				'taxonomy' => 'type',
				'hide_empty' => false,
				'parent'=>$t->term_id
			) );
		} else {
			$terms = get_terms( array(
				'taxonomy' => 'type',
				'hide_empty' => false,
				) );
		}
		return $terms;
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function cooltech_shortcode_demo_2($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function cooltech_shortcode_cat($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
	$terms=get_type_from_slug();
	ob_start();
	?>
			<?php  foreach ( $terms  as $t ) { ?>
			<section class="category">
				<div class="container">
					<div class="row">
						<div class="col-md-8 offset-md-2">
							<div class="row">
									<div class="col"><h3><?php echo $t->name; ?></h3> </div>
									<div class="col">
										<div> <?php echo $t->description; ?> </div>
										<div> <a href="<?php echo home_url(); ?>/type/<?php echo $t->slug ?>" class="btn btn-block btn-outline-dark btn-lg btn-arrow"> Enter Database </a>
								 </div>
						</div>
					</div>
				</div>
			</div>
			</section>
			<?php }
			$out = ob_get_contents();
			ob_end_clean();
    return $out;
}




?>
