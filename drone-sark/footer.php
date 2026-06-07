</div><!-- #content -->

<?php
// Try Elementor Pro footer first
if ( ! drone_sark_elementor_footer() ) :
	get_template_part( 'template-parts/footer/footer', 'main' );
endif;
?>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
