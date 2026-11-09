<?php
// Focused checks run in an isolated WordPress installation.
$post_id = wp_insert_post(array('post_title' => 'Example title', 'post_status' => 'publish'));
if (is_wp_error($post_id) || !$post_id) throw new RuntimeException('Could not create post');
global $wp_query;
$wp_query->is_singular = true;
$wp_query->in_the_loop = true;
if (wptr_suppress_title('Example title', $post_id) !== 'Example title') throw new RuntimeException('Visible title changed');
update_post_meta($post_id, 'wptr_hide_title', '1');
if (wptr_suppress_title('Example title', $post_id) !== '') throw new RuntimeException('Hidden title was displayed');
$wp_query->in_the_loop = false;
if (wptr_suppress_title('Example title', $post_id) !== 'Example title') throw new RuntimeException('Title hidden outside loop');
echo "PASS visible and hidden titles\n";
