<?php

	/*
		Plugin Name: WooCommerce Credomatic Payment Gateway for PayCom
		Description: WooCommerce Payment Gateway for Credomatic using PayCom transaction server.
		Version: 1.0
		Author: BAC | Credomatic
	*/

	register_activation_hook(__FILE__, 'install_wc_credomatic_payment_gateway');
	
	function install_wc_credomatic_payment_gateway(){
		if(version_compare(get_bloginfo('version'), '3.5', '<')){
			deactivate_plugins(basename(__FILE__));
		}
	}
	
	define('WC_CREDOMATIC_PAYCOM_PLUGIN_DIR_NAME', basename( dirname( __FILE__ ) ) );
	define('WC_CREDOMATIC_PAYCOM_PLUGIN_URL', plugins_url() . '/' . WC_CREDOMATIC_PAYCOM_PLUGIN_DIR_NAME . '/' );
	define('WC_CREDOMATIC_PAYCOM_GATEWAY_URL', 'https://paycom.credomatic.com/PayComBackEndWeb/common/requestPaycomService.go');

	add_action( 'plugins_loaded', 'init_wc_credomatic_payment_gateway_paycom', 0);

	function init_wc_credomatic_payment_gateway_paycom(){

		if(!class_exists('WC_Payment_Gateway') ){
			return;
		}
	
		class WC_Credomatic_Payment_Gateway_PayCom extends WC_Payment_Gateway  {

			public function __construct(){
				
				$this->id 	 				= 'credomatic-paycom';
				$this->icon  				= esc_url( WC_CREDOMATIC_PAYCOM_PLUGIN_URL . 'assets/images/credomatic_icon.png' );
				$this->method_title			= __('Credomatic PayCom', 'wc-com-pg-paycom');
				$this->method_description 	= __('WooCommerce Credomatic Payment Gateway', 'wc-com-pg-paycom');
				$this->has_fields 			= true;
				
				$this->init_form_fields();
				$this->init_settings();

				$this->title 		= $this->get_option('title');
				$this->description  = $this->get_option('description');
				$this->username 	= $this->get_option('username');
				$this->key 			= $this->get_option('key');
				$this->key_id   	= $this->get_option('key_id');
				$this->processor_id = $this->get_option('processor_id');
				$this->timeout  	= $this->get_option('timeout');
				$this->debug 		= $this->get_option('debug');

				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'add_credomatic_scripts' ) );
			}//End __construct

			function init_form_fields(){

				$this->form_fields = array(

					'enabled' => array(
						'title'		=> __('Activar/Desactivar', 'wc-com-pg-paycom'),
						'type'		=> 'checkbox',
						'label'		=> __('Activar pago con Credomatic', 'wc-com-pg-paycom'),
						'default' 	=> 'yes',
					),

					'title'	 => array(
						'title'			=> __('T&iacute;tulo', 'wc-com-pg-paycom'),
						'type'			=> 'text',
						'description'	=>	__('Controla el t&iacute;tulo que el usuario ve durante el pago', 'wc-com-pg-paycom'),
						'default'		=>	__('Pago con Credomatic', 'wc-com-pg-paycom'),
						'desc_tip'		=>	true,
					),

					'username'	=> array(
						'title'		  => __('Nombre de usuario PayCom', 'wc-com-pg-paycom'),
						'type'		  => 'text',
						'description' => __('Nombre de usuario proporcionado por Credomatic al comerciante', 'wc-com-pg-paycom'),
						'default'	  => '',
					),

					'key_id' => array(
						'title' 	  => __('Clave p&uacute;blica', 'wc-com-pg-paycom'),
						'type'		  => 'text',
						'description' => __('Clave p&uacute;blica &uacute;nica proporcionada por Credomatic al comerciante', 'wc-com-pg-paycom'),
						'default' 	  => '',
					),

					'key'	=> array(
						'title'		  => __('Clave privada', 'wc-com-pg-paycom'),
						'type'  	  => 'text',
						'description' => __('Clave privada &uacute;nica proporcionada por Credomatic al comerciante', 'wc-com-pg-paycom'),
						'default' 	  => '',
					),

					'processor_id'	=> array(
						'title'		  => __('Identificaci&oacute;n de procesador', 'wc-com-pg-paycom'),
						'type'		  => 'text',
						'description' => __('C&oacute;digo de identificaci&oacute;n &uacute;nico proporcionado por Credomatic al comerciante', 'wc-com-pg-paycom'),
						'default'	  => '',
					),

					'description' => array(
						'title'		=> __('Descripci&oacute;n', 'wc-com-pg-paycom'),
						'type'		=> 'textarea',
						'default' 	=> '',
					),

					'timeout' => array(
						'title'		  => __('Tiempo de espera', 'wc-com-pg-paycom'),
						'type'  	  => 'text',
						'description' => __('Solicitud de tiempo de espera', 'wc-com-pg-paycom'),
						'default'	  => 45,
 					),

					);

			}//End init_form_fields

			function admin_options(){
			?>	

				<img src="<?php echo esc_url( WC_CREDOMATIC_PAYCOM_PLUGIN_URL . 'assets/images/credomatic.png' ); ?>" alt=""/>
				<h3><?php esc_html_e( 'WooCommerce Credomatic Payment Gateway PayCom','wc-com-pg-paycom' ); ?></h3>
				<table class="form-table">
					<?php $this->generate_settings_html(); ?>
				</table>

			<?php
			}//End admin_options

			function payment_fields(){
			?>	
			<div id="payment_gateway">
				<div class="each-row">
					<img class="cards" src="<?php echo esc_url(WC_CREDOMATIC_PAYCOM_PLUGIN_URL . 'assets/images/cards.png'); ?>"/>
				</div>
				<!-- Card number -->
				<div class="each_row">
					<div class="label text"><strong><?php esc_html_e('N&uacute;mero tarjeta:', 'wc-com-pg-paycom'); ?></strong></div>
					<div class="input"><input type="text" id="card_number" name="card_number"
											  maxlength="19"
											  size="20" autocomplete="off" placeholder="<?php esc_html_e('N&uacute;mero tarjeta:', 'wc-com-pg-paycom'); ?>" style="padding: 5px;"/></div>
				</div>
				<!-- CVV Code -->
				<div class="each_row">
					<div class="label text"><strong><?php esc_html_e('C&oacute;digo de seguridad:', 'wc-com-pg-paycom');?></strong></div>
					<div class="input"><input type="text" id="cvv_code" name="cvv_code" size="5"
											  maxlength="4"
											  autocomplete="off" placeholder="<?php esc_html_e('CVV', 'wc-com-pg-paycom');?>" style="padding: 5px;"/>
					</div>
				</div>
				<!-- Expiration date -->
				<div class="each_row">
					<div class="label text"><strong><label><?php esc_html_e('Fecha expiraci&oacute;n:', 'wc-com-pg-paycom'); ?></label></strong></div>
					<div class="input">
						<select id="exp_month" name="exp_month" style="padding: 5px;">
							<option value=""><?php esc_html_e('Mes', 'wc-com-pg-paycom'); ?></option>
						     <?php 
								for($i = 1; $i <= 12; $i++){
								  printf('<option value="%02d">%02d</option>', $i, $i);
								}
							 ?>
						</select> / 
						<select id="exp_year" name="exp_year" style="padding: 5px;">
							<option value=""><?php esc_html_e('A&ntilde;o', 'wc-com-pg-paycom'); ?></option>
							<?php 
								for ( $i = date( 'y' ); $i <= date( 'y' ) + 20; $i ++ ) {
								  printf( '<option value="20%u">20%u</option>', $i, $i );
								} 
							?>
						</select>
					</div>
				</div>
				<!-- Name on card -->
				<div class="each_row">
					<div class="label text"><strong><?php esc_html_e('Nombre en la tarjeta:', 'wc-com-pg-paycom'); ?></strong></div>
					<div class="input"><input type="text" id="card_holder" name="card_holder"
										maxlength="35"
										size="40" autocomplete="off" placeholder="<?php esc_html_e('Nombre en la tarjeta', 'wc-com-pg-paycom');?>"
										style="padding: 5px;"/></div>
				</div>
			</div>
			<?php
			}//End payment_fields

			function validate_fields(){

				global $woocommerce;

				$cardnumber = $this->get_post('card_number');
				$cardnumber =   str_replace(array(' '), '', $cardnumber);
				
				$cvv 		= $this->get_post('cvv_code');
				$expmonth 	= $this->get_post('exp_month');
				$expyear    = $this->get_post('exp_year');
				$cardholder = $this->get_post('card_holder');
				
				if ( empty( $cardnumber ) || !ctype_digit( $cardnumber ) ) {
					$woocommerce->add_error( __( 'El n&uacute;mero de tarjeta no es v&aacute;lido.', 'wc-com-pg-paycom' ) );
					return false;
				}

				if( empty($cvv) || !ctype_digit($cvv)){
					$woocommerce->add_error( __('El c&oacute;digo de seguridad de la tarjeta no es v&aacute;lido.', 'wc-com-pg-paycom'));
					return false;
				}

				$currentYear = date( 'Y' );

				if ( !ctype_digit( $expmonth )  || !ctype_digit( $expyear ) ||
				 		$expmonth > 12 			||
				 		$expmonth < 1 			||
				 		$expyear < $currentYear ||
				 		$expyear > $currentYear + 20
				) {
					$woocommerce->add_error( __( 'La fecha de expiraci&oacute;n de la tarjeta no es v&aacute;lido.', 'wc-com-pg-paycom' ) );
					return false;
				}
				
				if( empty($cardholder)){
					$woocommerce->add_error( __('El nombre en la tarjeta no es v&aacute;lido.', 'wc-com-pg-paycom'));
					return false;
				}
				
			}//End validate_fields
			
			function process_payment($order_id){

				global $woocommerce;

				$order 		= new WC_Order( $order_id );

				$time 		= time();
				
				/*
				=====================================================
					El monto de al transaccion debe enviarse con dos 
					decimales. P/E: 10 dólares debe enviarse como 10.00
					Separador decimales : punto decimal
					Separador de miles : se omite debido al formato Procesado
									     por PayCom.
				=====================================================
				*/
				$amount 	  = number_format( $order->get_total(), 2, '.', '' );
				
				$key 		  = $this->key;
				$key_id       = $this->key_id;
				$username     = $this->username;
				$hash 		  =	md5( implode( '|', array($order_id, $amount, $time, $key) ) );
				$type		  =	'auth';
				$redirect     = $this->get_return_url( $order );
				$timeout      = ( !ctype_digit( $this->timeout ) ) ? 45 : absint( $this->timeout );
				$processor_id = $this->processor_id;
				
				$ccnumber   =   htmlentities( wp_strip_all_tags( $this->get_post( 'card_number' )  ) );
				$ccnumber   =   str_replace(array(' '), '', $ccnumber);
				
				$cvv 		= 	htmlentities( wp_strip_all_tags( $this->get_post( 'cvv_code'    )  ) ); 
				$cardholder =   htmlentities( wp_strip_all_tags( $this->get_post( 'card_holder' )  ) );

				$expmonth   =   htmlentities( wp_strip_all_tags( $this->get_post( 'exp_month' )  ) );
				$expyear    =   htmlentities( wp_strip_all_tags( $this->get_post( 'exp_year'  )  ) );
				$ccexp		=	$expmonth . substr($expyear, -2);
				
				$request 				= array();
				$request['username'] 	= $username;
				$request['type']		= $type;
				$request['key_id']   	= $key_id;
				$request['hash']		= $hash;
				$request['time']		= $time;
				$request['redirect'] 	= $redirect;
				$request['ccnumber'] 	= $ccnumber;
				$request['ccexp']		= $ccexp;
				$request['amount']		= $amount;
				$request['orderid']  	= $order_id;
				$request['cvv']			= $cvv;

				if ( !empty( $processor_id ) ) {
					$request['processor_id'] = $processor_id;
				}
				
				$post = http_build_query( $request, '', '&' );

				$response = wp_remote_post( WC_CREDOMATIC_PAYCOM_GATEWAY_URL, array(
								'body'			=>  $post,
								'timeout'  		=>  $timeout,
								'redirection' 	=>  0,
								'headers'		=>  array(),
								'cookies'		=>	array(),
								'httpversion'	=> '1.1',
							));

				if( is_wp_error( $response ) ){
					$woocommerce->add_error( __('Hay un problema al tratar de conectarse a Credomatic' , 'wc-com-pg-paycom') );
					return;
				}

				if( !isset( $response['headers']['location'] ) ){
					$woocommerce->add_error( __('Hay un problema con la respuesta devuelta por Credomatic', 'wc-com-pg-paycom') );
					return;
				}

				parse_str( $response['headers']['location'], $data );

				if ($data['response_code'] == 100) {
					
					$order_note =  __('<b>C&oacute;digo de autorizaci&oacute;n:</b>' . $data['authcode'], 'wc-com-pg-paycom') . '<br/>';
					$order_note .= __('<b>Titular de la tarjeta:</b>', 'wc-com-pg-paycom') . $cardholder . '<br/>';
					$order_note .= __('<b>&Uacute;ltimos 4 d&iacute;gitos de la tarjeta:</b>', 'wc-com-pg-paycom') . substr($ccnumber, -4) . '<br/>';

					$order->add_order_note($order_note);

					$order->payment_complete();

					$woocommerce->cart->empty_cart();

					return array(
						'result' 	=> 'success',
						'redirect'  => $redirect
					);

				}else if($data['response_code'] == 200){
					
					$order->add_order_note(__('Fallo pago con Credomatic. Pago rechazado', 'wc-com-pg-paycom'));
					$woocommerce->add_error( __('Lo sentimos, la transacci&oacute;n fue rechazada.', 'wc-com-pg-paycom'));

				}else if ( ($data['response_code'] >= 300) || ($data['response_code'] <= 309) ) {
					
					$order->add_order_note( __('Pago Credomatic fall&oacute;.', 'wc-com-pg-paycom'));
					$woocommerce->add_error( __('Lo sentimos hub&oacute; un error, por favor revise la informaci&oacute;n provista e intentelo de nuevo.', 'wc-com-pg-paycom'));
					
				}else{

					$order->add_order_note( __('Error de pago Credomatic. No me puedo conectar al servidor de pasarela', 'wc-com-pg-paycom'));
					$woocommerce->add_error( __('No hay respuesta del servidor de pasarela de pago. Int&eacute;ntelo m&aacute;s tarde o p&oacute;ngase en contacto con el administrador del sitio.', 'wc-com-pg-paycom'));
				
				}
		
			}
			
			
			function add_credomatic_scripts() {
				wp_enqueue_style('credomatic_style', WC_CREDOMATIC_PAYCOM_PLUGIN_URL . '/assets/css/theme.css');
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery_alphanum',  WC_CREDOMATIC_PAYCOM_PLUGIN_URL . 'assets/js/jquery.alphanum.js', array( 'jquery' ), 1.0 );
				wp_enqueue_script('jquery_payment', WC_CREDOMATIC_PAYCOM_PLUGIN_URL . 'assets/js/jquery.payment.js', array('jquery'), 1.0);
				wp_enqueue_script( 'credomatic_validation',  WC_CREDOMATIC_PAYCOM_PLUGIN_URL . 'assets/js/credomatic.validation.js', 
									array( 'jquery', 'jquery_alphanum' ), 1.0 );
			}
			
			
			function get_post( $name ) {
				if ( isset( $_POST[ $name ] ) ) {
					return $_POST[ $name ];
				}
				return null;
			}
			
		}//End WC_Credomatic_Payment_Gateway_PayCom

	}

	function add_wc_credomatic_payment_gateway_paycom($methods){
		$methods[] = 'WC_Credomatic_Payment_Gateway_PayCom';
		return $methods;
	}

	add_filter( 'woocommerce_payment_gateways', 'add_wc_credomatic_payment_gateway_paycom' );

?>