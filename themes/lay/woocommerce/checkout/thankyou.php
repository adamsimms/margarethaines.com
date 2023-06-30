<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	// error_log(print_r($order, true));
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
                    <div><?php esc_html_e( 'Order number', 'woocommerce' ); ?></div>
					<div><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</li>

				<li class="woocommerce-order-overview__date date">
                    <div><?php esc_html_e( 'Date', 'woocommerce' ); ?></div>
					<div><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
                        <div><?php esc_html_e( 'Email', 'woocommerce' ); ?></div>
						<div><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
                    <div><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
					<div><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
                        <div><?php esc_html_e( 'Payment method', 'woocommerce' ); ?></div>
						<div><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></div>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : 
		// order is empty. I put sample data here so people can see what it looks like in the customizer and style it ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

		<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
			<li class="woocommerce-order-overview__order order">
				<div>Order number</div>
				<div>1090</div>
			</li>
			<li class="woocommerce-order-overview__date date">
				<div>Date</div>
				<div>March 25, 1999</div>
			</li>
			<li class="woocommerce-order-overview__email email">
				<div>Email</div>
				<div>sample.mail@gmail.com</div>
			</li>
			<li class="woocommerce-order-overview__total total">
				<div>Total</div>
				<div><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">€</span>32,13</bdi></span></div>
			</li>
			<li class="woocommerce-order-overview__payment-method method">
				<div>Payment method</div>
				<div>Cash on delivery</div>
			</li>
		</ul>

		<p>Pay with cash upon delivery.</p>
		<section class="woocommerce-order-details">
			<h2 class="woocommerce-order-details__title">Order details</h2>
			<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
				<thead>
					<tr>
						<th class="woocommerce-table__product-name product-name">Product</th>
						<th class="woocommerce-table__product-table product-total">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr class="woocommerce-table__line-item order_item">
						<td class="woocommerce-table__product-name product-name">
							<a href="http://laythemereact.test/product/heart-top/">Heart Top</a> <strong class="product-quantity">×&nbsp;1</strong>
						</td>
						<td class="woocommerce-table__product-total product-total">
							<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">€</span>23,00</bdi></span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th scope="row">Subtotal</th>
						<td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">€</span>23,00</span></td>
					</tr>
					<tr>
						<th scope="row">Shipping</th>
						<td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">€</span>4,00</span>&nbsp;<small class="shipped_via">via Flat rate</small></td>
					</tr>
					<tr>
						<th scope="row">Tax</th>
						<td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">€</span>5,13</span></td>
					</tr>
					<tr>
						<th scope="row">Payment method</th>
						<td>Cash on delivery</td>
					</tr>
					<tr>
						<th scope="row">Total</th>
						<td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">€</span>32,13</span></td>
					</tr>
				</tfoot>
			</table>
		</section>

		<section class="woocommerce-customer-details">
			<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
				<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
					<h2 class="woocommerce-column__title">Billing address</h2>
					<div class="lay-woocommerce-address-wrap">
						<address>
							Sample Name<br>Sample Street<br>233<br>10969 Berlin
							<p class="woocommerce-customer-details--phone">01512345678</p>

							<p class="woocommerce-customer-details--email">sample.email@gmail.com</p>
						</address>
					</div>
				</div><!-- /.col-1 -->
				<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
					<h2 class="woocommerce-column__title">Shipping address</h2>
					<div class="lay-woocommerce-address-wrap">
						<address>Sample Name<br>Sample Street<br>233<br>10969 Berlin</address>
					</div>
				</div><!-- /.col-2 -->
			</section><!-- /.col2-set -->
		</section>

	<?php endif; ?>

</div>
