<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
the_post();
$value = static function ( $name, $fallback = '' ) { $field = function_exists( 'get_field' ) ? get_field( $name ) : ''; return $field ?: $fallback; };
$phone = function_exists( 'get_field' ) ? ( get_field( 'phone', 'option' ) ?: '+7 902 513-52-22' ) : '+7 902 513-52-22';
$phone_href = preg_replace( '/[^0-9+]/', '', $phone );
$stops = $value( 'stops', array() );
$included = $value( 'included', array() );
$gallery = $value( 'gallery_urls', array() );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Prata&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/styles.css?ver=' . filemtime( get_template_directory() . '/assets/styles.css' ) ); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'expedition-page' ); ?>>
<?php wp_body_open(); ?>
<header class="header expedition-header" id="header">
  <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><svg viewBox="0 0 54 54"><circle cx="27" cy="27" r="25"></circle><path d="M10 35c7-2 10-12 16-17 3 5 7 9 17 17M12 38c10-4 20-4 30 0"></path></svg><span>БАЙКАЛ<small>СЕВЕР</small></span></a>
  <nav class="nav"><a href="<?php echo esc_url( home_url( '/#tours' ) ); ?>">Экскурсии</a><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>">О нас</a><a href="<?php echo esc_url( home_url( '/#transport' ) ); ?>">Транспорт</a><a href="<?php echo esc_url( home_url( '/#contacts' ) ); ?>">Контакты</a></nav>
  <div class="header-contact"><a href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a><span>Ежедневно 09:00–20:00</span></div>
  <button class="menu-button" id="menuButton" type="button" aria-label="Открыть меню" aria-expanded="false"><span></span><span></span></button>
</header>

<main>
  <section class="exp-hero" style="--exp-bg:url('<?php echo esc_url( $value( 'hero_url' ) ); ?>')">
    <div class="exp-hero-shade"></div>
    <div class="exp-hero-content">
      <a class="exp-back" href="<?php echo esc_url( home_url( '/#tours' ) ); ?>">← Все путешествия</a>
      <p class="eyebrow light"><?php echo esc_html( $value( 'eyebrow' ) ); ?></p>
      <h1><?php the_title(); ?></h1>
      <p><?php echo esc_html( $value( 'subtitle', get_the_excerpt() ) ); ?></p>
      <a class="button button-accent" href="#booking">Забронировать <span>↗</span></a>
    </div>
    <div class="exp-summary">
      <div><small>Стоимость</small><strong>от <?php echo esc_html( $value( 'price' ) ); ?></strong></div>
      <div><small>Продолжительность</small><strong><?php echo esc_html( $value( 'duration' ) ); ?></strong></div>
      <div><small>Старт</small><strong><?php echo esc_html( $value( 'departure' ) ); ?></strong></div>
      <div><small>Сезон</small><strong><?php echo esc_html( $value( 'season' ) ); ?></strong></div>
    </div>
  </section>

  <section class="exp-route section">
    <div class="exp-section-title"><p class="eyebrow">Маршрут дня</p><h2>Путь, где каждая<br><em>остановка — событие</em></h2><p><?php echo esc_html( $value( 'route_intro' ) ); ?></p></div>
    <div class="route-line">
      <?php foreach ( $stops as $index => $stop ) : ?>
        <article class="route-stop"><span class="route-dot"><?php echo esc_html( $index + 1 ); ?></span><time><?php echo esc_html( $stop['time'] ); ?></time><h3><?php echo esc_html( $stop['title'] ); ?></h3><p><?php echo esc_html( $stop['text'] ); ?></p></article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="exp-details section">
    <div><p class="eyebrow light">Продумали детали</p><h2>В путешествии<br><em>всё уже включено</em></h2></div>
    <ul class="included-list"><?php foreach ( $included as $index => $item ) : ?><li><span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span><?php echo esc_html( $item['item'] ); ?></li><?php endforeach; ?></ul>
    <div class="exp-facts"><div><small>Группа</small><strong><?php echo esc_html( $value( 'group_size' ) ); ?></strong></div><div><small>Сложность</small><strong><?php echo esc_html( $value( 'difficulty' ) ); ?></strong></div></div>
  </section>

  <section class="exp-gallery section">
    <div class="exp-section-title"><p class="eyebrow">Истории гостей</p><h2>Байкал глазами<br><em>путешественников</em></h2></div>
    <div class="people-gallery"><?php foreach ( $gallery as $image ) : ?><figure><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['caption'] ); ?>" loading="lazy"><figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption></figure><?php endforeach; ?></div>
  </section>

  <section class="exp-booking section" id="booking">
    <div><p class="eyebrow light">Готовы отправиться?</p><h2>Забронируйте<br><em><?php the_title(); ?></em></h2><p>Оставьте телефон — менеджер подтвердит наличие мест и ответит на вопросы.</p></div>
    <form class="form" id="requestForm"><label>Ваше имя<input type="text" name="name" placeholder="Как к вам обращаться?"></label><label>Телефон<input type="tel" name="phone" placeholder="+7 (___) ___-__-__" required></label><label>Желаемая дата<input type="date" name="date"></label><button class="button button-accent submit" type="submit">Отправить заявку <span>↗</span></button><small>Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности.</small></form>
  </section>
</main>
<footer class="footer"><div class="footer-bottom"><span>© 2026 Байкал Север</span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a><a href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a></div></footer>
<div class="toast" id="toast">Спасибо! Мы свяжемся с вами в ближайшее время.</div>
<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/script.js?ver=' . filemtime( get_template_directory() . '/assets/script.js' ) ); ?>"></script>
<?php wp_footer(); ?>
</body></html>
