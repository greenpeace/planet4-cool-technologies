<?php get_header(); ?>

	<main role="main">

		<header class="masthead">
	    <div class="container h-100">
	      <div class="row h-100 align-items-center justify-content-center text-center">
	        <div class="col-lg-10 align-self-end">
	          <h2 class="text-black font-weight-bold">Welcome to the first searchable database of susteinable cooling from across the globe</h2>
	        </div>
	        <div class="col-lg-8 align-self-baseline">
	          <p class="text-white-75 font-weight-light mb-5"></p>
	         <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon">
	        </div>
	      </div>
	    </div>
	  </header>

		<?php
		$terms=get_type_from_slug();
		?>
				<?php  foreach ( $terms  as $t ) { ?>
				<section class="category">
					<div class="container">
						<div class="row">
							<div class="col-md-8 offset-md-2">
								<div class="row">
										<div class="col"><h3><?php echo $t->name; ?></h3> </div>
										<div class="col">
											<div> <?php echo $t->description; ?> </div>
											<div> <button class="btn btn-block btn-outline-dark btn-lg btn-arrow"> Enter Database </button>
									 </div>
							</div>
						</div>
					</div>
				</div>
				</section>
				<?php } ?>


<!--
		<section>
			<div class="container">
					<div class="odometer"></div>

			</div>
		</section>
-->
		<!-- section -->
		<section>
			<div class="container">

			<h1><?php _e( 'Latest Posts', 'cooltech' ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>
			</div>
		</section>
		<!-- /section -->
	</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
