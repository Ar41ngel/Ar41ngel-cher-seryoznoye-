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

add_action(
	'init',
	static function () {
		register_post_type(
			'expedition',
			array(
				'labels'       => array(
					'name'          => 'Экспедиции',
					'singular_name' => 'Экспедиция',
					'add_new_item'  => 'Добавить экспедицию',
					'edit_item'     => 'Редактировать экспедицию',
				),
				'public'       => true,
				'has_archive'  => true,
				'menu_icon'    => 'dashicons-location-alt',
				'rewrite'      => array( 'slug' => 'expeditions' ),
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
				'show_in_rest' => true,
			)
		);
	}
);

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_baikal_expedition',
				'title'    => 'Детали экспедиции',
				'fields'   => array(
					array( 'key' => 'field_exp_eyebrow', 'label' => 'Надзаголовок', 'name' => 'eyebrow', 'type' => 'text' ),
					array( 'key' => 'field_exp_subtitle', 'label' => 'Краткое описание', 'name' => 'subtitle', 'type' => 'textarea', 'rows' => 3 ),
					array( 'key' => 'field_exp_price', 'label' => 'Цена', 'name' => 'price', 'type' => 'text' ),
					array( 'key' => 'field_exp_duration', 'label' => 'Продолжительность', 'name' => 'duration', 'type' => 'text' ),
					array( 'key' => 'field_exp_departure', 'label' => 'Место старта', 'name' => 'departure', 'type' => 'text' ),
					array( 'key' => 'field_exp_season', 'label' => 'Сезон', 'name' => 'season', 'type' => 'text' ),
					array( 'key' => 'field_exp_group', 'label' => 'Размер группы', 'name' => 'group_size', 'type' => 'text' ),
					array( 'key' => 'field_exp_difficulty', 'label' => 'Сложность', 'name' => 'difficulty', 'type' => 'text' ),
					array( 'key' => 'field_exp_hero', 'label' => 'URL главной фотографии', 'name' => 'hero_url', 'type' => 'url' ),
					array( 'key' => 'field_exp_route_intro', 'label' => 'Описание маршрута', 'name' => 'route_intro', 'type' => 'textarea', 'rows' => 3 ),
					array(
						'key' => 'field_exp_stops', 'label' => 'Остановки', 'name' => 'stops', 'type' => 'repeater', 'layout' => 'table',
						'sub_fields' => array(
							array( 'key' => 'field_exp_stop_time', 'label' => 'Время', 'name' => 'time', 'type' => 'text' ),
							array( 'key' => 'field_exp_stop_title', 'label' => 'Место', 'name' => 'title', 'type' => 'text' ),
							array( 'key' => 'field_exp_stop_text', 'label' => 'Что делаем', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
						),
					),
					array(
						'key' => 'field_exp_included', 'label' => 'Что включено', 'name' => 'included', 'type' => 'repeater', 'layout' => 'table',
						'sub_fields' => array(
							array( 'key' => 'field_exp_included_item', 'label' => 'Пункт', 'name' => 'item', 'type' => 'text' ),
						),
					),
					array(
						'key' => 'field_exp_gallery', 'label' => 'Фотографии путешественников', 'name' => 'gallery_urls', 'type' => 'repeater', 'layout' => 'block',
						'sub_fields' => array(
							array( 'key' => 'field_exp_gallery_url', 'label' => 'URL фотографии', 'name' => 'url', 'type' => 'url' ),
							array( 'key' => 'field_exp_gallery_caption', 'label' => 'Подпись', 'name' => 'caption', 'type' => 'text' ),
						),
					),
				),
				'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'expedition' ) ) ),
			)
		);

		if ( get_option( 'baikal_expeditions_seeded_v1' ) ) {
			return;
		}

		$shared_gallery = array(
			array( 'url' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=86', 'caption' => 'Новые знакомства в путешествии' ),
			array( 'url' => 'https://images.unsplash.com/photo-1506869640319-fe1a24fd76dc?auto=format&fit=crop&w=1200&q=86', 'caption' => 'Остановка с видом на Байкал' ),
			array( 'url' => 'https://images.unsplash.com/photo-1521336575822-6da63fb45455?auto=format&fit=crop&w=1200&q=86', 'caption' => 'Время для личных открытий' ),
			array( 'url' => 'https://images.unsplash.com/photo-1539635278303-d4002c07eae3?auto=format&fit=crop&w=1200&q=86', 'caption' => 'Моменты, которые остаются' ),
		);

		$expeditions = array(
			'olkhon' => array(
				'title' => 'Ольхон — сердце Байкала', 'eyebrow' => '1 день · из Иркутска', 'price' => '8 900 ₽', 'duration' => '14 часов', 'departure' => 'Иркутск', 'season' => 'май — октябрь', 'group_size' => 'до 15 гостей', 'difficulty' => 'лёгкая',
				'subtitle' => 'Большое путешествие к сакральному центру Байкала: степи, скалы, шаманские легенды и закат над Малым морем.',
				'hero_url' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=2200&q=90',
				'route_intro' => 'За один день проедем от Иркутска через Тажеранские степи к острову Ольхон и соберём главные виды Малого моря.',
				'stops' => array( array( 'time'=>'07:00','title'=>'Иркутск','text'=>'Встреча с гидом и выезд.' ), array( 'time'=>'10:30','title'=>'Тажеранские степи','text'=>'Панорамная остановка и знакомство с местной культурой.' ), array( 'time'=>'12:30','title'=>'Хужир','text'=>'Обед из сибирских продуктов.' ), array( 'time'=>'14:00','title'=>'Скала Шаманка','text'=>'Прогулка к главному символу Ольхона.' ), array( 'time'=>'17:00','title'=>'Сарайский пляж','text'=>'Свободное время у воды и фотографии.' ) ),
			),
			'peschanaya-bay' => array(
				'title' => 'Бухта Песчаная на катере', 'eyebrow' => '10 часов · из Листвянки', 'price' => '9 500 ₽', 'duration' => '10 часов', 'departure' => 'Листвянка', 'season' => 'июнь — сентябрь', 'group_size' => 'до 11 гостей', 'difficulty' => 'лёгкая',
				'subtitle' => 'День на воде среди прозрачных бухт, скалистых мысов и знаменитых ходульных деревьев.',
				'hero_url' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd4297?auto=format&fit=crop&w=2200&q=90',
				'route_intro' => 'Пройдём вдоль западного берега Байкала на скоростном катере и высадимся в одной из самых красивых бухт озера.',
				'stops' => array( array( 'time'=>'09:00','title'=>'Листвянка','text'=>'Инструктаж и выход на воду.' ), array( 'time'=>'10:20','title'=>'Скрипер','text'=>'Осмотр отвесных скал с воды.' ), array( 'time'=>'12:00','title'=>'Бухта Песчаная','text'=>'Высадка, прогулка и обед-пикник.' ), array( 'time'=>'14:30','title'=>'Бухта Бабушка','text'=>'Короткий треккинг и купание по погоде.' ), array( 'time'=>'18:30','title'=>'Листвянка','text'=>'Возвращение в порт.' ) ),
			),
			'baikal-ice' => array(
				'title' => 'Лёд Байкала на хивусе', 'eyebrow' => '7 часов · из Листвянки', 'price' => '7 900 ₽', 'duration' => '7 часов', 'departure' => 'Листвянка', 'season' => 'февраль — март', 'group_size' => 'до 9 гостей', 'difficulty' => 'лёгкая',
				'subtitle' => 'Путешествие по самому прозрачному льду: пузырьки, трещины, гроты и зимний пикник.',
				'hero_url' => 'https://images.unsplash.com/photo-1483347756197-71ef80e95f73?auto=format&fit=crop&w=2200&q=90',
				'route_intro' => 'На судне на воздушной подушке доберёмся до труднодоступных ледовых локаций и безопасно исследуем зимний Байкал.',
				'stops' => array( array( 'time'=>'10:00','title'=>'Листвянка','text'=>'Экипировка и выход на лёд.' ), array( 'time'=>'10:40','title'=>'Пузырьковый лёд','text'=>'Первая фотостоп-локация.' ), array( 'time'=>'12:00','title'=>'Ледовые гроты','text'=>'Прогулка вдоль наплесков и сосулек.' ), array( 'time'=>'14:00','title'=>'Пикник на льду','text'=>'Горячий обед и чай из сибирских трав.' ), array( 'time'=>'16:30','title'=>'Листвянка','text'=>'Возвращение на берег.' ) ),
			),
			'arshan-sayan' => array(
				'title' => 'Аршан и Восточные Саяны', 'eyebrow' => '1 день · из Иркутска', 'price' => '6 800 ₽', 'duration' => '13 часов', 'departure' => 'Иркутск', 'season' => 'круглый год', 'group_size' => 'до 15 гостей', 'difficulty' => 'средняя',
				'subtitle' => 'Горная долина у подножия Саян: водопады, минеральные источники и бурятская кухня.',
				'hero_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=2200&q=90',
				'route_intro' => 'Пересечём Тункинскую долину, пройдём по горной тропе и познакомимся с природой и вкусами Бурятии.',
				'stops' => array( array( 'time'=>'07:00','title'=>'Иркутск','text'=>'Выезд по Култукскому тракту.' ), array( 'time'=>'09:30','title'=>'Култук','text'=>'Видовая остановка на южный Байкал.' ), array( 'time'=>'11:30','title'=>'Аршан','text'=>'Прогулка по горному посёлку.' ), array( 'time'=>'13:00','title'=>'Водопад','text'=>'Треккинг по живописной тропе.' ), array( 'time'=>'16:00','title'=>'Минеральный источник','text'=>'Дегустация воды и местный рынок.' ) ),
			),
		);

		foreach ( $expeditions as $slug => $data ) {
			$existing = get_page_by_path( $slug, OBJECT, 'expedition' );
			$post_id  = $existing ? $existing->ID : wp_insert_post( array( 'post_type' => 'expedition', 'post_status' => 'publish', 'post_title' => $data['title'], 'post_name' => $slug, 'post_content' => $data['subtitle'] ) );
			if ( ! is_wp_error( $post_id ) ) {
				foreach ( $data as $field => $value ) {
					if ( 'title' !== $field ) {
						update_field( $field, $value, $post_id );
					}
				}
				update_field( 'included', array( array( 'item'=>'Транспорт по маршруту' ), array( 'item'=>'Сопровождение местного гида' ), array( 'item'=>'Питание по программе' ), array( 'item'=>'Входные билеты и сборы' ), array( 'item'=>'Страховка путешественника' ) ), $post_id );
				update_field( 'gallery_urls', $shared_gallery, $post_id );
			}
		}
		update_option( 'baikal_expeditions_seeded_v1', 1 );
		flush_rewrite_rules( false );
	},
	20
);
