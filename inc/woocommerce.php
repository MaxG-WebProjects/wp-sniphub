<?php
/**
 * Woocomerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Définir un délimiteur de fil d’Ariane personnalisé dans WooCommerce
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#10_Definir_un_delimiteur_de_fil_dAriane_personnalise_dans_WooCommerce
*/
add_filter( 'woocommerce_breadcrumb_defaults', 'wps_breadcrumb_delimiter' );
function wps_breadcrumb_delimiter( $defaults ) {
  $defaults['delimiter'] = ' > ';
  return $defaults;
}

////////////////////////////////////////////////////

/** Ajouter un fil d’Ariane personnalisé à l’URL d’accueil dans WooCommerce
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#11_Ajouter_un_fil_dAriane_personnalise_a_lURL_daccueil_dans_WooCommerce
*/
add_filter( 'woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url' );
function woo_custom_breadrumb_home_url() {
    return get_permalink(6);
}

////////////////////////////////////////////////////

/** Supprimer le fil d’Ariane WooCommerce dans WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#13_Supprimer_le_fil_dAriane_WooCommerce_dans_WordPress
*/
add_action('template_redirect', 'remove_shop_breadcrumbs' );
function remove_shop_breadcrumbs(){
    if (is_shop())
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0); 
}

////////////////////////////////////////////////////

/** Supprimer les avis sur les produits d’une boutique WooCommerce
via https://tutoriels.lws.fr/wordpress/snippets-wordpress#12_Supprimer_les_avis_sur_les_produits_dune_boutique_WooCommerce
*/
remove_action('woocommerce_product_tabs', 'woocommerce_product_reviews_tab', 30);
remove_action('woocommerce_product_tab_panels', 'woocommerce_product_reviews_panel', 30);

////////////////////////////////////////////////////

/** Supprimer les onglets WooCommerce dans WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#14_Supprimer_les_onglets_WooCommerce_dans_WordPress
*/
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

////////////////////////////////////////////////////

/** Rendre le remplissage du champ « numéro de téléphone » facultatif dans WooCommerce
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#15_Rendre_le_remplissage_du_champ_numero_de_telephone_facultatif_dans_WooCommerce
*/
add_filter( 'woocommerce_billing_fields', 'wps_remove_filter_phone', 10, 1 );
function wps_remove_filter_phone( $address_fields ) {
  $address_fields['billing_phone']['required'] = false;
  return $address_fields;
}

////////////////////////////////////////////////////

/** Rediriger le client vers la page “ Panier ” et sauter la page “ Commande
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#16_Rediriger_le_client_vers_la_page_Panier_et_sauter_la_page_Commande
*/
add_filter( 'add_to_cart_redirect', 'redirect_to_checkout' );
function redirect_to_checkout() {
 global $woocommerce;
 $checkout_url = $woocommerce->cart->get_checkout_url();  
 return $checkout_url;
}

////////////////////////////////////////////////////
