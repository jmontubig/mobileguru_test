<div class="phone-carousel-holder">
						<div class="phones">
						
							<div class="items">
							
								<?php
									$counter=1;
									$startDiv =0;
									
									foreach($phones as $phone){
										$isWrap = ($counter == 1) || $startDiv;
										//pr($isWrap);
										if($isWrap){ echo '<div>'; $startDiv =0; }
											$type = $id_types[$phone["type_id"]]["name"];
											$brand = $id_brands[$phone["brand_id"]]["name"];
											echo '
												<div >
													<div class="title">'.$phone['name'].'</div>
													<div class="image">
														<a href="'.site_url('devices/'.$type.'/'.$brand).'" title="'.$phone['name'].'">
														' . img(array('src' => 'images/phones/'.ie($phone['image'], 'default-phone.png'), 'height' => 108,  'class' => 'phone-thumb') ) 
													.'</a></div>
												</div>
											';
										
										if(($counter%6) == 0){ echo '</div>'; $startDiv =1; }
										$counter++;
									}
									
									echo '</div>';
								?>
							
								<?php /*
								<!-- FIRST INSTANCE -->
								<div>
									<div >
										<div class="title">Samsung Galaxy III</div>
										<div class="image">
											<?php echo img(array('src' => 'images/galaxy-icon.png', 'height' => 108,  'class' => 'phone-thumb') ); ?>
										</div>
									</div>
									
									<div>
										<div class="title">Samsung Galaxy Stellar</div>
										<div class="image">
											<?php echo img(array('src' => 'images/stellar-icon.png', 'height' => 108,  'class' => 'phone-thumb') ); ?>
										</div>
									</div>
									
									<div>
										<div class="title">Samsung Galaxy Nexus</div>
										<div class="image">
											<?php echo img(array('src' => 'images/nexus-icon.png', 'height' => 108,  'class' => 'phone-thumb') ); ?>
										</div>
									</div>	

									<div>
										<div class="title">Samsung Stratosphere</div>
										<div class="image">
											<?php echo img(array('src' => 'images/stratosphere-icon.png', 'height' => 108,  'class' => 'phone-thumb') ); ?>
										</div>
									</div>	
									
									<div>
										<div class="title">Apple Iphone 5</div>
										<div class="image">
											<?php echo img(array('src' => 'images/apple-icon.png', 'height' => 108,  'class' => 'phone-thumb') ); ?>
										</div>
									</div>	

								</div>
								*/ 
							?>
								
								
								
								
																
							</div>
						
						</div>
						
						<div class="next"></div>
						<div class="prev"></div>
					</div>
					