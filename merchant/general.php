<?php 
include_once('application_main.php');

$posPageName = "merchant"; 

$objapp->authenticateMerchant();

$objMerchant = new merchant;

$merchantData =  $objMerchant->get($objapp->authMerchantId);

?>

<?php include_once '../header.php'; ?>
 

<div class="jumbotron">
	<div class="container-fluid">
            <!-- / fixed menu section -->
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			 
			 <?php include_once('left_sidebar.php'); ?>
		</div>
		<div class="row">

		<span class="mobile-menu" onclick="openNav()">&#9776; open</span>
		<!-- / fixed menu section end -->
		<div class="col-sm-10 col-sm-push-2 col-xs-12">
			<div id="breadcrumbs" class="line">
				<a href="/setup">Setup</a>> General
			</div>
			<div class="col-sm-12 col-xs-12">
				<div class="general-title">
					General Setup
				</div>
			</div>
			 <div class="clearfix"></div>
			<form>
			<!-- / form 1 -->
				<div class="form-1">
					<div class="row">
						<div class="col-sm-12 col-xs-12 no-padding">
							<div class="form-bg">
								<div class="col-sm-12 col-xs-12 no-padding">
									<div class="general-form-heading">Store Settings</div>
								</div>
								<!-- / form left -->
								<div class="col-sm-6 col-xs-12 no-padding border-padding">
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="storeName">Store name</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="storeName" placeholder="Store name">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="privateURL">Private URL</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="url" disabled class="form-control" id="privateURL" placeholder="Private URL">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="defaultCurrency">Default currency</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Disabled select</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="timeZone">Time zone</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Disabled select</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="displayPrices">Display prices</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Disabled select</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- / form right -->
								<div class="col-sm-6 col-xs-12 no-padding border-padding no-border">
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="defaultCurrency">Label printer format</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Disabled select</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="skuGeneration">SKU generation</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Disabled select</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="currentSequenceNumber">Current sequence number</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="url" class="form-control" id="privateURL" placeholder="1000">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="userSwitchingSecurity">User switching security</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Disabled select</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class="doted-border"></div>
								<!-- / form button / -->
								<div class="col-sm-12 col-xs-12 no-padding">
									<button class="flot-right btn btn-default" type="submit">Cancle</button>
									<button class="flot-right btn btn-default" type="submit">Save</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- / form 2-->
				<div class="form-1">
					<div class="row">
						<div class="col-sm-12 col-xs-12 no-padding">
							<div class="form-bg">
								<div class="col-sm-12 col-xs-12 no-padding">
									<div class="general-form-heading">Contact Information</div>
								</div>
								<!-- / form left / -->
								<div class="col-sm-6 col-xs-12 no-padding border-padding">
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="contactName">Contact name</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<div class="row">
													<div class="col-sm-6 col-xs-12">
														<input type="text" class="form-control" id="storeName" placeholder="first name">
													</div>
													<div class="col-sm-6 col-xs-12">
														<input type="text" class="form-control" id="storeName" placeholder="Last name">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="email">Email</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="emlil" class="form-control" id="email" placeholder="Private URL">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="phone">Phone</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="tel" class="form-control" id="phone" placeholder="Private Phone">
											</div>
										</div>
									</div>
								</div>
								<!-- / form right /-->
								<div class="col-sm-6 col-xs-12 no-padding border-padding no-border">
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="website">Website</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="url" class="form-control" id="website" placeholder="Website">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="twitter">Twitter</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="url" class="form-control" id="twitter" placeholder="Twitter">
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class="doted-border"></div>
								<!-- / form button / -->
								<div class="col-sm-12 col-xs-12 no-padding">
									<button class="flot-right btn btn-default" type="submit">Cancle</button>
									<button class="flot-right btn btn-default" type="submit">Save</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- / form 3 / -->
				<div class="form-1">
					<div class="row">
						<div class="col-sm-12 col-xs-12 no-padding">
							<div class="form-bg">
								<div class="col-sm-12 col-xs-12 no-padding">
									<div class="general-form-heading">Address</div>
								</div>
								<!-- / form left / -->
								<div class="col-sm-6 col-xs-12 no-padding border-padding">
									<div class="address-heading">
										Physical Address
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="street1">Street1</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="street1" placeholder="Street1">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="street2">Street2</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="street2" placeholder="Street2">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="suburb">Suburb</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="suburb" placeholder="Suburb">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="city">City</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="city" placeholder="City">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="physicalPostcode">Physical Postcode</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="physicalPostcode" placeholder="Physical Postcode">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="state">State</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="state" placeholder="State">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="country">Country</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Country</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- / form right / -->
								<div class="col-sm-6 col-xs-12 no-padding border-padding no-border">
									<div class="address-heading">
										<div class="col-sm-4 col-xs-12 no-padding">Postal Address</div><div class="col-sm-8 col-xs-12"><a href="#">Same as Physical Address</a></div>
										<div class="clearfix"></div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="street1">Street1</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="street1" placeholder="Street1">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="street2">Street2</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="street2" placeholder="Street2">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="suburb">Suburb</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="suburb" placeholder="Suburb">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="city">City</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="city" placeholder="City">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="physicalPostcode">Physical Postcode</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="physicalPostcode" placeholder="Physical Postcode">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="state">State</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<input type="text" class="form-control" id="state" placeholder="State">
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12 no-padding">
										<div class="form-group">
											<div class="col-sm-4 col-xs-12">
												<label for="country">Country</label>
											</div>
											<div class="col-sm-8 col-xs-12">
												<select class="form-control">
													<option>Country</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class="doted-border"></div>
								<!-- / form button / -->
								<div class="col-sm-12 col-xs-12 no-padding">
									<button class="flot-right btn btn-default" type="submit">Cancle</button>
									<button class="flot-right btn btn-default" type="submit">Save</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- /.col-sm-9 -->
		</div>
	</div>
	<!--/.container-fluid-->
</div>

<?php include_once '../footer.php'; ?>
 