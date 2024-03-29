<?php

$args = [
  'post_type' => 'testimonial',
  'post_status' => 'published',
  'posts_per_page' => 5,
  'meta_query' => [
    [
      'key' => '_starterkit_testimonial_key',
      'value' => 's:8:"approved";i:1;s:8:"featured";i:1;',
      'compare' => 'LIKE'
    ] 
  ]
];

$query = new WP_Query($args);

if ( $query->have_posts()) :
  echo '<div class="sk-slider--wrapper"><div class="sk-slider--container"><div class="sk-slider--view"><ul>';

  $i = 1;

  while ($query->have_posts()) : $query->the_post();
    $name = get_post_meta( get_the_ID(), '_starterkit_testimonial_key', true )['name'] ?? '';
    echo '<li class="sk-slider--view__slides' . ($i === 1 ? ' is-active' : '' ) . '"><p class="testimonial-quote">' . get_the_content() . '</p><p class="testimonial-author">~ '.$name.' ~</p></li>';
    $i++;
  endwhile;

  echo '</ul></div><div class="sk-slider--arrows"><span class="arrow sk-slider--arrows__left">&#x3c;</span><span class="arrow sk-slider--arrows__right">&#x3e;</span></div></div></div>';
endif;

wp_reset_postdata();