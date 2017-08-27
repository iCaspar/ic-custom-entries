<?php
namespace ICaspar\WPHub\Admin;

class PageExcerpts {

	public static function add_excerpt_support_to_pages (  ) {
		add_post_type_support( 'page', 'excerpt' );
	}

}