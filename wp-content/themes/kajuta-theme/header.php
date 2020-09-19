<?php
/**
 * Récupération de :
 * - Langue du site pour l'attribut html lang=""
 * - L'auteur de thème pour la meta author
 * - La description du site pour la meta description
 */
$htmlLangAttr = get_language_attributes('html');

$themeDatas = wp_get_theme();
$htmlAuthor = esc_html($themeDatas->get('Author'));
$htmlDescription = esc_html(get_bloginfo('description'));
?>

<!doctype html>
<html <?= $htmlLangAttr ?> >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= $htmlDescription ?>">
    <meta name="author" content="<?= $htmlAuthor ?>">

    <?php wp_head(); ?>
</head>
<body class="h-100 text-center text-white kajuta-font-regular" id="ref-header">
    <div class="container-fluid d-flex w-100 h-100 mx-auto flex-column p-0">