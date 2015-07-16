<?php

/**
 * Plugin Name: Redsys WooCommerce
 * Plugin URI: http://www.redsys.es
 * Description: Pagar con tarjeta mediante la pasarela de pago Redsys
 * Version: 2.5
 * Author: Redsys
 *
 *
 */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	add_action('plugins_loaded', 'init_wc_redsys_payment_gateway', 0);
	
	function init_wc_redsys_payment_gateway() {
	 
	    if ( ! class_exists( 'WC_Payment_Gateway' ) ) { return; }
 
		class WC_redsys extends WC_Payment_Gateway {

			var $notify_url;
			/**
			 * Constructor for the gateway.
			 */
			public function __construct() {
				$this->id                 = 'redsys';
				$this->icon               = home_url() . '/wp-content/plugins/redsys/pages/assets/images/Redsys.png';
				$this->method_title       = __( 'Pago con Tarjeta (REDSYS)', 'woocommerce' );
				$this->method_description = __( 'Esta es la opción de la pasarela de pago de Redsys.', 'woocommerce' );
				$this ->notify_url		  = add_query_arg( 'wc-api', 'WC_redsys', home_url( '/' ) );
				$this->log  			  =  new WC_Logger();
				
				$this->has_fields       = false;

				// Load the settings
				$this->init_form_fields();
				$this->init_settings();

				$this->title 			= $this->get_option( 'title' );
				$this->description      = $this->get_option( 'description' );
				
				// Get settings
				$this->entorno      = $this->get_option( 'entorno' );
				$this->nombre       = $this->get_option( 'name' );
				$this->fuc 			= $this->get_option( 'fuc' );
				$this->tipopago 	= $this->get_option( 'tipopago' );
				$this->clave  		= $this->get_option( 'clave' );
				$this->terminal     = $this->get_option( 'terminal' );
				$this->firma 		= $this->get_option( 'firma' );
				$this->moneda  		= $this->get_option( 'moneda' );
				$this->trans 		= $this->get_option( 'trans' );
				$this->recargo  	= $this->get_option( 'recargo' );
				$this->idioma	  	= $this->get_option( 'idioma' );


				// Actions
				add_action( 'woocommerce_receipt_redsys', array( $this, 'receipt_page' ) );
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
				//Payment listener/API hook
				add_action( 'woocommerce_api_wc_redsys', array( $this, 'check_rds_response' ) );
			}

			/**
			 * Initialise Gateway Settings Form Fields
			 */
			public function init_form_fields() {
				global $woocommerce;

				$this->form_fields = array(
					'enabled' => array(
						'title'       => __( 'Activar Redsys:', 'woocommerce' ),
						'label'       => __( 'Activar pago Redsys', 'woocommerce' ),
						'type'        => 'checkbox',
						'description' => '',
						'default'     => 'yes'
					),
					'title' => array(
						'title'       => __( 'Título', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
						'default'     => __( 'REDSYS', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'description' => array(
						'title'       => __( 'Descripción', 'woocommerce' ),
						'type'        => 'textarea',
						'description' => __( 'Payment method description that the customer will see on your website.', 'woocommerce' ),
						'default'     => __( 'Esta es la opción de la pasarela de pago con tarjeta de Redsys. Te ayudamos en todo lo que necesites desde nuestra web: <b>www.redsys.es</b> o desde el teléfono central: <b>902 198 747</b>.', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'entorno' => array(
						'title'       => __( 'Entorno de Redsys', 'woocommerce' ),
						'type'        => 'select',
						'description' => __( 'Entorno del proceso de pago.', 'woocommerce' ),
						'default'     => 'Sis-d',
						'desc_tip'    => true,
						'options'     => array(
							'Sis-d' => __( 'Sis-d', 'woocommerce' ),
							'Sis-i' => __( 'Sis-i', 'woocommerce' ),
							'Sis-t' => __( 'Sis-t', 'woocommerce' ),
							'Sis' 	=> __( 'Sis', 'woocommerce' )
						)
					),
					'name' => array(
						'title'       => __( 'Nombre Comercio', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'Nombre Comercio.', 'woocommerce' ),
						'default'     => __( 'Prueba', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'fuc' => array(
						'title'       => __( 'FUC Comercio', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'FUC del comercio.', 'woocommerce' ),
						'default'     => __( '', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'tipopago' => array(
						'title'       => __( 'Tipos de pago permitidos', 'woocommerce' ),
						'type'        => 'select',
						'description' => __( 'Tipos de pago permitidos.', 'woocommerce' ),
						'default'     => 'T',
						'desc_tip'    => true,
						'options'     => array(
							' ' => __( 'Todos', 'woocommerce' ),
							'C' => __( 'Solo tarjeta', 'woocommerce' ),
							'T' => __( 'Tarjeta y Iupay', 'woocommerce' )
						)
					),
					'clave' => array(
						'title'       => __( 'Clave secreta de encriptación', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'Clave del comercio.', 'woocommerce' ),
						'default'     => __( '', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'terminal' => array(
						'title'       => __( 'Terminal', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'Terminal del comercio.', 'woocommerce' ),
						'default'     => __( '1', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'firma' => array(
						'title'       => __( 'Tipo de Firma', 'woocommerce' ),
						'type'        => 'select',
						'description' => __( 'Firma del proceso de pago.', 'woocommerce' ),
						'default'     => 'ampliada',
						'desc_tip'    => true,
						'options'     => array(
							'ampliada' => __( 'Ampliada', 'woocommerce' ),
							'completa' => __( 'Completa', 'woocommerce' )
						)
					),
					'moneda' => array(
						'title'       => __( 'Tipo de Moneda', 'woocommerce' ),
						'type'        => 'select',
						'description' => __( 'Moneda del proceso de pago.', 'woocommerce' ),
						'default'     => '978',
						'desc_tip'    => true,
						'options'     => array(
							'978' => __( 'EURO', 'woocommerce' ),
							'840' => __( 'DOLAR', 'woocommerce' ),
							'826' => __( 'LIBRA', 'woocommerce' )
						)
					),
					'trans' => array(
						'title'       => __( 'Tipo de Transacción', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'Tipo de Transacción del comercio.', 'woocommerce' ),
						'default'     => __( '0', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'recargo' => array(
						'title'       => __( 'Recargo (%)', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'Recargo del comercio.', 'woocommerce' ),
						'default'     => __( '00', 'woocommerce' ),
						'desc_tip'    => true,
					),
					'idioma' => array(
						'title'       => __( 'Activar Idiomas', 'woocommerce' ),
						'type'        => 'select',
						'description' => __( 'Idioma del proceso de pago.', 'woocommerce' ),
						'default'     => 'no',
						'desc_tip'    => true,
						'options'     => array(
							'no' => __( 'No', 'woocommerce' ),
							'si' => __( 'Si', 'woocommerce' )
						)
					)
			   );
			}

			
			function generate_redsys_form( $order_id ) {				
				//Esquema de logs de Redsys
				$this->log->add( 'redsys', 'Acceso al formulario de pago con tarjeta de REDSYS ');			
							
				//Recuperamos los datos de config.
				$nombre=$this->nombre;
				$codigo=$this->fuc;
				$terminal=$this->terminal;
				$trans=$this->trans;
				$moneda=$this->moneda;
				$clave=$this->clave;	
				$tipopago=$this->tipopago;
				$recargo=$this->recargo;
				$idioma=$this->idioma;
				$firma=$this->firma;
				$entorno=$this->entorno;
				
				//Callback
				$urltienda = $this -> notify_url;		
				
				//Objeto tipo pedido
				$order = new WC_Order($order_id);
				
				//Calculo del recargo
				$porcientorecargo = $recargo;
				$porcientorecargo = str_replace (',','.',$porcientorecargo);
				$totalcompra = floatval($order->get_total());
				$fee = ($porcientorecargo / 100) * $totalcompra;	
				
				
				//Calculo del precio total del pedido
				$transaction_amount = number_format( (float) ($order->get_total() + $fee), 2, '.', '' );
				$transaction_amount = str_replace('.','',$transaction_amount);
				$transaction_amount = floatval($transaction_amount);
			
			
				// Descripción de los productos
				$products = WC()->cart->cart_contents;
				foreach ($products as $product) {
					$productos .= $product['quantity'].'x'.$product['data']->post->post_title.'/';
				}
			
				// El número de pedido es  los 8 ultimos digitos del ID del carrito + el tiempo MMSS.
				$numpedido = str_pad($order_id, 8, "0", STR_PAD_LEFT) . date("is");

				
				// Obtenemos el valor de la config del idioma 
				if($idioma=="no"){
					$idiomaFinal="0";
				}
				else {
						$idioma_web = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
						switch ($idioma_web) {
							case 'es':
							$idiomaFinal='001';
							break;
							case 'en':
							$idiomaFinal='002';
							break;
							case 'ca':
							$idiomaFinal='003';
							break;
							case 'fr':
							$idiomaFinal='004';
							break;
							case 'de':
							$idiomaFinal='005';
							break;
							case 'nl':
							$idiomaFinal='006';
							break;
							case 'it':
							$idiomaFinal='007';
							break;
							case 'sv':
							$idiomaFinal='008';
							break;
							case 'pt':
							$idiomaFinal='009';
							break;
							case 'pl':
							$idiomaFinal='011';
							break;
							case 'gl':
							$idiomaFinal='012';
							break;
							case 'eu':
							$idiomaFinal='013';
							break;
							default:
							$idiomaFinal='002';
					}
				}
				
				
				// Generamos la firma	
				// Cálculo del SHA1 $trans . $urltienda
				if($firma=='completa')
					$mensaje = $transaction_amount . $numpedido . $codigo . $moneda . $clave;
				else
					$mensaje = $transaction_amount . $numpedido. $codigo . $moneda . $trans .$urltienda . $clave;
				$firmaFinal = strtoupper(sha1($mensaje));
				
				$resys_args = array(
				  'Ds_Merchant_Amount' => $transaction_amount,
				  'Ds_Merchant_Currency' => $moneda,
				  'Ds_Merchant_Order' => $numpedido,
				  'Ds_Merchant_MerchantCode' => $codigo,
				  'Ds_Merchant_Terminal' => $terminal,
				  'Ds_Merchant_TransactionType' => $trans,
				  'Ds_Merchant_Titular' => $order -> billing_first_name.$order -> billing_last_name.$order -> billing_address_1,
				  'Ds_Merchant_MerchantName' => $nombre,
				  'Ds_Merchant_MerchantData' => sha1($urltienda),
				  'Ds_Merchant_MerchantURL' => $urltienda,
				  'Ds_Merchant_ProductDescription' => $productos,
				  'Ds_Merchant_UrlOK' => $this->get_return_url($order),
				  'Ds_Merchant_UrlKO' => $order->get_cancel_order_url(),
				  'Ds_Merchant_MerchantSignature' => $firmaFinal,
				  'Ds_Merchant_ConsumerLanguage' => $idiomaFinal,
				  'Ds_Merchant_PayMethods' => $tipopago,
				  );
				 
				//Se establecen los input del formulario con los datos del pedido y la redirección
				$resys_args_array = array();
				foreach($resys_args as $key => $value){
				  $resys_args_array[] = "<input type='hidden' name='$key' value='$value'/>";
				}
				
				//Se establece el entorno del SIS
				if($entorno=="Sis-d"){
					$action="http://sis-d.redsys.es/sis/realizarPago";
					}
				else if($entorno=="Sis-i"){
					$action="https://sis-i.redsys.es:25443/sis/realizarPago";
					}
				else if($entorno=="Sis-t"){
					$action="https://sis-t.redsys.es:25443/sis/realizarPago";	
				}
				else{
					$action="https://sis.redsys.es/sis/realizarPago";
					}	
				
				//Formulario que envía los datos del pedido y la redirección al formulario de acceso al TPV
				return '<form action="'.$action.'" method="post" id="redsys_payment_form">
				' . implode('', $resys_args_array) . '
				<input type="submit" class="button-alt" id="submit_redsys_payment_form" value="'.__('Pagar con Tarjeta', 'redsys').'" /> <a class="button cancel" href="'.$order->get_cancel_order_url().'">'.__('Cancelar Pedido', 'redsys').'</a>
				
				 </form>';
			}
			
			function receipt_page($order){
				//Esquema de logs de Redsys
				$this->log->add( 'redsys', 'Acceso a la página de confirmación de la opción de pago con tarjeta de REDSYS ');
				echo '<p>'.__('Gracias por su pedido, por favor pulsa el botón para pagar con Tarjeta.', 'redsys').'</p>';
				echo $this -> generate_redsys_form($order);

			}
			
			function process_payment($order_id){
				global $woocommerce;
				$order = new WC_Order($order_id);
				
				//Esquema de logs de Redsys
				$this->log->add( 'redsys', 'Acceso a la opción de pago con tarjeta de REDSYS ');
			
				// Return receipt_page redirect
				return array(
					'result' 	=> 'success',
					'redirect'	=> $order->get_checkout_payment_url( true )
				);
			}
			
			function check_rds_response() {

				if (!empty( $_REQUEST ) ) {
					if (!empty( $_POST ) ) {//URL DE RESP. ONLINE

						// Recogemos la clave del comercio para autenticar
						$clave=$this->clave;	
						
						// Recogemos datos de respuesta
						$total     = $_POST["Ds_Amount"];
						$pedido    = $_POST["Ds_Order"];
						$codigo    = $_POST["Ds_MerchantCode"];
						$moneda    = $_POST["Ds_Currency"];
						$respuesta = $_POST["Ds_Response"];
						$firma_remota = $_POST["Ds_Signature"];
						$fecha= $_POST["Ds_Date"];
						$hora= $_POST["Ds_Hour"];
							
						// Cálculo del SHA1
						$mensaje = $total . $pedido . $codigo . $moneda . $respuesta . $clave;
						$firma_local = strtoupper(sha1($mensaje));
						$pedido = substr($pedido,0,8);
						$pedido = intval($pedido);
							if ($firma_local == $firma_remota){
								
								// Formatear variables
								$respuesta = intval($respuesta);
								
								if ($respuesta < 101){
										$order = new WC_Order($pedido);
										$order->update_status('processing',__( 'Awaiting REDSYS payment', 'woocommerce' ));
										$this->log->add( 'redsys', 'Operación finalizada. PEDIDO ACEPTADO ');
										$order->reduce_order_stock();
										// Remove cart
										WC()->cart->empty_cart();
										//wp_redirect(WC()->plugin_url()."/includes/gateways/redsys/pages/sucess.php?pedido=".$pedido);
								}
								else {
										$order = new WC_Order($pedido);
										$order->update_status('cancelled',__( 'Awaiting REDSYS payment', 'woocommerce' ));
										$this->log->add( 'redsys', 'Operación finalizada. PEDIDO CANCELADO ');
										//wp_redirect(WC()->plugin_url()."/includes/gateways/redsys/pages/failure.php?pedido=".$pedido);
								}
							}// if (firma_local=firma_remota)
							else {
									$order = new WC_Order($pedido);
									$order->update_status('cancelled',__( 'Awaiting REDSYS payment', 'woocommerce' ));
									$this->log->add( 'redsys', 'Operación finalizada. PEDIDO CANCELADO ');
									//wp_redirect(WC()->plugin_url()."/includes/gateways/redsys/pages/failure.php?pedido=".$pedido);
								}		
					}
					else{
						wp_die( '<img src="'.home_url() .'/wp-content/plugins/redsys/pages/assets/images/Redsys.png" alt="Redys" height="70" width="242"/><br>	
						<img src="'.home_url().'/wp-content/plugins/redsys/pages/assets/images/cross.png" alt="Desactivado" title="Desactivado" />
						<b>REDSYS</b>: Fallo en el proceso de pago.<br>Su pedido ha sido cancelado.' );
					}
				} else{
						wp_die( '<img src="'.home_url() .'/wp-content/plugins/redsys/pages/assets/images/Redsys.png" alt="Redys" height="70" width="242"/><br>	
						<img src="'.home_url().'/wp-content/plugins/redsys/pages/assets/images/cross.png" alt="Desactivado" title="Desactivado" />
						<b>REDSYS</b>: Fallo en el proceso de pago.<br>Su pedido ha sido cancelado.' );
					}
										
			}
		}
		/**
		 * Add the gateway to WooCommerce
		 **/
		function add_redsys_gateway( $methods ) {
			$methods[] = 'WC_redsys'; return $methods;
		}

		add_filter('woocommerce_payment_gateways', 'add_redsys_gateway' );
	}
}