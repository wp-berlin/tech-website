<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 04.04.18
 * Time: 18:20
 */
?>
<!doctype html>
<html <?= get_language_attributes(); ?> class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header" id="header">
    <div class="header-logo" id="logo">
        <a href="<?= home_url(); ?>">
            <?php require WP_CONTENT_DIR . '/img/logo-berlin-2-optimized.svg'; ?>
        </a>
    </div>
    <div class="header-intro" <?= is_front_page() ? 'id="intro"' : ''; ?>>
        <?php if ( ! is_front_page()) : ?>
            WordPress Meetup Berlin <span class="header-intro-highlight">Tech Edition</span>
        <?php else: ?>
            <noscript>
                WordPress Meetup Berlin <span class="header-intro-highlight">Tech Edition</span>
            </noscript>
        <?php endif; ?>
    </div>
</header>

<nav class="nav" id="nav" role="navigation">
    <div class="nav-toggle" id="toggle"></div>
    <ul class="menu">
        <li class="menu-item">
            <a href="<?= get_post_type_archive_link('ghcp'); ?>">Meeting Minutes</a>
        </li>
        <li class="menu-item">
            <a href="/contribute">Contribute</a>
        </li>
        <li class="menu-item is-dummy"></li>
        <li class="menu-item">
            <a href="/about">About</a>
        </li>
        <li class="menu-item">
            <a href="/code-of-conduct">Code of Conduct</a>
        </li>
    </ul>
</nav>

<?php if (is_front_page() || is_404()) : ?>
    <a class="link-back" href="https://wpmeetup-berlin.de/">
        Looking for the General Purpose WordPress Meetup?
    </a>
<?php endif; ?>

<main class="<?= implode(' ', apply_filters('wpberlin/website/main_classes', ['main'])); ?>">
    <div class="main-inner">
