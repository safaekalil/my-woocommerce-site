<?php
/**
 * Pattern content.
 */
return array(
	'title'      => __( 'Oigny Lite Search Core Hero', 'oigny-lite' ),
	'categories' => array( 'oigny-lite-core' ),
	'content'    => '<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:cover {"url":"' . esc_url( OIGNY_LITE_URI ) . 'assets/img/bg-hero-page.webp","id":105,"dimRatio":0,"className":"oigny-lite-margin-top-n100","style":{"spacing":{"padding":{"right":"12vw","left":"12vw"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover oigny-lite-margin-top-n100" style="padding-right:12vw;padding-left:12vw"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-105" alt="" src="' . esc_url( OIGNY_LITE_URI ) . 'assets/img/bg-hero-page.webp" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"8vh","bottom":"8vh","left":"6vw","right":"6vw"},"margin":{"top":"200px","bottom":"200px"}},"border":{"radius":"18px"}},"backgroundColor":"black"} -->
<div class="wp-block-columns has-black-background-color has-background" style="border-radius:18px;margin-top:200px;margin-bottom:200px;padding-top:8vh;padding-right:6vw;padding-bottom:8vh;padding-left:6vw"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:query-title {"type":"search","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"h2","fontFamily":"michroma"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->',
	'images'      => '',
	'is_sync' => false,
);
