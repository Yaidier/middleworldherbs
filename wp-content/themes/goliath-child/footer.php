        <?php


		$categories = get_categories();

		?>

		<!-- Footer -->
		<footer class="footer">
			<div class="wn_mwh_footer wn_mwh_newsletter_section">
				<div class="wn_mwh_footer_inner">
					<div class="wn_mwh_subscription">
						<h3>Join Our Newsletter</h3>
						<p>Sign up for news on sales, product releases, and exclusive deals.</p>
						<div class="wn_mwh_sign_up_wrapper">
							<form action="">
								<input placeholder="Email" type="email" value="">
								<button type="submit" >SIGN UP</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="wn_mwh_footer">
				<div class="wn_mwh_footer_inner">
					<div class="wn_mhw_footer_nav_menus">
						<a class="mwh_footer_logo" href="">

							<?php echo wp_get_attachment_image( 1640, 'medium' ); ?>
							
						</a>
					
						<div class="wn_mwh_footer_menu_wrapper">

							<?php 
							$cat_i = 0;

							foreach( $categories as $id => $category ) {

								?>

								<div class="wn_mwh_footer_menu">
									<h3>
										<?php echo esc_attr( $category->cat_name); ?>
										<i class="wn_mwh_footer_menu_icon__open"></i>
									</h3>
									<ul>
										<?php

											$posts_args = [
												'numberposts' => 5,
  												'post_type'   => 'post',
												'category'    => $id
											];

											$posts = get_posts( $args );

											foreach( $posts as $post ) {
												?>

												<li>
													<a href=""><?php echo esc_attr( $post->post_title ); ?></a>
												</li>

												<?php
											}

										?>
									</ul>

								</div>

								<?php

								$cat_i++;

								if( $cat_i === 3 ){
									break;
								}
							} ?>
						</div>
					</div>

					<div class="wn_mwh_footer_contact_wrapper">
						<div class="wn_mhw_footer_contact_info">
							<span>Middler World Herbs</span>
							<span>Brevard, North Carolina</span>
							<span>© Middle World Herbs, 2021. All Rights Reserved.</span>
						</div>
						<div class="wn_mhw_footer_cert">
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							</p>
							<?php echo wp_get_attachment_image( 1641 ); ?>
						</div>
					</div>

					<div class="wn_mhw_footer_submenu">
						
						<ul class="wn_mhw_footer_privacy">
							<li>
								<a href="">Termns</a>
							</li>
							<li>
								<a href="">Termns</a>
							</li>
							<li>
								<a href="">Termns</a>
							</li>
							<li>
								<a href="">Termns</a>
							</li>
						</ul>

						<ul class="wn_mhw_footer_social_media">
							<li>
								<a class="wn_mhe_social_media__facebook" href="">
									<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><circle stroke="#FFF" stroke-width=".875" cx="14" cy="14" r="14"></circle><path d="M12.4 20v-5.867h-1.6V12h1.6v-1.867c0-1.51.948-2.933 3.2-2.933.904 0 1.6.118 1.6.118l-.089 2.015h-1.378c-.814 0-.933.445-.933 1.067V12h2.4l-.163 2.133H14.8V20h-2.4z" fill="#FFF" fill-rule="nonzero"></path></g></svg>
								</a>
							</li>
							<li>
								<a class="wn_mhe_social_media__instagram" href="">
									<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><circle stroke="#FFF" stroke-width=".875" cx="14" cy="14" r="14"></circle><path d="M17.2 12.267h3.2v5.866A1.878 1.878 0 0118.533 20H9.467A1.878 1.878 0 017.6 18.133v-5.866h3.2a3.471 3.471 0 003.2 4.8 3.471 3.471 0 003.2-4.8zM14 16a2.39 2.39 0 01-2.4-2.4 2.4 2.4 0 012.4-2.4c1.319 0 2.4 1.081 2.4 2.4A2.4 2.4 0 0114 16zm6.4-6.933V11.2h-3.896A3.504 3.504 0 0014 10.133c-.978 0-1.867.415-2.504 1.067H7.6V9.067c0-1.023.844-1.867 1.867-1.867h9.066c1.023 0 1.867.844 1.867 1.867z" fill="#FFF" fill-rule="nonzero"></path></g></svg>
								</a>
							</li>
							<li>
								<a class="wn_mhe_social_media__twitter" href="">
									<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><circle stroke="#FFF" stroke-width=".875" cx="14" cy="14" r="14"></circle><path d="M20.4 9.496c-.356.534-.8.993-1.304 1.363v.341c0 3.467-2.637 7.467-7.466 7.467-1.482 0-2.874-.326-4.03-1.067.207.03.415.044.622.044 1.23 0 2.37-.533 3.26-1.244a2.616 2.616 0 01-2.445-1.822 2.728 2.728 0 001.185-.045 2.625 2.625 0 01-2.103-2.577v-.03c.355.192.755.311 1.185.326a2.61 2.61 0 01-1.17-2.178c0-.489.133-.889.355-1.274 1.304 1.585 3.23 2.578 5.407 2.696-.044-.192-.059-.4-.059-.607a2.618 2.618 0 012.622-2.622c.756 0 1.437.326 1.926.83a5.36 5.36 0 001.66-.638 2.616 2.616 0 01-1.156 1.452 5.192 5.192 0 001.511-.415z" fill="#FFF" fill-rule="nonzero"></path></g></svg>
								</a>
							</li>
							<li>
								<a class="wn_mhe_social_media__linkedin" href="">
									<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><circle stroke="#FFF" stroke-width=".875" cx="14" cy="14" r="14"></circle><path d="M7.867 11.733h2.666V20H7.867v-8.267zM14.8 15.2V20h-2.667v-6.4s-.044-1.585-.044-1.867h2.622l.089 1.141c.533-.8 1.333-1.407 2.4-1.407 1.867 0 3.2 1.333 3.2 3.733V20h-2.667v-4.533c0-1.334-.651-1.867-1.451-1.867s-1.482.533-1.482 1.6zm-5.615-4.8H9.17c-.948 0-1.57-.652-1.57-1.467 0-.83.637-1.466 1.615-1.466.963 0 1.57.637 1.585 1.466 0 .815-.622 1.467-1.615 1.467z" fill="#FFF" fill-rule="nonzero"></path></g></svg>
								</a>
							</li>
							<li>
								<a class="wn_mhe_social_media__pinterest" href="">
									<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><circle stroke="#FFF" stroke-width=".875" cx="14" cy="14" r="14"></circle><path d="M14.296 7.2c2.815 0 4.652 2.03 4.652 4.207 0 2.89-1.6 5.037-3.955 5.037-.8 0-1.541-.414-1.808-.903 0 0-.415 1.689-.518 2.015-.311 1.155-1.245 2.31-1.319 2.4-.06.074-.163.044-.178-.03-.014-.148-.251-1.615.03-2.8.133-.593.933-4 .933-4s-.222-.474-.222-1.17c0-1.097.622-1.897 1.408-1.897.666 0 .992.49.992 1.097 0 .666-.43 1.674-.652 2.607-.178.785.4 1.422 1.17 1.422 1.393 0 2.327-1.792 2.327-3.91 0-1.616-1.082-2.816-3.052-2.816-2.237 0-3.63 1.66-3.63 3.511 0 .652.193 1.097.489 1.452.133.163.148.222.104.4-.03.148-.119.474-.148.593-.045.192-.193.252-.37.192-1.023-.43-1.497-1.555-1.497-2.814 0-2.09 1.748-4.593 5.244-4.593z" fill="#FFF" fill-rule="nonzero"></path></g></svg>
								</a>
							</li>
						</ul>
					</div>

					<p class="wn_mwh_footer_disclaimer_banner">
						*This statement has not been evaluated by the Food and Drug Administration. This product is not intended to diagnose, treat, cure, or prevent any disease.
					</p>

				</div>
			</div>	
			<!-- Copyright -->
			<div class="container copyright">
			
			</div>	
		</footer>
		
		
		
		<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
        
        <?php wp_footer();?>
	<!-- END body -->
	</body>
	
<!-- END html -->
</html>