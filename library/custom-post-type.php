<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// Show custom post type
function show_custom_type() { 
	// creating (registering) the custom type 
	register_post_type( 'shows', // (http://codex.wordpress.org/Function_Reference/register_post_type) 
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Shows', 'bonestheme' ), 
			'singular_name' => __( 'Show', 'bonestheme' ), 
			'all_items' => __( 'All Shows', 'bonestheme' ),
			'add_new' => __( 'Add New', 'bonestheme' ),
			'add_new_item' => __( 'Add New Show', 'bonestheme' ),
			'edit' => __( 'Edit', 'bonestheme' ),
			'edit_item' => __( 'Edit Show', 'bonestheme' ),
			'new_item' => __( 'New Show', 'bonestheme' ),
			'view_item' => __( 'View Show', 'bonestheme' ),
			'search_items' => __( 'Search Show', 'bonestheme' ),
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ),
			'parent_item_colon' => ''
			),
			'description' => __( 'This includes all video and film projects: movies, documentaries, etc.', 'bonestheme' ),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8,
			//'menu_icon' => get_stylesheet_directory_uri() . '/library/images/media-item-icon.png',
			'rewrite'	=> array( 'slug' => 'videos', 'with_front' => false ),
			//'has_archive' => 'show',
			'has_archive' => false,
			'hierarchical' => false,
				'capability_type' => 'post',
			// the next one is important, it tells what's enabled in the post editor 
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) // end of options 
	); // end of register post type 
	
	// this adds your post categories to your custom post type
	register_taxonomy_for_object_type( 'category', 'shows' );
	// this adds your post tags to your custom post type
	register_taxonomy_for_object_type( 'post_tag', 'shows' );
	
}

// adding the function to the Wordpress init
add_action( 'init', 'show_custom_type');	

register_taxonomy( 'show_cat', 
	array('shows'),
	array('hierarchical' => true,
		'labels' => array(
			'name' => __( 'Show Categories', 'bonestheme' ),
			'singular_name' => __( 'Show Category', 'bonestheme' ),
			'search_items' =>  __( 'Search Show Categories', 'bonestheme' ),
			'all_items' => __( 'All Show Categories', 'bonestheme' ),
			'parent_item' => __( 'Parent Show Category', 'bonestheme' ),
			'parent_item_colon' => __( 'Parent Show Category:', 'bonestheme' ),
			'edit_item' => __( 'Edit Show Category', 'bonestheme' ),
			'update_item' => __( 'Update Show Category', 'bonestheme' ),
			'add_new_item' => __( 'Add New Show Category', 'bonestheme' ),
			'new_item_name' => __( 'New Show Category Name', 'bonestheme' )
		),
		'show_admin_column' => true, 
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'show-category' ),
	)
);

// custom tags (these act like categories)
register_taxonomy( 'show_tag', 
	array('shows'), // if you change the name of register_post_type( 'show', then you have to change this 
	array('hierarchical' => false,    // if this is false, it acts like tags 
		'labels' => array(
			'name' => __( 'Show Tags', 'bonestheme' ),
			'singular_name' => __( 'Show Tag', 'bonestheme' ),
			'search_items' =>  __( 'Search Show Tags', 'bonestheme' ),
			'all_items' => __( 'All Show Tags', 'bonestheme' ),
			'parent_item' => __( 'Parent Show Tag', 'bonestheme' ),
			'parent_item_colon' => __( 'Parent Show Tag:', 'bonestheme' ),
			'edit_item' => __( 'Edit Show Tag', 'bonestheme' ),
			'update_item' => __( 'Update Show Tag', 'bonestheme' ),
			'add_new_item' => __( 'Add New Show Tag', 'bonestheme' ),
			'new_item_name' => __( 'New Show Tag Name', 'bonestheme' )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
	)
);

// Module custom post type
function module_post_type() { 
	register_post_type( 'module', 
		array( 'labels' => array(
			'name' => __( 'Modules', 'bonestheme' ),
			'singular_name' => __( 'Module', 'bonestheme' ),
			'all_items' => __( 'All Modules', 'bonestheme' ), 
			'add_new' => __( 'Add New', 'bonestheme' ),
			'add_new_item' => __( 'Add New Module', 'bonestheme' ),
			'edit' => __( 'Edit', 'bonestheme' ),
			'edit_item' => __( 'Edit Module', 'bonestheme' ),
			'new_item' => __( 'New Module', 'bonestheme' ),
			'view_item' => __( 'View Module', 'bonestheme' ),
			'search_items' => __( 'Search Modules', 'bonestheme' ),
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ),
			'parent_item_colon' => ''
			),
			'description' => __( 'This is the module custom post type, for random blocks of content to be used in various places throughout the theme', 'bonestheme' ),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, 
			//'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png',
			'rewrite'	=> array( 'slug' => 'module', 'with_front' => false ),
			'has_archive' => 'module',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) 
	);
	
	register_taxonomy_for_object_type( 'category', 'module' );
	register_taxonomy_for_object_type( 'post_tag', 'module' );
	
}

add_action( 'init', 'module_post_type');


register_taxonomy( 'module_cat', 
	array('module'),
	array('hierarchical' => true, 
		'labels' => array(
			'name' => __( 'Module Categories', 'bonestheme' ),
			'singular_name' => __( 'Module Category', 'bonestheme' ),
			'search_items' =>  __( 'Search Module Categories', 'bonestheme' ),
			'all_items' => __( 'All Module Categories', 'bonestheme' ),
			'parent_item' => __( 'Parent Module Category', 'bonestheme' ),
			'parent_item_colon' => __( 'Parent Module Category:', 'bonestheme' ),
			'edit_item' => __( 'Edit Module Category', 'bonestheme' ),
			'update_item' => __( 'Update Module Category', 'bonestheme' ),
			'add_new_item' => __( 'Add New Module Category', 'bonestheme' ),
			'new_item_name' => __( 'New Module Category Name', 'bonestheme' )
		),
		'show_admin_column' => true, 
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'module-slug' ),
	)
);

register_taxonomy( 'module_tag', 
	array('module'),
	array('hierarchical' => false,
		'labels' => array(
			'name' => __( 'Module Tags', 'bonestheme' ),
			'singular_name' => __( 'Module Tag', 'bonestheme' ),
			'search_items' =>  __( 'Search Module Tags', 'bonestheme' ),
			'all_items' => __( 'All Module Tags', 'bonestheme' ),
			'parent_item' => __( 'Parent Module Tag', 'bonestheme' ),
			'parent_item_colon' => __( 'Parent Module Tag:', 'bonestheme' ),
			'edit_item' => __( 'Edit Module Tag', 'bonestheme' ),
			'update_item' => __( 'Update Module Tag', 'bonestheme' ),
			'add_new_item' => __( 'Add New Module Tag', 'bonestheme' ),
			'new_item_name' => __( 'New Module Tag Name', 'bonestheme' )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
	)
);


// Person custom post type
function person_custom_type() { 
	// creating (registering) the custom type 
	register_post_type( 'people', // (http://codex.wordpress.org/Function_Reference/register_post_type) 
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'People', 'bonestheme' ), 
			'singular_name' => __( 'Person', 'bonestheme' ), 
			'all_items' => __( 'All People', 'bonestheme' ),
			'add_new' => __( 'Add New', 'bonestheme' ),
			'add_new_item' => __( 'Add New Person', 'bonestheme' ),
			'edit' => __( 'Edit', 'bonestheme' ),
			'edit_item' => __( 'Edit Person', 'bonestheme' ),
			'new_item' => __( 'New Person', 'bonestheme' ),
			'view_item' => __( 'View Person', 'bonestheme' ),
			'search_items' => __( 'Search Person', 'bonestheme' ),
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ),
			'parent_item_colon' => ''
			),
			'description' => __( 'For people involved in shows: cast and crew', 'bonestheme' ),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8,
			//'menu_icon' => get_stylesheet_directory_uri() . '/library/images/media-item-icon.png',
			'rewrite'	=> array( 'slug' => 'shows', 'with_front' => false ),
			//'has_archive' => 'show',
			'has_archive' => false,
			'hierarchical' => false,
				'capability_type' => 'post',
			// the next one is important, it tells what's enabled in the post editor 
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) // end of options 
	); // end of register post type 
	
}

// adding the function to the Wordpress init
add_action( 'init', 'person_custom_type');	

/*
// let's create the function for the custom type
function custom_post_example() { 
	// creating (registering) the custom type 
	register_post_type( 'custom_type', // (http://codex.wordpress.org/Function_Reference/register_post_type) 
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Custom Types', 'bonestheme' ), // This is the Title of the Group 
			'singular_name' => __( 'Custom Post', 'bonestheme' ), // This is the individual type 
			'all_items' => __( 'All Custom Posts', 'bonestheme' ), // the all items menu item 
			'add_new' => __( 'Add New', 'bonestheme' ), // The add new menu item 
			'add_new_item' => __( 'Add New Custom Type', 'bonestheme' ), // Add New Display Title 
			'edit' => __( 'Edit', 'bonestheme' ), // Edit Dialog 
			'edit_item' => __( 'Edit Post Types', 'bonestheme' ), // Edit Display Title 
			'new_item' => __( 'New Post Type', 'bonestheme' ), // New Display Title 
			'view_item' => __( 'View Post Type', 'bonestheme' ), // View Display Title 
			'search_items' => __( 'Search Post Type', 'bonestheme' ), // Search Custom Type Title  
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), // This displays if there are no entries yet  
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), // This displays if there is nothing in the trash 
			'parent_item_colon' => ''
			), // end of arrays 
			'description' => __( 'This is the example custom post type', 'bonestheme' ), // Custom Type Description 
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, // this is what order you want it to appear in on the left hand side menu  
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', // the icon for the custom post type menu 
			'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ), // you can specify its url slug 
			'has_archive' => 'custom_type', // you can rename the slug here 
			'capability_type' => 'post',
			'hierarchical' => false,
			// the next one is important, it tells what's enabled in the post editor 
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) // end of options 
	); // end of register post type 
	
	// this adds your post categories to your custom post type 
	register_taxonomy_for_object_type( 'category', 'custom_type' );
	// this adds your post tags to your custom post type 
	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_example');
	
	
	// for more information on taxonomies, go here:
	// http://codex.wordpress.org/Function_Reference/register_taxonomy
	
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'custom_cat', 
		array('custom_type'), // if you change the name of register_post_type( 'custom_type', then you have to change this 
		array('hierarchical' => true,     // if this is true, it acts like categories 
			'labels' => array(
				'name' => __( 'Custom Categories', 'bonestheme' ), // name of the custom taxonomy 
				'singular_name' => __( 'Custom Category', 'bonestheme' ), // single taxonomy name 
				'search_items' =>  __( 'Search Custom Categories', 'bonestheme' ), // search title for taxomony 
				'all_items' => __( 'All Custom Categories', 'bonestheme' ), // all title for taxonomies 
				'parent_item' => __( 'Parent Custom Category', 'bonestheme' ), // parent title for taxonomy 
				'parent_item_colon' => __( 'Parent Custom Category:', 'bonestheme' ), // parent taxonomy title 
				'edit_item' => __( 'Edit Custom Category', 'bonestheme' ), // edit custom taxonomy title 
				'update_item' => __( 'Update Custom Category', 'bonestheme' ), // update title for taxonomy 
				'add_new_item' => __( 'Add New Custom Category', 'bonestheme' ), // add new title for taxonomy 
				'new_item_name' => __( 'New Custom Category Name', 'bonestheme' ) // name title for taxonomy 
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'custom-slug' ),
		)
	);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'custom_tag', 
		array('custom_type'), // if you change the name of register_post_type( 'custom_type', then you have to change this 
		array('hierarchical' => false,    // if this is false, it acts like tags 
			'labels' => array(
				'name' => __( 'Custom Tags', 'bonestheme' ), // name of the custom taxonomy 
				'singular_name' => __( 'Custom Tag', 'bonestheme' ), // single taxonomy name 
				'search_items' =>  __( 'Search Custom Tags', 'bonestheme' ), // search title for taxomony 
				'all_items' => __( 'All Custom Tags', 'bonestheme' ), // all title for taxonomies 
				'parent_item' => __( 'Parent Custom Tag', 'bonestheme' ), // parent title for taxonomy 
				'parent_item_colon' => __( 'Parent Custom Tag:', 'bonestheme' ), // parent taxonomy title 
				'edit_item' => __( 'Edit Custom Tag', 'bonestheme' ), // edit custom taxonomy title 
				'update_item' => __( 'Update Custom Tag', 'bonestheme' ), // update title for taxonomy 
				'add_new_item' => __( 'Add New Custom Tag', 'bonestheme' ), // add new title for taxonomy 
				'new_item_name' => __( 'New Custom Tag Name', 'bonestheme' ) // name title for taxonomy 
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);
*/
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
