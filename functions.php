<?php
function request_a_shipping_quote_init() {
    if ( ! class_exists( 'Imp_WC_Shipping_Local_Pickup' ) ) {

        class Imp_WC_Pickup_Shipping_Method extends WC_Shipping_Method {
            /**
             * Constructor.
             *
             * @param int $instance_id
             */
            public function __construct( $instance_id = 0 ) {
                $this->id           = 'imp_pickup_shipping_method';
                $this->instance_id  = absint( $instance_id );
                $this->method_title = __( "Tính phí theo tỉnh thành", 'imp' );
                $this->supports     = array(
                    'shipping-zones',
                    'instance-settings',
                    'instance-settings-modal',
                );
                $this->init();
            }

            /**
             * Initialize custom shiping method.
             */
            public function init() {

                // Load the settings.
                $this->init_form_fields();
                $this->init_settings();

                // Define user set variables
                $this->title = $this->method_title;

                // Actions
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            /**
             * Calculate custom shipping method.
             *
             * @param array $package
             *
             * @return void
             */
            public function calculate_shipping( $package = array() ) {
                
            }

            /**
             * Init form fields.
             */
            public function init_form_fields() {
                $this->instance_form_fields = array(
                    'title' => array(
                        'title'       => __( 'Tiêu đề', 'imp' ),
                        'type'        => 'text',
                        'description' => __( 'Nhập tiêu đề.', 'woocommerce' ),
                        'default'     => __( 'Tiêu đề', 'imp' ),
                        'desc_tip'    => true,
                    ),
                );
            }
        }
    }
}
add_action( 'woocommerce_shipping_init', 'request_a_shipping_quote_init' );

function request_shipping_quote_shipping_method( $methods ) {
    $methods['imp_pickup_shipping_method'] = 'Imp_WC_Pickup_Shipping_Method';

    return $methods;
}
add_filter( 'woocommerce_shipping_methods', 'request_shipping_quote_shipping_method' );
