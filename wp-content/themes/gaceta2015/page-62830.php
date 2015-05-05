<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$cat_filter = isset($_GET['c']) ? $_GET['c'] : "";
$cat_filter = ($cat_filter == 'todos') ? '' : $cat_filter;
$tax = 'secciones';
$oterm = 'avisos';
$term = get_term_by('slug', $oterm, $tax);
$termChildren = get_term_children($term->term_id, $tax);
$wp_query = new WP_Query();

if ($cat_filter == '') {
	$wp_query->query(
		array(
			'posts_per_page' => '6',
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'secciones',
					'field' => 'slug',
					'terms' => 'avisos',
				),
			),
		)
	);
} else {
	$wp_query->query(
		array(
			'posts_per_page' => '6',
			'paged' => $paged,
			'tax_query' => array(
				array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'secciones',
						'field' => 'slug',
						'terms' => 'avisos',
					),
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $cat_filter,
					),
				),
			),
		)
	);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="">
	<title>Avisos</title>
	<!-- Bootstrap core CSS -->
	<link href="<?php echo THEME_URL;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo THEME_URL;?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/fonts.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/libraries/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>/css/style.css">

	<script type="text/javascript" src="<?php echo THEME_URL;?>/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo THEME_URL;?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo THEME_URL;?>/js/main.js"></script>
</head>
<body>
	<div class="container-fluid header-notices">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-center gotham-book">
				<div class="bar">
					<div class="txt">
						<a href=""><span class="gotham-bold">AVISOS IRRESISTIBLES:</span> OFERTAS Y PROMOCIONES VIGENTES</a>
					</div>
					<div class="icon">
						<a href="" class="downarrow"><img src="<?php echo THEME_URL;?>/img/img_downarrow.png"/></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid content-aviso">
		<div class="container">

			<div class="row menu-2">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="content-nav">
						<ul class="header-menu gotham-bold">
							<?php
$querystr = "
							select t.term_id, t.name, t.slug, count(*) total
							from
							(
								select object_id
								from wp_term_relationships
								where term_taxonomy_id = 46
								) p
left join wp_term_relationships tr on tr.object_id = p.object_id
left join wp_term_taxonomy tt on tr.term_taxonomy_id = tt.term_taxonomy_id
left join wp_terms t on t.term_id = tt.term_id
where t.term_id != 1
group by t.term_id
order by count(*) DESC;
";
$menuItems = $wpdb->get_results($querystr, OBJECT);
foreach ($menuItems as $menuItem) {
	$termId = '';
	$itemClass = '';
	$menuLink = ($menuItem->slug == 'avisos') ? '?c=todos' : '?c=' . $menuItem->slug;
	$termId = '';

	?>
	<li>
		<a href="<?php echo $menuLink;?>" class="<?php echo $itemClass;?>" data-category="<?php echo $termId;?>"><?php echo $menuItem->name;?> (<?php echo $menuItem->total;?>)</a>
	</li>
	<?php
}
?>
</ul>
</div>
</div>
</div>
<div class="row section-avisos">
	<?php
if ($wp_query->have_posts()) {
	while ($wp_query->have_posts()): the_post();
		?>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<div class="category-posts-item">
					<div class="content-image" id="<?php the_ID();?>">
						<?php
	if (has_post_thumbnail()) {
			the_post_thumbnail('medium', array('class' => "img-responsive", 'alt' => ''));
		} else {
			?>
							<img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
							<?php
	}
		?>
						<div class="more-btn-content">
							<a href="" class="more-btn gotham-bold">
								<span class="more-btn-wrap">
									Más detalles
								</span>
							</a>
						</div>
					</div>
					<a href="">
						<div class="sub-title gotham-bold"><?php the_title();?></div>
					</a>
					<h4 class="date-aviso gotham-book"><?php echo get_post_meta(get_the_ID(), 'gaceta_vigencia', true);?></h4>
				</div>
			</div>
			<div id="modal<?php the_ID();?>" class="modalmask">
				<div class="modalbox movedown">
					<div class="content-image">
						<?php
	if (has_post_thumbnail()) {
			the_post_thumbnail('medium', array('class' => "img-responsive", 'alt' => ''));
		} else {
			?>
							<img src="<?php echo THEME_URL;?>/img/avisos.jpg" class="img-responsive">
							<?php
	}
		?>					</div>
						<div class="descripcion-modal gotham-book">
							<?php the_content();?>
						</div>
						<div class="date-modal gotham-book">
							<?php echo get_post_meta(get_the_ID(), 'gaceta_vigencia', true);?>
							<ul class="logos-modal">
								<li><a href=""><img src="<?php echo THEME_URL;?>/img/facebook-modal.png"></a></li>
								<li><a href=""><img src="<?php echo THEME_URL;?>/img/twitter-modal.png"></a></li>
								<li><a href=""><img src="<?php echo THEME_URL;?>/img/pinperest-modal.png"></a></li>
								<li><a href=""><img src="<?php echo THEME_URL;?>/img/mail-modal.png"></a></li>
							</ul>
						</div>
					</div>
				</div>
				<?php
endwhile;
	?>
		</div> <!-- End row section-avisos -->
		<div class="row pagination-aviso">
			<div class="lg-col-12 col-md-12 col-sm-12 col-xs-12 hallazgos-content">
				<div class="row pagination-aviso">
					<div class="lg-col-12 col-md-12 col-sm-12 col-xs-12 hallazgos-content">

						<?php
if ($wp_query->max_num_pages > 1) {
		wp_pagenavi();
	}
	?>

					</div>
				</div>
			</div>
		</div>
		<?php
wp_reset_postdata();
}
?>
	<script src="<?php echo THEME_URL;?>/js/bootstrap.min.js"></script>
</body>
</html>