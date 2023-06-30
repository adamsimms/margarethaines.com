<?php 
Frontend::get_footer();
wp_footer(); 

echo '<!-- Fix for flash of unstyled content on Chrome -->';
echo '<style>.sitetitle, .laynav, .project-arrow, .mobile-title{visibility:visible;}</style>';
?>
</body>
</html>