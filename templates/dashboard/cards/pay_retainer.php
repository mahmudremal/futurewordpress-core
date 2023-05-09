<?php

/**

 * Checkout video clip shortner template.

 * 

 * @package FutureWordPressScratchProject

 */
futurewordpress/project/core/
// print_r( hex2bin( get_query_var( 'pay_retainer' ) ) );

$userInfo = get_user_by( 'id', hex2bin( get_query_var( 'pay_retainer' ) ) );

if( $userInfo ) {futurewordpress/project/core/

  $userMeta = array_map( function( $a ){ return $a[0]; }, (array) get_user_meta( $userInfo->ID ) );
futurewordpress/project/core/
  $userInfo = (object) wp_parse_args( $userInfo, [

    'meta'          => (object) apfuturewordpress/project/core/press/project/usermeta/defaults', (array) $userMeta )
futurewordpress/project/core/
  ] );futurewordpress/project/core/

  $errorHappens = false;





  $payment_link = ( empty( $userInfo->meta->monthly_retainer ) || $userInfo->meta->monthly_retainer <= 0 ) ? false : apply_filters( 'futurewordpress/project/payment/stripe/paymentlink', [

    'quantity'	=> 1,

    'price_data' => [

      'currency' => apply_filters( 'futurewordpress/project/system/getoption', 'stripe-currency', 'usd' ),

      'unit_amount' => (int) ( $userInfo->meta->monthly_retainer * 100 ), // Unit amount in cent | number_format( $userInfo->meta->monthly_retainer, 2 ),

      'product_data' => [

        'name' => apply_filters( 'futurewordpress/project/system/getoption', 'stripe-productname', __( 'Subscription',   'futurewordpress-project-core-domain' ) ),

        'description' => apply_filters( 'futurewordpress/project/system/getoption', 'stripe-productdesc', __( 'Payment for',   'futurewordpress-project-core-domain' ) . ' ' . get_option( 'blogname', 'We Make Content' ) ),

        'images' => [ apply_filters( 'futurewordpress/project/system/getoption', 'stripe-productimg', esc_url( FUTUREWORDPRESS_PROJECT_CORE_BUILD_URI . '/icons/Online payment_Flatline.svg' ) ) ],

      ],

    ]

  ], true );

  if( $payment_link && ! empty( $payment_link ) ) {

    wp_redirect( $payment_link );

  } else {

    wp_die( __( 'Something error happens with the backend. please contact with site administrative, for this coincident.',   'futurewordpress-project-core-domain' ), __( 'Technical error',   'futurewordpress-project-core-domain' ) );

  }

} else {

  wp_die( __( 'We\'re in a trap. or maybe we did some wrong thing.',   'futurewordpress-project-core-domain' ), __( 'Permalink structure mismatched.',   'futurewordpress-project-core-domain' ) );

}





// https://example.net/pay_retainer/3234/

?>

