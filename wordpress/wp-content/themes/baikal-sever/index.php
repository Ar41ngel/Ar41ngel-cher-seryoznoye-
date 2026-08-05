<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$template_file = get_template_directory() . '/assets/index.html';
$html          = file_get_contents( $template_file );

if ( false === $html ) {
	status_header( 500 );
	echo 'Шаблон сайта не найден.';
	exit;
}

$option = static function ( $name, $fallback ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, 'option' );
		if ( null !== $value && false !== $value && '' !== $value ) {
			return $value;
		}
	}
	return $fallback;
};

$brand        = sanitize_text_field( $option( 'brand_name', 'БАЙКАЛ' ) );
$brand_suffix = sanitize_text_field( $option( 'brand_suffix', 'СЕВЕР' ) );
$hero_title   = wp_kses( $option( 'hero_title', 'Место, где<br><em>дышится иначе</em>' ), array( 'br' => array(), 'em' => array() ) );
$hero_text    = esc_html( $option( 'hero_text', 'Покажем настоящий Байкал — от прозрачного льда до тихих летних бухт. Маленькие группы, свои гиды и транспорт.' ) );
$phone        = sanitize_text_field( $option( 'phone', '+7 902 513-52-22' ) );
$phone_href   = preg_replace( '/[^0-9+]/', '', $phone );
$email        = sanitize_email( $option( 'email', 'hello@baikal-sever.ru' ) );
$address      = nl2br( esc_html( $option( 'address', "Иркутская область, Листвянка\nул. Горького, 33" ) ) );

$html = str_replace(
	array(
		'href="styles.css"',
		'src="script.js"',
		'БАЙКАЛ<small>СЕВЕР</small>',
		'<h1>Место, где<br><em>дышится иначе</em></h1>',
		'Покажем настоящий Байкал — от прозрачного льда до тихих летних бухт. Маленькие группы, свои гиды и транспорт.',
		'+7 902 513-52-22',
		'href="tel:+79025135222"',
		'hello@baikal-sever.ru',
		'Иркутская область, Листвянка<br>ул. Горького, 33',
	),
	array(
		'href="' . esc_url( get_template_directory_uri() . '/assets/styles.css?ver=' . filemtime( get_template_directory() . '/assets/styles.css' ) ) . '"',
		'src="' . esc_url( get_template_directory_uri() . '/assets/script.js' ) . '"',
		esc_html( $brand ) . '<small>' . esc_html( $brand_suffix ) . '</small>',
		'<h1>' . $hero_title . '</h1>',
		$hero_text,
		esc_html( $phone ),
		'href="tel:' . esc_attr( $phone_href ) . '"',
		esc_html( $email ),
		$address,
	),
	$html
);

ob_start();
wp_head();
$wp_head = ob_get_clean();

ob_start();
wp_footer();
$wp_footer = ob_get_clean();

$html = str_replace( '</head>', $wp_head . '</head>', $html );
$html = str_replace( '</body>', $wp_footer . '</body>', $html );

echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
