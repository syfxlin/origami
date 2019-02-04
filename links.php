<?php
/**
 * Template Name: Links
 */
get_header(); ?>

<main class="container">
	<div class="page-friends page-common row">
		<?php if (have_posts()): ?>
			<?php while (have_posts()) : the_post(); ?>
				<h1 class="page-title" style="margin-top:100px;text-align:center;font-size:37px;font-style:italic"><?php the_title(); ?></h1>
				<article class="page-content" style="text-align:center;">
					<?php the_content(); ?>
				</article>
			<?php endwhile;  ?>
		<?php endif; ?>
<style>
    .clearfix {zoom:1;}
    .clearfix:after {content:”.”;display:block;visibility:hidden;height:0;clear:both;}
    .readers-list {list-style:none;}
    .readers-list *{margin:0;padding:0;}
    .readers-list li{position:relative;float:left;margin:6px 6px;height:205px;!important;}
    .readers-list li > a {
	border: 1px solid #eee;
	display: block;
	width: 100%;
	height: 100%;
	text-align: center;
	transition:all .5s;
    -webkit-box-shadow: 0 2px 1px -1px rgba(0, 0, 0, .2), 0 1px 1px 0 rgba(0, 0, 0, .14), 0 1px 3px 0 rgba(0, 0, 0, .12);
          box-shadow: 0 2px 1px -1px rgba(0, 0, 0, .2), 0 1px 1px 0 rgba(0, 0, 0, .14), 0 1px 3px 0 rgba(0, 0, 0, .12);
    }
    .readers-list li>a {
      -webkit-transition: -webkit-box-shadow .25s cubic-bezier(.4, 0, .2, 1);
          transition: -webkit-box-shadow .25s cubic-bezier(.4, 0, .2, 1);
          transition:         box-shadow .25s cubic-bezier(.4, 0, .2, 1);
          transition:         box-shadow .25s cubic-bezier(.4, 0, .2, 1), -webkit-box-shadow .25s cubic-bezier(.4, 0, .2, 1);

      will-change: box-shadow;
    }
    .readers-list li>a:hover,
    .readers-list li>a:focus {
      -webkit-box-shadow: 0 5px 5px -3px rgba(0, 0, 0, .2), 0 8px 10px 1px rgba(0, 0, 0, .14), 0 3px 14px 2px rgba(0, 0, 0, .12);
          box-shadow: 0 5px 5px -3px rgba(0, 0, 0, .2), 0 8px 10px 1px rgba(0, 0, 0, .14), 0 3px 14px 2px rgba(0, 0, 0, .12);
    }
    #links_info {
        position: absolute;
        bottom: 0px;
        padding-bottom: 10px;
        background: #000;
        width: 100%;
        height: 200px;
        -webkit-mask : -webkit-gradient(linear, center top, center bottom, from(rgba(0,0,0,0)), to(rgba(0,0,0,0.7)));
    }
    #links_icon {
        width: 70px;
        height: 70px;
        position: absolute;
        border-radius: 50%;
        top: 15px;
        right: 15px;
    }
    .readers-list em{
	    position: absolute;
	    top: 110px;
	    left: 15px;
	    font-size: 25px;
	    color: #fff;
    }
.readers-list span {
	position: absolute;
	top:155px;
	font-size: 18px;
	left: 15px;
	width: auto;
	color: #fff;
	font-style: italic;
}
@media(min-width:750px){
    .readers-list {margin: 0px auto;width:750px;}
    .readers-list li{width:355px;}
}
@media(max-width:749px){
    .readers-list {margin: 0px auto;width:375px;}
    .readers-list li{width:355px;}
}
</style>
		<div>
			<?php
			    global $wpdb;
                $qlink="select link_url,link_name,link_image,link_notes,link_description,link_rss from wp_links where link_visible='Y' order by link_id"; 
                $links = $wpdb->get_results($qlink);
                if(empty($links)) {
                    echo '<p>暂无友链数据！</p>';
                } else {
                    function retain_key_shuffle(array &$arr){
                        if (!empty($arr)) {
                            $key = array_keys($arr);
                            shuffle($key);
                            foreach ($key as $value) {
                              $arr2[$value] = $arr[$value];
                            }
                            $arr = $arr2;
                        }
                    }
                    retain_key_shuffle($links);
                    foreach ($links as $comment) {
                        $tmp = "<li><a rel=\"nofollow\" title=".$comment->link_url." target=\"_blank\" href=\"$comment->link_url\" style=\"background-image:url($comment->link_image);background-size: cover;\"><div id=\"links_info\"></div><em>".$comment->link_name."</em><span>".$comment->link_notes."</span><img id=\"links_icon\" src=\"$comment->link_rss\"></img></a></li>";   
                        $output1 .= $tmp;
                    }
                    $output1 = "<ul class=\"readers-list clearfix\">".$output1."</ul>";
                    echo $output1;
                }
            ?>
		</div>
		<div style="text-align:center;font-size:18px;margin:10px 0px;">此页模板由<a href="https://www.ixk.me">Otstar-Lin</a>于2018制作,源码已上传至<a href="https://github.com/syfxlin/wp-links-template">Github</a></div>
	</div>
</main>
<?php get_footer(); ?>