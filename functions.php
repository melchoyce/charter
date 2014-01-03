<?php
/**
 * charterfunctions and definitions
 *
 * @package charter
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1000; /* pixels */
}

if ( ! function_exists( 'charter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function charter_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on charter, use a find and replace
	 * to change 'charter' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'charter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'charter' ),
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', charter_fonts_url() ) );

	// Enable support for Post Formats.
	// add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'charter_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // charter_setup
add_action( 'after_setup_theme', 'charter_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function charter_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'charter' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'charter_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function charter_scripts() {
	wp_enqueue_style( 'charter-style', get_stylesheet_uri() );

	wp_enqueue_script( 'charter-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'charter-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Add Noto Sans & Noto Serif
	wp_enqueue_style( 'charter-fonts', charter_fonts_url(), array(), null );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'charter_scripts' );


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Charter 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function charter_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Noto Serif, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$noto_serif = _x( 'on', 'Noto Serif font: on or off', 'charter' );

	/* Translators: If there are characters in your language that are not
	 * supported by Noto Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$noto_sans = _x( 'on', 'Noto Sans font: on or off', 'charter' );

	if ( 'off' !== $noto_serif || 'off' !== $noto_sans ) {
		$font_families = array();

		if ( 'off' !== $noto_serif )
			$font_families[] = 'Noto Serif:400,700,400italic,700italic';

		if ( 'off' !== $noto_sans )
			$font_families[] = 'Noto Sans:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
