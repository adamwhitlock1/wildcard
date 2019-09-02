<?php

// Use this file to create any custom shortcodes you may need.
// Below is a vue application that is injected into wordpress with a simple shortcode .

// [madnify_allshouse_survey att1="something" att2="something else"]
function create_madnify_vue_example_shortcode() {
	wp_enqueue_script('madnify-vue-example-bundle-frontend-js', MADNIFY_URL.'/extensions/vue-router-vuex-example/dist/js/frontend.js', array('jquery'), MADNIFY_VERSION);
	?>
		<div id="madnify-vue-example">
		</div>
	<?php
}

add_shortcode('madnify-vue-example','create_madnify_vue_example_shortcode');