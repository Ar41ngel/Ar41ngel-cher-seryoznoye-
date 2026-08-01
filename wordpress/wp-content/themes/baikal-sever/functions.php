<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	static function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	}
);

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title' => 'Настройки сайта «Байкал Север»',
				'menu_title' => 'Байкал Север',
				'menu_slug'  => 'baikal-sever-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
				'icon_url'   => 'dashicons-palmtree',
				'position'   => 3,
			)
		);

		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_baikal_site_settings',
				'title'    => 'Главный экран и контакты',
				'fields'   => array(
					array(
						'key'           => 'field_baikal_brand',
						'label'         => 'Название бренда',
						'name'          => 'brand_name',
						'type'          => 'text',
						'default_value' => 'БАЙКАЛ',
					),
					array(
						'key'           => 'field_baikal_brand_suffix',
						'label'         => 'Подпись бренда',
						'name'          => 'brand_suffix',
						'type'          => 'text',
						'default_value' => 'СЕВЕР',
					),
					array(
						'key'           => 'field_baikal_hero_title',
						'label'         => 'Заголовок первого экрана',
						'name'          => 'hero_title',
						'type'          => 'textarea',
						'rows'          => 3,
						'instructions'  => 'Допустимы теги <br> и <em> для переноса и цветового акцента.',
						'default_value' => 'Место, где<br><em>дышится иначе</em>',
					),
					array(
						'key'           => 'field_baikal_hero_text',
						'label'         => 'Описание первого экрана',
						'name'          => 'hero_text',
						'type'          => 'textarea',
						'rows'          => 3,
						'default_value' => 'Покажем настоящий Байкал — от прозрачного льда до тихих летних бухт. Маленькие группы, свои гиды и транспорт.',
					),
					array(
						'key'           => 'field_baikal_phone',
						'label'         => 'Телефон',
						'name'          => 'phone',
						'type'          => 'text',
						'default_value' => '+7 902 513-52-22',
					),
					array(
						'key'           => 'field_baikal_email',
						'label'         => 'E-mail',
						'name'          => 'email',
						'type'          => 'email',
						'default_value' => 'hello@baikal-sever.ru',
					),
					array(
						'key'           => 'field_baikal_address',
						'label'         => 'Адрес',
						'name'          => 'address',
						'type'          => 'textarea',
						'rows'          => 2,
						'default_value' => "Иркутская область, Листвянка\nул. Горького, 33",
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'baikal-sever-settings',
						),
					),
				),
			)
		);
	}
);
