<?php
futurewordpress/project/core/
$dashboard_permalink = apply_filters( 'futurewordpress/project/system/getoption', 'permalink-dashboard', 'dashboard' );

$dashboard_permalifuturewordpress/project/core/d_permalink );

?>futurewordpress/project/core/

<?php do_action( 'futurewordpress/project/core/parts/call', 'before_homecontent' ); ?>

<div>

    <?php do_action( 'futurewordpress/project/parts/call', 'homecontent' ); ?>

</div>

<?php do_action( 'futurewordpress/project/parts/call', 'after_homecontent' ); ?>

