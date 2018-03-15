<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
	        <tbody>
	            <?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
	            	
	                <tr>
	                    <td class="label">
	                    	<label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label($name,$product); ?></label>
	                	</td>
	                </tr> 
	                <tr>   
	                    <td class="value">
                            <fieldset>
		                        <?php
		                            if ( is_array( $options ) ) {
		                                $select_options = array();
		                                if ( empty( $_POST ) )
		                                    $selected_value = ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) ? $selected_attributes[ sanitize_title( $name ) ] : '';
		                                else
		                                    $selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $name ) ] : '';
		 
		                                // Get terms if this is a taxonomy - ordered
		                                if ( taxonomy_exists( sanitize_title( $name ) ) ) {
		 
		                                    $terms = get_terms( sanitize_title($name), array('menu_order' => 'ASC') );
		 									$counter = 0;
		 									?>
		 									<ul>
		 									<?php
		                                    foreach ( $terms as $term ) { ?>
		                                    	<li>
		                                    	<?php
		                                        if ( ! in_array( $term->slug, $options ) ) continue;
                                                    $select_options[] =  '<option value="' . $term->slug . '" ' . selected( $selected_value, $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                                    echo '<input type="radio" value="' . $term->slug . '" ' . checked( $selected_value, $term->slug, false ) . ' id="'. esc_attr( sanitize_title($name) ) .'_radio_' . $counter . '" name="attribute_'. sanitize_title($name).'_radio"><label for="' . esc_attr( sanitize_title($name) ) .'_radio_' . $counter . '">' . apply_filters( 'woocommerce_variation_option_name', $term->name ).'</label><br />';
                                                $counter++;
                                               ?> 
                                               </li>
                                               <?php
		                                    } ?>
		                                	</ul>
		                                <?php } else { ?>
		                                	<ul>
		                                    <?php 
		                                    $counter = 0;
		                                    foreach ( $available_variations as $option ) { ?>
		                                    	<li>
	                                                <?php $select_options[] = '<option value="' . $option['attributes']['attribute_size'] . '" ' . selected( $selected_value, $option['attributes']['attribute_size'], false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $option['attributes']['attribute_size'] ) . '</option>';
			                                        	  echo '<input type="radio" value="' . $option['attributes']['attribute_size'] . '" ' . checked( $selected_value, $option['attributes']['attribute_size'], false ) . ' id="'. esc_attr( sanitize_title($name) ) .'_radio_' . $counter . '" name="attribute_'. sanitize_title($name).'_radio"><label for="' . esc_attr( sanitize_title($name) ) .'_radio_' . $counter . '">' . apply_filters( 'woocommerce_variation_option_name', $option['attributes']['attribute_size'] ); ?></label>	
	                                            	<p><?php echo $option['dimensions']; ?></p>
	                                            	<?php echo $option['variation_description'];
	                                            		  echo $option['price_html']; ?>
	                                            </li>	

	                                        <?php $counter++;    
                                             } ?>
                                            </ul>
                                        <?php }
		                            }
		                        ?>
	                   	 	</fieldset>
                            <script>
                                jQuery('input[name="attribute_<?php echo sanitize_title($name); ?>_radio"]').click(function() {
                                        jQuery('#<?php echo esc_attr( sanitize_title($name) ); ?>').val(this.value);
                                        jQuery('#<?php echo esc_attr( sanitize_title($name) ); ?>').trigger('change');
                                });
                            </script>
                            <select style="display: none" id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>">
                                <option value="">
                                <?php foreach($select_options as $option) echo $option; ?>
                            </select>
                        <?php
                        	if ( sizeof($attributes) == $loop )
                            //echo '<a class="reset_variations" href="#reset">'.__('Clear selection', 'woocommerce').'</a>'; style="display: none"
                		?></td>
	                </tr>
	            <?php endforeach;?>
	        </tbody>
	    </table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
