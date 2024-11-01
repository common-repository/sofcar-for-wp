<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.sofcar.com
 * @since      1.0.0
 *
 * @package    Sofcar
 * @subpackage Sofcar/admin/partials
 */
?>
<div id="sofcar-plugin-topNav">
	<div class="sofcar-plugin-left"><img class="irctopNavLogo" src="<?php echo esc_url(plugins_url('sofcar-for-wp/images/brand/sofcar_wordpress.png')); ?>"></div>
	<div class="sofcar-plugin-right txt">
		<?php if(!$sofcar_api->validate_token()){ ?>
			<?php if($current_tab=="started"){ ?>
				<a href="<?php echo esc_url( "?page=sofcar&tab=settings" ) ?>" class="sofcar-plugin-top-settings-btn"><?php  echo esc_html__("Settings", 'sofcar'); ?></a>
			<?php }else{ ?>
				<?php  echo esc_html__("Don't you have a Sofcar Account yet?", 'sofcar'); ?> 
				<a href="<?php echo esc_url( "?page=sofcar&tab=started" ) ?>" style="color:#029a71"><?php  echo esc_html__("Get Started", 'sofcar'); ?></a>
			<?php  }?>
		<?php }else{ $company_images = $sofcar_api->get_company_images();?>
			<div class="sp-top-log sp-hidden-mobile">
				<?php if(isset($company_images[0]["logoweb"]) && !empty($company_images[0]["logoweb"])){?>
					<img src="<?php echo esc_url($company_images[0]["logoweb"]) ?>" height="40" style="padding: 0">
				<?php }?>
			</div>
		<?php  }?>
	</div>	
	<div class="sofcar-plugin-clear"></div>
</div>

<div class="sofcar-plugin-main">
	<div class="sofcar-plugin-form">
		
		<?php if($sofcar_api->validate_token()){ ?>
			<?php if($current_tab!="settings"){ ?>
				<h2 class="nav-tab-wrapper">
					<a href="<?php echo esc_url( "?page=sofcar&tab=booking" ) ?>" class="nav-tab <?php if($current_tab=="booking"){ ?>nav-tab-active<?php }?>">
						<?php  echo esc_html__('Bookings', 'sofcar'); ?>
					</a>
					<a href="<?php echo esc_url( "?page=sofcar&tab=places" ) ?>" class="nav-tab <?php if($current_tab=="places"){ ?>nav-tab-active<?php }?>">
						<?php  echo esc_html__('Locations', 'sofcar'); ?>
					</a>
					<a href="<?php echo esc_url( "?page=sofcar&tab=vclass" ) ?>" class="nav-tab <?php if($current_tab=="vclass"){ ?>nav-tab-active<?php }?>">
						<?php  echo esc_html__('Classes', 'sofcar'); ?>
					</a>
					<a href="<?php echo esc_url( "?page=sofcar&tab=models" ) ?>" class="nav-tab <?php if($current_tab=="models"){ ?>nav-tab-active<?php }?>">
						<?php  echo esc_html__('Models', 'sofcar'); ?>
					</a>
					<a href="<?php echo esc_url( "?page=sofcar&tab=widget" ) ?>" class="nav-tab <?php if($current_tab=="widget"){ ?>nav-tab-active<?php }?>">
						<?php  echo esc_html__('Shortcodes', 'sofcar'); ?>
					</a>
					<a href="<?php echo esc_url( "?page=sofcar&tab=pages" ) ?>" class="nav-tab <?php if($current_tab=="pages"){ ?>nav-tab-active<?php }?>">
						<?php  echo esc_html__('Pages', 'sofcar'); ?>
					</a>
				</h2>
			<?php } ?>	
		<?php } ?>	
		
		<div class="sofcar-plugin-init">
			
			<?php if(!$sofcar_api->validate_token()){ ?>

				<?php if($current_tab=="started"){ $startLanguage = "en"; ?>		
					<div align="center">
						<iframe src="https://www.sofcar.com/start?lang=<?php echo $startLanguage ?>&from=wordpress&wplocale=<?php echo get_locale(); ?>" width="100%" height="610" scrolling="no" border="0" 
								style="border: none;padding:0; margin:0;"></iframe>			
					</div>	
					<style type="text/css">
						.sofcar-plugin-init{ width: 100% !important; padding: 0 !important;}
						.nav-tab-wrapper{ border: none !important;} 
						.nav-tab{border: 1px solid #ccc !important;}
					</style>
				<?php }else{ ?>
					<div style="padding: 0 20px;">
						<form method="post">
							<h2 style="font-size: 22px;margin: 0 0 20px 0;"><?php  echo esc_html__('Settings', 'sofcar'); ?></h2>
							<span style="font-size: 14px"><?php  echo esc_html__('Sofcar plugin is now installed and ready to use', 'sofcar'); ?>.</span>
							<p><?php  echo str_replace("Sofocar","Sofcar",esc_html__("Please, enter your Sofcar's credentials", 'sofcar')); ?>:</p>
							<?php if($sofcar_api->get_token() && $sofcar_api->get_auth()){ ?>
								<div class="sofcar-plugin-txt-danger"><?php  echo esc_html__('It looks like your credentials are incorrect', 'sofcar'); ?>.</div>
							<?php } ?>
							<table class="form-table">
								<tr valign="top">
									<th scope="row"><label for="sofcar_token" style="cursor: default"><?php  echo esc_html__('Sofcar API Token', 'sofcar'); ?></label></th>
									<td><input name="sofcar_token" class="sofcar-plugin-input" minlength="16" type="text" autocomplete="off"
											   value="<?php echo esc_attr($sofcar_api->get_token()) ?>" /></td>
								</tr>
								<tr valign="top">
									<th scope="row"><label for="sofcar_token" style="cursor: default"><?php  echo esc_html__('Password', 'sofcar'); ?></label></th>
									<td><input name="sofcar_auth" class="sofcar-plugin-auth" value="<?php echo esc_attr($sofcar_api->get_auth()) ?>" type="password" /></td>
								</tr>
							</table>
							<hr class="sofcar-plugin-hr" />
							<button type="submit" class="button-primary"><?php  echo esc_html__('Save', 'sofcar'); ?></button>
							<br><br>
							<?php  echo esc_html__("Don't you have a Sofcar Account yet?", 'sofcar'); ?> 
							<a href="<?php echo esc_url( "?page=sofcar&tab=started" ) ?>" style="color:#029a71"><?php  echo esc_html__("Get Started", 'sofcar'); ?></a>
			 			</form>	
					</div>					
					<div class="sofcar-plugin-clear"></div>	
				<?php } ?>		
						
						
			<?php }else{ ?>

				<?php if($current_tab=="models"){ 
					$models = $sofcar_api->get_models();
					$wp_models  = $sofcar_api->get_wp_posts(false,false,array("key"=>"sofcar_models")); ?>
					<form method="post">
						<input type="hidden" name="sofcar_sync" value="models">
						<div class="tablenav top">
							<div class="alignleft actions">
								<select name='post_group_action' class='postform'>
									<option>&nbsp;</option>
									<option value="import"><?php  echo esc_html__('Import', 'sofcar'); ?>/<?php  echo esc_html__('Sync', 'sofcar'); ?></option>
									<option value="delete"><?php  echo esc_html__('Delete from Wordpress', 'sofcar'); ?></option>
								</select>
								<input type="submit" class="button sofcar-plugin-action-btn" value="<?php  echo esc_html__('Apply', 'sofcar'); ?>"  />		
							</div>
							<div class="tablenav-pages one-page">
								<ul class='subsubsub sofcarsubsub'>
									<li class='all'>
										<a href="<?php echo esc_url( "?page=sofcar&tab=".$current_tab."&type=sofcar" ) ?>" <?php if($filter_type=="sofcar"){?>class="current" aria-current="page"<?php }?>>
											<?php  echo esc_html__('Sofcar', 'sofcar'); ?> 
											<span class="count">(<?php echo sizeof($models); ?>)</span>
										</a> |
									</li>
									<li class='mine'>
										<a href="<?php echo esc_url( "?page=sofcar&tab=".$current_tab."&type=wp" ) ?>" <?php if($filter_type=="wp"){?>class="current" aria-current="page"<?php }?>>
											<?php  echo esc_html__('Wordpress', 'sofcar'); ?> 
											<span class="count">(<?php echo sizeof($sofcar_api->get_wp_posts(false,false,array("key"=>"sofcar_models")))?>)</span>
										</a>
									</li>
								</ul>
							</div>
						</div>	
						<table class="wp-list-table widefat fixed striped posts sofcar-wp-table">
							<thead>
								<tr>
									<td class="manage-column check-column"><input type="checkbox"></td>
									<td width="50"><?php  echo esc_html__('Model', 'sofcar'); ?></td>
									<td></td>
									<td><?php  echo esc_html__('Group', 'sofcar'); ?></td>
									<td width="180"><?php  echo esc_html__('Last sync', 'sofcar'); ?></td>
									<td width="150"><?php  echo esc_html__('Wordpress', 'sofcar'); ?></td>
								</tr>
							</thead>
							<tbody>
								<?php $ci=0; $wp_item_list = array(); if(sizeof($models)){?>
									<?php foreach($models as $model){ 
										$itemLink 	= $sofcar_api->get_host()."/tools/model/edit/model_id/".$model["model_id"]; 
										$wp_post_id = $sofcar_api->get_wp_posts(array( "key" => "sofcar_models", "value" => $model["model_id"]));
										$viewItem	= true; if($filter_type=="wp" && !sizeof($wp_post_id))$viewItem	= false; 
										if($viewItem){ ?>
											<tr>
												<th class="check-column">
													<input name="chk_item_<?php echo $model["model_id"] ?>" value="<?php echo esc_attr($model["model_id"]) ?>" type="checkbox">
												</th>
												<td width="50">
													<?php if(!empty($model["image"])){?>
														<a href="<?php echo esc_url($itemLink) ?>" target="_blank">
															<img src="<?php echo esc_url($sofcar_api->get_host()."/".$model["image"]); ?>" 
																 title="<?php echo ucfirst(mb_strtolower($model["name"])) ?>" style="width: 45px; height: 30px"></a>
													<?php }?>
												</td>
												<td>
													<a href="<?php echo esc_url($itemLink) ?>" target="_blank"><?php echo ucfirst(mb_strtolower($model["name"])) ?></a><br />
													<?php echo ucfirst(mb_strtolower($model["vclass"])) ?>
												</td>
												<td><?php echo $model["group"] ?></td>
												<?php if(sizeof($wp_post_id)){ $wp_item_list[$wp_post_id[0]->ID] = $wp_post_id[0]->ID;?>
													<td width="180">
														<div class="sofcar-plugin-txt-min">
															<?php if(substr($wp_post_id[0]->post_date,0,10)==date("Y-m-d")){?><?php  echo esc_html__('Today', 'sofcar'); ?><br>
															<?php }else{ ?><?php echo substr($wp_post_id[0]->post_date,0,10); ?><br><?php }?>
															<?php echo substr($wp_post_id[0]->post_date,11,8); ?> 	 
															<?php if($wp_post_id[0]->post_date!=$wp_post_id[0]->post_modified){?>
																 <br><span class="sofcar-plugin-txt-danger"><?php  echo esc_html__('Manually edited', 'sofcar'); ?></span>
															<?php }?>
														</div>
													</td>
													<td width="150">
														<a href="<?php echo esc_url(get_edit_post_link($wp_post_id[0]->ID)) ?>" target="_blank"><?php  echo esc_html__('Edit', 'sofcar'); ?></a> 
														<span class="row-actions">|</span> 
														<a href="<?php echo esc_url(get_permalink($wp_post_id[0]->ID)) ?>" target="_blank"><?php  echo esc_html__('View', 'sofcar'); ?></a><br>
													</td>
												<?php }else{?>
													<td colspan="2" width="330">-</td>	
												<?php }?>
											</tr>
										<?php $ci++;}?>
									<?php }?>
								<?php }?>
								<?php if($filter_type=="wp"){?>
									<?php if(sizeof($wp_models)){?>
										<?php foreach($wp_models as $wmodel){ ?>
											<?php if(!isset($wp_item_list[$wmodel->ID])){ 
												$wpImage = get_the_post_thumbnail( $wmodel->ID, 'thumbnail', array( 'class' => 'sofcar-table-model-thu' ) ); ?>
												<tr>
													<th class="check-column sofcar-td-nosync"></th>
													<td width="40" class="sp-hidden-mobile sofcar-td-nosync">
														<?php if(!empty($wpImage)){ ?>
															<a href="<?php echo esc_url(get_edit_post_link($wmodel->ID)) ?>" target="_blank">
																<?php echo $wpImage ?>
															</a>	
														<?php }?>
													</td>
													<td class="sofcar-td-nosync">
														<?php echo ucfirst(mb_strtolower($wmodel->post_title)) ?><br>
														<span class="sofcar-plugin-txt-danger"><?php  echo esc_html__('Inactive in sofcar', 'sofcar'); ?></span>
													</td>
													<td class="sofcar-td-nosync">-</td>
													<td width="180" class="sofcar-td-nosync">
														<div class="sofcar-plugin-txt-min">
															<?php if(substr($wmodel->post_date,0,10)==date("Y-m-d")){?><?php  echo esc_html__('Today', 'sofcar'); ?><br>
															<?php }else{ ?><?php echo substr($wmodel->post_date,0,10); ?><br><?php }?>
															<?php echo substr($wmodel->post_date,11,8); ?>
															<?php if($wmodel->post_date!=$wmodel->post_modified){?>
																 <span class="sofcar-plugin-txt-danger"><?php  echo esc_html__('Manually edited', 'sofcar'); ?></span>
															<?php }?>
														</div>
													</td>
													<td width="150" class="sofcar-td-nosync">
														<a href="<?php echo esc_url(get_edit_post_link($wmodel->ID)) ?>" target="_blank">
															<?php  echo esc_html__('Edit', 'sofcar'); ?>
														</a> 
														<span class="row-actions">|</span> 
														<a href="<?php echo esc_url(get_permalink($wmodel->ID)) ?>" target="_blank"><?php  echo esc_html__('View', 'sofcar'); ?> 
														<span class="row-actions">|</span> 
														<a href="<?php echo esc_url(get_delete_post_link($wmodel->ID)) ?>" class="sofcar-plugin-txt-danger">
															<?php  echo esc_html__('Delete', 'sofcar'); ?>
														</a><br><br>
													</td>
												</tr>
											<?php $ci++;}?>
										<?php }?>
									<?php }?>
								<?php }?>
								<?php if(!$ci){?><tr class="no-items"><td class="colspanchange" colspan="6"><?php  echo esc_html__('No Models found', 'sofcar'); ?>.</td></tr><?php }?>
							</tbody>
						</table>
					</form>
						
				<?php }elseif($current_tab=="vclass"){ $classes = $sofcar_api->get_vclass(); ?>

					<form method="post">
						<input type="hidden" name="sofcar_sync" value="classes">
						<div class="tablenav top">
							<div class="alignleft actions">
								<select name='post_group_action' class='postform'>
									<option>&nbsp;</option>
									<option value="import"><?php  echo esc_html__('Import', 'sofcar'); ?>/<?php  echo esc_html__('Sync', 'sofcar'); ?></option>
									<option value="delete"><?php  echo esc_html__('Delete from Wordpress', 'sofcar'); ?></option>
								</select>
								<input type="submit" class="button sofcar-plugin-action-btn" value="<?php  echo esc_html__('Apply', 'sofcar'); ?>"  />		
							</div>	
						</div>			
						<table class="wp-list-table widefat fixed striped posts sofcar-wp-table">
							<thead>
								<tr>
									<td class="manage-column check-column"><input type="checkbox"></td>
									<td width="180"><?php  echo esc_html__('Vehicle Class', 'sofcar'); ?></td>
									<td><?php  echo esc_html__('WP Models', 'sofcar'); ?></td>
									<td width="180"><?php  echo esc_html__('WP Category', 'sofcar'); ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if(!sizeof($classes)){?>
									<tr class="no-items"><td class="colspanchange" colspan="4"><?php  echo esc_html__('No Classes found', 'sofcar'); ?>.</td></tr>
								<?php }else{ ?>
									<?php foreach($classes as $vclass){
										if(isset($vclass["vclass_id"])){
											$itemLink  = $sofcar_api->get_host()."/tools/vclass/edit/vclass_id/".$vclass["vclass_id"]; $class_wp_items = array();
											$wpclass   = $sofcar_api->get_wp_sofcar_category("sofcar_vclass_".$vclass["vclass_id"]); 
											if($wpclass)$class_wp_items = $sofcar_api->get_wp_posts(false,$wpclass); ?>
											<tr>
												<th class="check-column">
													<?php if(!isset($class_wp_items) || !sizeof($class_wp_items)){?>
														<input name="chk_item_<?php echo esc_attr($vclass["vclass_id"]) ?>" value="<?php echo esc_attr($vclass["vclass_id"]) ?>" type="checkbox">
													<?php }?>
												</th>
												<td width="180"><a href="<?php echo esc_url($itemLink) ?>" target="_blank"><?php echo esc_html($vclass["name"]) ?></a></td>
												<td>
													<?php if(isset($class_wp_items) && sizeof($class_wp_items)){?>
														<?php foreach($class_wp_items as $pc){?>
															<a href="<?php echo esc_url(get_permalink($pc->ID)) ?>" target="_blank" style="font-size: 12px; margin-right: 10px;">
																<?php echo esc_html($pc->post_title) ?>
															</a>
														<?php }?>
													<?php }else{ ?>-<?php }?>
												</td>
												<td width="180">
													<?php if($wpclass){ ?>
														<?php $Catpath = 'term.php?taxonomy=category&tag_ID='.$wpclass; $editCat = admin_url($Catpath); ?>
														<a href="<?php echo esc_url($editCat) ?>" target="_blank"><?php  echo esc_html__('Edit', 'sofcar'); ?></a> <span class="row-actions">|</span>  
														<a href="<?php echo esc_url(get_category_link($wpclass)); ?>" target="_blank"><?php  echo esc_html__('View', 'sofcar'); ?></a> 
													<?php }else{ ?>-<?php }?>
												</td>
											</tr>
										<?php }?>
									<?php }?>
								<?php }?>
							</tbody>
						</table>
					</form>
					
					<style type="text/css">
						.sofcar-plugin-init{width: 100% !important;padding: 10px 0 0 0 !important;}
						.sofcar-plugin-sidebar{ display: none !important;}
					</style>
						
				<?php }elseif($current_tab=="places"){ 
						$places 	= $sofcar_api->get_places(); 
						$wp_places  = $sofcar_api->get_wp_posts(false,false,array("key"=>"sofcar_places"));?>
						<form method="post">
						<input type="hidden" name="sofcar_sync" value="places">
						<div class="tablenav top">
							<div class="alignleft actions">
								<select name='post_group_action' class='postform'>
									<option>&nbsp;</option>
									<option value="import"><?php  echo esc_html__('Import', 'sofcar'); ?>/<?php  echo esc_html__('Sync', 'sofcar'); ?></option>
									<option value="delete"><?php  echo esc_html__('Delete from Wordpress', 'sofcar'); ?></option>
								</select>
								<input type="submit" class="button sofcar-plugin-action-btn" value="<?php  echo esc_html__('Apply', 'sofcar'); ?>"  />		
							</div>	
							<div class="tablenav-pages one-page">
								<ul class='subsubsub sofcarsubsub'>
									<li class='all'>
										<a href="<?php echo esc_url( "?page=sofcar&tab=".$current_tab."&type=sofcar" ) ?> <?php if($filter_type=="sofcar"){?>class="current" aria-current="page"<?php }?>>
											<?php  echo esc_html__('Sofcar', 'sofcar'); ?> 
											<span class="count">(<?php echo esc_attr(sizeof($places)); ?>)</span>
										</a> |
									</li>
									<li class='mine'>
										<a href="<?php echo esc_url( "?page=sofcar&tab=".$current_tab."&type=wp") ?>" <?php if($filter_type=="wp"){?>class="current" aria-current="page"<?php }?>>
											<?php  echo esc_html__('Wordpress', 'sofcar'); ?> 
											<span class="count">(<?php echo esc_attr(sizeof($wp_places)) ?>)</span>
										</a>
									</li>
								</ul>
							</div>
						</div>	
						<table class="wp-list-table widefat fixed striped posts sofcar-wp-table">
							<thead>
								<tr>
									<td class="manage-column check-column"><input type="checkbox"></td>
									<td width="40" class="sp-hidden-mobile"></td>
									<td><?php  echo esc_html__('Location', 'sofcar'); ?></td>
									<td><?php  echo esc_html__('Warehouse', 'sofcar'); ?></td>
									<td width="140"><?php  echo esc_html__('Last sync', 'sofcar'); ?></td>
									<td width="140"><?php  echo esc_html__('Wordpress', 'sofcar'); ?></td>
								</tr>
							</thead>
							<tbody>
								<?php $ci=0; $wp_item_list = array(); 
									  if(sizeof($places)){?>
									<?php foreach($places as $place){ 
										$itemLink 	= $sofcar_api->get_host()."/tools/place/edit/place_id/".$place["place_id"]; 
										$wp_post_id = $sofcar_api->get_wp_posts(array( "key" => "sofcar_places", "value" => $place["place_id"]));
										$viewItem	= true; if($filter_type=="wp" && !sizeof($wp_post_id))$viewItem	= false; 
										if($viewItem){  ?>
											<tr>
												<th class="check-column">
													<input name="chk_item_<?php echo esc_attr($place["place_id"]) ?>" value="<?php echo esc_attr($place["place_id"]) ?>" type="checkbox">
												</th>
												<td width="40" class="sp-hidden-mobile">
													<?php if(!empty($place["image"])){ ?>
														<a href="<?php echo esc_url($itemLink) ?>" target="_blank">
															<img src="<?php echo esc_url($sofcar_api->get_host()."/".$place["image"]) ?>" 
																 title="<?php echo esc_html(ucfirst(mb_strtolower($place["name"]))) ?>" class="sofcar-table-thu">
														</a>	
													<?php }?>
												</td>
												<td>
													<a href="<?php echo esc_url($itemLink) ?>" target="_blank">
														<strong><?php echo esc_html(ucfirst(mb_strtolower($place["name"]))) ?></strong>
													</a><br>
													<?php echo esc_html(ucfirst(mb_strtolower($place["city"]))) ?>
												</td>
												<td><?php echo esc_html(ucfirst(mb_strtolower($place["store_name"]))) ?></td>
												<?php if(sizeof($wp_post_id)){ $wp_item_list[$wp_post_id[0]->ID] = $wp_post_id[0]->ID; ?>
													<td width="140">
														<div class="sofcar-plugin-txt-min">
															<?php if(substr($wp_post_id[0]->post_date,0,10)==date("Y-m-d")){?><?php  echo esc_html__('Today', 'sofcar'); ?><br>
															<?php }else{ ?><?php echo esc_html(substr($wp_post_id[0]->post_date,0,10)); ?><br><?php }?>
															<?php echo esc_html(substr($wp_post_id[0]->post_date,11,8)); ?>
															<?php if($wp_post_id[0]->post_date!=$wp_post_id[0]->post_modified){?>
																 <span class="sofcar-plugin-txt-danger"><?php  echo esc_html__('Manually edited', 'sofcar'); ?></span>
															<?php }?>
														</div>
													</td>
													<td width="140">
														<a href="<?php echo esc_url(get_edit_post_link($wp_post_id[0]->ID)) ?>" target="_blank"><?php  echo esc_html__('Edit', 'sofcar'); ?></a> <span class="row-actions">|</span> 
														<a href="<?php echo esc_url(get_permalink($wp_post_id[0]->ID)) ?>" target="_blank"><?php  echo esc_html__('View', 'sofcar'); ?></a><br>
													</td>
												<?php }else{?>
													<td width="280" colspan="2">-</td>
												<?php }?>
											</tr>
										<?php $ci++;}?>
									<?php }?>
								<?php }?>
								
								<?php if($filter_type=="wp"){?>
									<?php if(sizeof($wp_places)){?>
										<?php foreach($wp_places as $wplace){ ?>
											<?php if(!isset($wp_item_list[$wplace->ID])){ 
												$wpImage = get_the_post_thumbnail( $wplace->ID, 'thumbnail', array( 'class' => 'sofcar-table-thu' ) ); ?>
												<tr>
													<th class="check-column sofcar-td-nosync"></th>
													<td width="40" class="sp-hidden-mobile sofcar-td-nosync">
														<?php if(!empty($wpImage)){ ?>
															<a href="<?php echo esc_url(get_edit_post_link($wplace->ID)) ?>" target="_blank">
																<?php echo $wpImage ?>
															</a>	
														<?php }?>
													</td>
													<td class="sofcar-td-nosync">
														<?php echo ucfirst(mb_strtolower($wplace->post_title)) ?><br>
														<span class="sofcar-plugin-txt-danger"><?php  echo esc_html__('Inactive in sofcar', 'sofcar'); ?></span>
													</td>
													<td class="sofcar-td-nosync">-</td>
													<td width="140" class="sofcar-td-nosync">
														<div class="sofcar-plugin-txt-min">
															<?php if(substr($wplace->post_date,0,10)==date("Y-m-d")){?><?php  echo esc_html__('Today', 'sofcar'); ?><br>
															<?php }else{ ?><?php echo esc_html(substr($wplace->post_date,0,10)); ?><br><?php }?>
															<?php echo esc_html(substr($wplace->post_date,11,8)); ?>
															<?php if($wplace->post_date!=$wplace->post_modified){?>
																 <span class="sofcar-plugin-txt-danger"><?php  echo esc_html__('Manually edited', 'sofcar'); ?></span>
															<?php }?>
														</div>
													</td>
													<td width="140" class="sofcar-td-nosync">
														<a href="<?php echo esc_url(get_edit_post_link($wplace->ID)) ?>" target="_blank">
															<?php  echo esc_html__('Edit', 'sofcar'); ?>
														</a> 
														<span class="row-actions">|</span> 
														<a href="<?php echo esc_url(get_permalink($wplace->ID)) ?>" target="_blank"><?php  echo esc_html__('View', 'sofcar'); ?></a>
														<span class="row-actions">|</span> 
														<a href="<?php echo esc_url(get_delete_post_link($wplace->ID)) ?>" class="sofcar-plugin-txt-danger">
															<?php  echo esc_html__('Delete', 'sofcar'); ?>
														</a><br><br>
													</td>
												</tr>
											<?php $ci++;}?>
										<?php }?>
									<?php }?>
								<?php }?>
								<?php if(!$ci){?><tr class="no-items"><td class="colspanchange" colspan="6"><?php  echo esc_html__('No locations found', 'sofcar'); ?>.</td></tr><?php }?>
							</tbody>
						</table>
					</form>		
						
				<?php }elseif($current_tab=="settings"){ ?>

					<h2 style="font-size: 22px;margin: 0 0 20px 0;"><?php  echo esc_html__('Settings', 'sofcar'); ?></h2>
					<table class="wp-list-table widefat fixed striped posts sofcar-wp-table sofcar-wp-table-settings" style="margin-top: 15px; max-width: 100%;">
						<thead>
							<tr>
								<td><?php  echo esc_html__('Host', 'sofcar'); ?></td>
								<td width="200"><?php  echo esc_html__('Username', 'sofcar'); ?></td>
								<td width="120"><?php  echo esc_html__('Password', 'sofcar'); ?></td>
								<td width="180"><?php  echo esc_html__('Actions', 'sofcar'); ?></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="<?php echo esc_url($sofcar_api->get_host()."/tools") ?>" target="_blank"><?php echo  esc_html__($sofcar_api->get_host()) ?></a></td>
								<td width="200"><?php echo  esc_html__($sofcar_api->get_username()) ?></td>
								<td width="120"><?php echo "********" ?></td>
								<td width="180">
									<div id='SofcarResetMsg' class='sofcar-plugin-hidden'>
										<?php echo  esc_html__('Do you really want to delete your connection data with your Sofcar platform?', 'sofcar') ?>
									</div>
								    <form id='SofcarResetFrm' method='post'><input type='hidden' name='sofcar_reset' value='1'></form>
								    <a href='#' onClick='SofcarReset()' class='sofcar-plugin-txt-danger'><?php echo esc_html__('Delete connection data', 'sofcar')?></a>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="sofcar-plugin-notice">	
						<h1><?php  echo esc_html__('Content import', 'sofcar'); ?></h1>
						<?php  echo esc_html__('The easiest way to import all your fleet into your WordPress website, integrates your online booking system instead of creating content from scratch.', 'sofcar'); ?><br /><?php  echo esc_html__('The content import is done automatically, simply click on the buttons provided for it in each section.', 'sofcar'); ?><br />
						<h4><?php  echo esc_html__('Before importing categories, Models or Locations, you must take into account', 'sofcar'); ?>:</h4>
						→ <?php  echo esc_html__('The system will import categories, Models and Locations as Posts.', 'sofcar'); ?><br />
						→ <?php  echo esc_html__('The system will insert the description of the Model by language, its images and will include the integration code for its booking.', 'sofcar'); ?><br />
						→ <?php  echo esc_html__('Posts, Pages, Categories, Images and any other data will not be deleted nor modified.', 'sofcar'); ?><br />
						→ <?php  echo esc_html__('Settings will not be modified.', 'sofcar'); ?><br />
						→ <?php  echo esc_html__('Click Import one time and wait, this process may take a few minutes.', 'sofcar'); ?>
					</div>
						
					
				<?php }elseif($current_tab=="pages"){ 
						$wp_pages 		= $sofcar_api->get_wp_pages( false , array("key"=>"sofcar_pages") );
						$wp_pages_type 	= $sofcar_api->get_wp_pages_templates(); 
					?>
					<form method="post">
						<input type="hidden" name="sofcar_pages" value="pages">
						<div class="tablenav top">
							<div class="alignleft actions">
								<select name='post_group_action' class='postform'>
									<option>&nbsp;</option>
									<?php foreach($wp_pages_type as $ptype => $des){ ?>
										<option value='<?php echo $ptype ?>' 
										<?php if($sofcar_api->get_wp_pages(array("key"=>"sofcar_pages","value"=>$ptype))){?>disabled<?php }?>><?php echo $des ?></option>
									<?php }?>
								</select>
								<input type="submit" class="button sofcar-plugin-action-btn" value="<?php  echo esc_html__('Create', 'sofcar'); ?>"  />		
							</div>	
						</div>	
						<table class="wp-list-table widefat fixed striped posts sofcar-wp-table">
							<thead>
								<tr>
									<td width="50"><?php  echo esc_html__('ID', 'sofcar'); ?></td>
									<td><?php  echo esc_html__('Name', 'sofcar'); ?></td>
									<td width="240"><?php  echo esc_html__('Actions', 'sofcar'); ?></td>
								</tr>
							</thead>
							<tbody>
								<?php $ci=0; if(sizeof($wp_pages)){?>
									<?php foreach($wp_pages as $page){ ?>
										<tr>
											<td width="50"><a href="<?php echo esc_url(get_edit_post_link($page->ID)) ?>" target="_blank"><?php echo $page->ID ?></a></td>
											<td><?php echo $page->post_title ?></td>
											<td width="240"	>
												<a href="<?php echo esc_url(get_edit_post_link($page->ID)) ?>" target="_blank"><?php  echo esc_html__('Edit', 'sofcar'); ?></a> 
												<span class="row-actions">|</span> 
												<a href="<?php echo esc_url(get_permalink($page->ID)) ?>" target="_blank"><?php  echo esc_html__('View', 'sofcar'); ?></a>
												<span class="row-actions">|</span> 
												<a href="<?php echo esc_url(get_delete_post_link($page->ID)) ?>" class="sofcar-plugin-txt-danger">
													<?php  echo esc_html__('Trash', 'sofcar'); ?>
												</a><br>
											</td>
										</tr>	
									<?php $ci++;} ?>
								<?php } ?>
								<?php if(!$ci){?><tr class="no-items"><td class="colspanchange" colspan="3"><?php  echo esc_html__('No Pages found', 'sofcar'); ?>.</td></tr><?php } ?>
							</tbody>
						</table>
					</form>			

				<?php }elseif($current_tab=="widget"){  
					$sofcar_types  = $sofcar_api->get_widget_layouts();
					$sofcar_models = $sofcar_api->get_models();
					$sofcar_views  = $sofcar_api->get_views(); 
					$sofcar_width  = array( "100%", "600px", "450px", "350px");
					?>
					<form method="post">
						<input type="hidden" name="sofcar_widget_generate" value="true">
						<div class="tablenav top">
							<div class="alignleft actions sofcar-widget-table">
								<?php if(sizeof($sofcar_types)){?>
									<select id="widget_type" name='widget_type' class='postform'>
										<?php foreach($sofcar_types as $type => $typename){?>
											<option value='<?php echo esc_attr($type) ?>'
												<?php if(isset($rqParams["widget_type"]) && $rqParams["widget_type"]==$type){?>selected<?php }?>>
												<?php echo esc_attr($typename) ?>
											</option>
										<?php }?>
									</select>
								<?php }?>
								<?php if(sizeof($sofcar_models)){?>
									<select id="widget_model" name="widget_model" class='postform' 
										<?php if(!isset($rqParams["widget_type"]) || $rqParams["widget_type"]!="vehicle"){?> style="display:none;"<?php }?>>
										<?php foreach($sofcar_models as $model){?>
											<option value='<?php echo esc_attr($model["model_id"]) ?>' 
													<?php if(isset($rqParams["widget_model"]) && $rqParams["widget_model"]==$model["model_id"]){?>selected<?php }?>>
												<?php echo esc_attr($model["name"]) ?>
											</option>
										<?php }?>
									</select>
								<?php }?>
								<select name="widget_width" class='postform'>
									<?php foreach($sofcar_width as $w){?>
										<option value='<?php echo esc_attr($w) ?>'
											<?php if(isset($rqParams["widget_width"]) && $rqParams["widget_width"]==$w){?>selected<?php }?>>
											<?php  echo esc_html__('Width', 'sofcar'); ?>: <?php echo esc_attr($w) ?> <?php if($w=="100%")echo "(".esc_html__('Responsive', 'sofcar').")" ?></option>
									<?php }?>
								</select>
								<select id="widget_result_width" name="widget_result_width" class='postform'
									<?php if(isset($rqParams["widget_type"]) && $rqParams["widget_type"]!="searcher"){?> style="display:none;"<?php }?>>
									<?php foreach($sofcar_width as $w){?>
										<option value='<?php echo esc_attr($w) ?>'
											<?php if(isset($rqParams["widget_result_width"]) && $rqParams["widget_result_width"]==$w){?>
												selected<?php }?>>
											<?php  echo esc_html__("Results' Width", 'sofcar'); ?>: <?php echo esc_attr($w) ?> <?php if($w=="100%")echo "(".esc_html__('Responsive', 'sofcar').")" ?></option>
									<?php }?>
								</select>
								<select name="widget_scroll" class='postform'>
									<option value='0'><?php  echo esc_html__('Autoscroll inactive', 'sofcar'); ?></option>
									<option value='1' <?php if(isset($rqParams["widget_scroll"]) && $rqParams["widget_scroll"]){?>selected<?php }?>><?php  echo esc_html__('Autoscroll active', 'sofcar'); ?></option>
								</select>
								<select name="widget_view" class='postform'>
									<?php $defLang = $sofcar_api->get_view(); if(isset($rqParams["widget_view"]))$defLang = $rqParams["widget_view"];
									    foreach($sofcar_views as $lang){?>
										<option value='<?php echo esc_attr($lang["view_id"]) ?>' 
												<?php if($defLang ==$lang["view_id"]){?>selected<?php }?>>
											<?php echo esc_attr($lang["name"]) ?>
										</option>
									<?php }?>
								</select>
								<input type="submit" class="button sofcar-plugin-action-btn" value="<?php  echo esc_html__('Generate Shortcode', 'sofcar'); ?>"  />		
							</div>		
						</div>	
					</form>	
					<?php if(isset($rqParams["sofcar_widget_generate"])){?>
						<br><br>
						<div align="center">
							<h3 style="margin-top: 30px;color:#999;font-size: 1.3rem;"><?php  echo esc_html__('Copy the Shortcode into your page', 'sofcar'); ?></h3>
							<div class="sofcar-plugin-shortocode-line">
								<?php echo esc_attr($sofcar_api->get_wp_shortcode($rqParams)); ?>
							</div>
						</div>
					<?php } ?>
					<div class="sofcar-plugin-shortocode-steps" style="">
						<hr />
						<h3><?php  echo esc_html__('How to insert shortcodes in WordPress?', 'sofcar'); ?></h3>
						<?php  echo esc_html__('You can insert shortcodes in WordPress on your: Posts, Pages, Widgets and Themes', 'sofcar'); ?>.<br>
						<?php  echo esc_html__('For example to insert shortcode into a WordPress post', 'sofcar'); ?>:<br>
						<ul>
							<li>1. <?php  echo esc_html__('Generate Shortcode', 'sofcar'); ?></li>
							<li>2. <?php  echo esc_html__('In the navigation menu, click Post', 'sofcar'); ?></li>
							<li>3. <?php  echo esc_html__('Click the post you want to edit', 'sofcar'); ?>.</li>
							<li>4. <?php  echo esc_html__('Click Text', 'sofcar'); ?>.</li>
							<li>5. <?php  echo esc_html__('Paste shortcode', 'sofcar'); ?>.</li>
							<li>6. <?php  echo esc_html__('Click “Update” to save your changes', 'sofcar'); ?>.</li>
						</ul>
					</div>
				<?php }elseif($current_tab=="booking"){ 
					$sofcar_bookings = $sofcar_api->get_last_bookings();
					?>
					<form method="post">
						<div class="tablenav top" style="margin: 0">
							<div class="alignleft actions"><h2 class="sofcar-sidebar-h2"><?php  echo esc_html__('Last bookings', 'sofcar'); ?></h2></div>
							<div class="sofcar-plugin-right">
								<a href="<?php echo esc_url( "?page=sofcar&tab=booking" ) ?>">
									<input type="button" class="button sofcar-plugin-action-btn" value="<?php  echo esc_html__('Refresh', 'sofcar'); ?>" style="font-size: 14px"  />
								</a>
								<a href="<?php echo $sofcar_api->get_host()."/tools/manualbooking/" ?>" target="_blank">
									<input type="button" class="button sofcar-plugin-action-btn sofcar-sidebar-btn2" value="<?php  echo esc_html__('New booking', 'sofcar'); ?>"  />
								</a>
							</div>
							<div class="sofcar-plugin-clear"></div>	
						</div>		
						<table class="wp-list-table widefat fixed striped posts sofcar-wp-table" style="margin: 15px 0">
							<thead>
								<tr>
									<td width="70"><?php  echo esc_html__('Ref', 'sofcar'); ?></td>
									<td width="80"><?php  echo esc_html__('Status', 'sofcar'); ?></td>
									<td width="180"><?php  echo esc_html__('Client', 'sofcar'); ?></td>
									<td width="220" class="sp-hidden-mobile"><?php  echo esc_html__('Model', 'sofcar'); ?></td>
									<td width="90" class="sp-hidden-mobile"><?php  echo esc_html__('Start date', 'sofcar'); ?></td>
									<td width="80" class="sp-hidden-mobile"><?php  echo esc_html__('Duration', 'sofcar'); ?></td>
									<td width="100" class="sp-hidden-mobile"><?php  echo esc_html__('User', 'sofcar'); ?></td>
									<td width="100"><?php  echo esc_html__('Actions', 'sofcar'); ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if(!sizeof($sofcar_bookings)){?>
									<tr class="no-items"><td class="colspanchange" colspan="4"><?php  echo esc_html__('No Bookings found', 'sofcar'); ?>.</td></tr>
								<?php }else{ ?>
									<?php foreach($sofcar_bookings as $booking){
										if(isset($booking["booking_id"])){
											$itemLink    = $sofcar_api->get_host()."/tools/booking/edit/booking_id/".$booking["booking_id"]; 
											$clientLink  = $sofcar_api->get_host()."/tools/client/edit/client_id/".$booking["client_id"]; 
											
											?>
											<tr>
												<td width="70"><?php echo esc_html($booking["ref"]) ?></td>
												<td width="80">
													<div class="sofcar-plugin-status sofcar-status-<?php echo esc_html($booking["booking_status_id"]) ?>">
														<?php echo esc_html($booking["booking_status"]) ?>
													</div>
												</td>
												<td width="180"><a href="<?php echo esc_url($clientLink) ?>" target="_blank"><?php echo esc_html($booking["client"]) ?></a></td>
												<td width="220" class="sp-hidden-mobile"><?php echo esc_html($booking["model"]) ?></td>
												<td width="90" class="sp-hidden-mobile"><?php echo esc_html($booking["start_date"]) ?></td>
												<td width="80" class="sp-hidden-mobile"><?php echo esc_html($booking["days"]) ?> <?php  echo esc_html__('days', 'sofcar'); ?></td>
												<td width="100" class="sp-hidden-mobile"><?php echo esc_html($booking["user_name"]) ?></td>
												<td width="100"><a href="<?php echo esc_url($itemLink) ?>" target="_blank"><?php  echo esc_html__('Manage', 'sofcar'); ?></a></td>
											</tr>
										<?php }?>
									<?php }?>
								<?php }?>
							</tbody>
						</table>
					</form>	
					<style type="text/css">
						.sofcar-plugin-init{width: 100% !important;padding: 10px 0 0 0 !important;}
						.sofcar-plugin-sidebar,.sofcar-plugin-hr{ display: none !important;}
						#adminmenu .wp-submenu li .wp-first-item
					</style>
				<?php } ?>
			<?php } ?>
			
			<script type="text/javascript">
				jQuery(document).ready(function(){ 
					jQuery("#adminmenu a").each(function() {
						var linkhref   = this.href;
						var currentTab = 'admin.php?page=sofcar&tab=<?php echo $current_tab ?>';
						if (linkhref.indexOf(currentTab) >= 0)jQuery(this).closest('li').addClass("current");
					});
				});
			</script>
			
		</div>
		<?php if($sofcar_api->validate_token()){ ?>			
			<div class="sofcar-plugin-sidebar">
				<div class="metabox-holder">
					<div class="postbox-container">
						<?php do_meta_boxes("post",'sidebar',null); ?>
					</div>
				</div>
			</div>	
		<?php } ?>
		<div class="sofcar-plugin-clear"></div>	
		<hr class="sofcar-plugin-hr" />
		<p class="sofcar-plugin-footer">
			<strong><?php echo esc_html__('Version:','sofcar'); ?></strong> <?php echo SOFCAR_VERSION; ?><br />
			<?php if(!$sofcar_api->validate_token()){ ?>
				<font style="color: #666"><?php echo esc_html__('Thank you for choosing Sofcar. We work to make your activation a seamless experience.','sofcar'); ?></font><br />
			<?php } ?>
			<?php echo esc_html__('All rights reserved','sofcar'); ?> Sofcar.com ©<?php echo date("Y") ?>. | 
			<a href='<?php echo esc_url( "https://www.sofcar.com") ?>' target='_blank'>www.sofcar.com</a> 
			<br />
		</p>
		
	</div>
</div>