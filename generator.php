#!/usr/bin/php

<?php

function slugify($text) { 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}

function generate_posts($feed_url, $tag){
  $content = file_get_contents($feed_url);
  $x = new SimpleXMLElement($content);

  $i = 10;
  foreach($x->channel->item as $item){

    $title = $item->title;
    $link = $item->link;
    //hehe hack
    $secondCheat = $i + 10;
    $date = date("Y-m-d G:i").":".$secondCheat;

    $post_details = 
"---
layout: post
title: \"".$title."\"
date: \"".$date."\"
tags: ".$tag."
link: \"".$link."\"
---
Hellio
    ";

    echo $post_details;

    $post = '_posts/'.date('Y-m-d').'-'.slugify($title).'.markdown';
    file_put_contents($post, $post_details);

    $i--;

  };


}

function clear_posts(){
  $files = glob('_posts/*');
  foreach($files as $file){
    if(is_file($file)){
      unlink($file);
    };
  };
}


//clear out current posts directory
clear_posts();

//amazon top movies
//This is hte best sellers, the tag code is "bs"
generate_posts("http://www.amazon.com/gp/rss/bestsellers/movies-tv/2649512011/ref=zg_bs_2649512011_rsslink", "bs");
generate_posts("http://www.amazon.com/gp/rss/top-rated/movies-tv/2649512011/ref=zg_tr_2649512011_rsslink", "tr");

generate_posts("http://www.amazon.com/gp/rss/bestsellers/movies-tv/2858905011/ref=zg_bs_2858905011_rsslink", "bsim");

generate_posts("http://www.amazon.com/gp/rss/top-rated/movies-tv/2858905011/ref=zg_bs_2858905011_rsslink", "trim");

?>
