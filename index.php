<?php
session_start();
require "connection.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>UAS Naive Bayes</title>
	<link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/sytle.css">
</head>
<body>
	<div id="bungkus">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="card mt-3 col-12 col-md-6 shadow">
					<div class="card-body col-12">
						<h3 class="card-title text-center">Data Training</h3><br>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
							Tambah Data
						</button>
						<div class="table-responsive">
							<table class="table table-bordered mt-3 text-center table-sm" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>Outlook</th>
										<th>Temperature</th>
										<th>Humidity</th>
										<th>Windy</th>
										<th>Play</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php

									$query = "SELECT * FROM tb_training";
									$result = mysqli_query($koneksi, $query);

									$queryid = "SELECT * FROM tb_training WHERE id IN (SELECT MAX(id) FROM tb_training)";
									$resultid = mysqli_query($koneksi, $queryid);
									$id_desc = mysqli_fetch_assoc($resultid);
									$i=1;

									foreach ($result as $training) { ?>
										<tr>
											<td><?php echo $i++?></td>
											<td><?php echo $training['outlook']?></td>
											<td><?php echo $training['temperature']?></td>
											<td><?php echo $training['humidity']?></td>
											<td><?php echo $training['windy']?></td>
											<td><?php echo $training['play']?></td>
											<td class="aksi">
												<!-- Button trigger modal -->
												<a class="text-decoration-none text-success pe-2" data-bs-toggle="modal" data-target="#editModal<?php echo $training['id'] ?>" href="#editModal<?php echo $training['id'] ?>">Edit</a>
												<?php
												if($training['id']==$id_desc['id']) : ?>
													|<a class="text-decoration-none text-danger ps-2" data-bs-toggle="modal" data-target="#hapusModal<?php echo $training['id'] ?>" href="#hapusModal<?php echo $training['id'] ?>">Hapus</a>
												<?php endif; ?>
											</td>

											<!-- Edit Modal -->
											<div class="modal fade" id="editModal<?php echo $training['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModal<?php echo $training['id'] ?>Label" aria-hidden="true">
												<div class="modal-dialog modal-dialog-scrollable">
													<form action="aksi_training.php?opsi=edit" method="POST">
														<input type="text" name="id" value="<?php echo $training['id'] ?>" hidden>
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="editModal<?php echo $training['id'] ?>Label">Edit Data</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<div class="row mb-3">
																	<label for="outlook" class="col-sm-4 col-form-label">Outlook</label>
																	<div class="col-sm-8">
																		<select id="outlook" name="outlook" class="form-select" value="">
																			<option value="sunny" <?php echo ($training['outlook'] == "sunny") ? "selected" : "" ?> >sunny</option>
																			<option value="rainy" <?php echo ($training['outlook'] == "rainy") ? "selected" : "" ?> >rainy</option>
																			<option value="cloudy" <?php echo ($training['outlook'] == "cloudy") ? "selected" : "" ?> >cloudy</option>
																		</select>
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="temperature" class="col-sm-4 col-form-label">Temperature</label>
																	<div class="col-sm-8">
																		<select id="temperature" name="temperature" class="form-select" value="">
																			<option value="hot" <?php echo ($training['temperature'] == "hot") ? "selected" : "" ?> >hot</option>
																			<option value="mild" <?php echo ($training['temperature'] == "mild") ? "selected" : "" ?> >mild</option>
																			<option value="cool" <?php echo ($training['temperature'] == "cool") ? "selected" : "" ?> >cool</option>
																		</select>
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="humidity" class="col-sm-4 col-form-label">Humidity</label>
																	<div class="col-sm-8">
																		<select id="humidity" name="humidity" class="form-select" value="">
																			<option value="high" <?php echo ($training['humidity'] == "high") ? "selected" : "" ?> >high</option>
																			<option value="normal" <?php echo ($training['humidity'] == "normal") ? "selected" : "" ?> >normal</option>
																		</select>
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="windy" class="col-sm-4 col-form-label">Windy</label>
																	<div class="col-sm-8">
																		<select id="windy" name="windy" class="form-select" value="">
																			<option value="true" <?php echo ($training['windy'] == "true") ? "selected" : "" ?> >true</option>
																			<option value="false" <?php echo ($training['windy'] == "false") ? "selected" : "" ?> >false</option>
																		</select>
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="play" class="col-sm-4 col-form-label">Play</label>
																	<div class="col-sm-8">
																		<select id="play" name="play" class="form-select" value="">
																			<option value="yes" <?php echo ($training['play'] == "yes") ? "selected" : "" ?> >yes</option>
																			<option value="no" <?php echo ($training['play'] == "no") ? "selected" : "" ?> >no</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="modal-footer justify-content-center">

																<input type="submit" name="submit" value="Edit" class="btn btn-primary text-white col-12 col-lg p-2">

															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- Hapus Modal -->
											<div class="modal fade" id="hapusModal<?php echo $training['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusModal<?php echo $training['id'] ?>Label" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title fw-bolder" id="hapusModal<?php echo $training['id'] ?>Label">Konfirmasi</h5>
														</div>
														<div class="modal-body">
															<h5>Yakin Menghapus Data ke <?php echo $i-1?>?</h5>
														</div>
														<div class="modal-footer justify-content">

															<button type="button" class="btn btn-secondary pe-3" data-bs-dismiss="modal" aria-label="Close">Batal</button>

															<a class="btn btn-danger px-4 text-decoration-none text-danger text-white" href="aksi_training.php?id=<?php echo $training['id']?>&opsi=delete">Ya</a>

														</div>
													</div>
												</div>
											</div>
										</tr>

									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-6">
					<div class="card mt-3 shadow">
						<div class="card-body col-12">
							<h3 class="card-title text-center">Data Testing</h3><br>
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testingModal">
								Tambah Data
							</button>
							<div class="table-responsive">
								<table class="table table-bordered mt-3 text-center table-sm" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>No</th>
											<th>Outlook</th>
											<th>Temperature</th>
											<th>Humidity</th>
											<th>Windy</th>
											<th>Play</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php

										$query = "SELECT * FROM tb_testing";
										$result = mysqli_query($koneksi, $query);
										$count_row = mysqli_num_rows($result);

										$queryid = "SELECT * FROM tb_testing WHERE id IN (SELECT MAX(id) FROM tb_testing)";
										$resultid = mysqli_query($koneksi, $queryid);
										$id_desc = mysqli_fetch_assoc($resultid);
										$i=1;

										foreach ($result as $testing) { ?>
											<tr>
												<td><?php echo $i++?></td>
												<td><?php echo $testing['outlook']?></td>
												<td><?php echo $testing['temperature']?></td>
												<td><?php echo $testing['humidity']?></td>
												<td><?php echo $testing['windy']?></td>
												<td><?php echo $testing['play']?></td>
												<td class="aksi">
													<!-- Button trigger modal -->
													<a class="text-decoration-none text-success pe-2" data-bs-toggle="modal" data-target="#edittestingModal<?php echo $testing['id'] ?>" href="#edittestingModal<?php echo $testing['id'] ?>">Edit</a>
													<?php
													if($testing['id']==$id_desc['id']) : ?>
														|<a class="text-decoration-none text-danger ps-2" data-bs-toggle="modal" data-target="#hapustestingModal<?php echo $testing['id'] ?>" href="#hapustestingModal<?php echo $testing['id'] ?>">Hapus</a>
													<?php endif; ?>
												</td>

												<!-- Edit Modal -->
												<div class="modal fade" id="edittestingModal<?php echo $testing['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edittestingModal<?php echo $testing['id'] ?>Label" aria-hidden="true">
													<div class="modal-dialog modal-dialog-scrollable">
														<form action="aksi_testing.php?opsi=edit" method="POST">
															<input type="text" name="id" value="<?php echo $training['id'] ?>" hidden>
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="edittestingModal<?php echo $testing['id'] ?>Label">Edit Data</h5>
																	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>
																<div class="modal-body">
																	<div class="row mb-3">
																		<label for="outlook" class="col-sm-4 col-form-label">Outlook</label>
																		<div class="col-sm-8">
																			<select id="outlook" name="outlook" class="form-select" value="">
																				<option value="sunny" <?php echo ($testing['outlook'] == "sunny") ? "selected" : "" ?> >sunny</option>
																				<option value="rainy" <?php echo ($testing['outlook'] == "rainy") ? "selected" : "" ?> >rainy</option>
																				<option value="cloudy" <?php echo ($testing['outlook'] == "cloudy") ? "selected" : "" ?> >cloudy</option>
																			</select>
																		</div>
																	</div>
																	<div class="row mb-3">
																		<label for="temperature" class="col-sm-4 col-form-label">Temperature</label>
																		<div class="col-sm-8">
																			<select id="temperature" name="temperature" class="form-select" value="">
																				<option value="hot" <?php echo ($testing['temperature'] == "hot") ? "selected" : "" ?> >hot</option>
																				<option value="mild" <?php echo ($testing['temperature'] == "mild") ? "selected" : "" ?> >mild</option>
																				<option value="cool" <?php echo ($testing['temperature'] == "cool") ? "selected" : "" ?> >cool</option>
																			</select>
																		</div>
																	</div>
																	<div class="row mb-3">
																		<label for="humidity" class="col-sm-4 col-form-label">Humidity</label>
																		<div class="col-sm-8">
																			<select id="humidity" name="humidity" class="form-select" value="">
																				<option value="high" <?php echo ($training['humidity'] == "high") ? "selected" : "" ?> >high</option>
																				<option value="normal" <?php echo ($training['humidity'] == "normal") ? "selected" : "" ?> >normal</option>
																			</select>
																		</div>
																	</div>
																	<div class="row mb-3">
																		<label for="windy" class="col-sm-4 col-form-label">Windy</label>
																		<div class="col-sm-8">
																			<select id="windy" name="windy" class="form-select" value="">
																				<option value="true" <?php echo ($training['windy'] == "true") ? "selected" : "" ?> >true</option>
																				<option value="false" <?php echo ($training['windy'] == "false") ? "selected" : "" ?> >false</option>
																			</select>
																		</div>
																	</div>
																	<div class="row mb-3">
																		<label for="play" class="col-sm-4 col-form-label">Play</label>
																		<div class="col-sm-8">
																			<select id="play" name="play" class="form-select" value="">
																				<option value="yes" <?php echo ($training['play'] == "yes") ? "selected" : "" ?> >yes</option>
																				<option value="no" <?php echo ($training['play'] == "no") ? "selected" : "" ?> >no</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="modal-footer justify-content-center">

																	<input type="submit" name="submit" value="Edit" class="btn btn-primary text-white col-12 col-lg p-2">

																</div>
															</div>
														</form>
													</div>
												</div>
												<!-- Hapus Modal -->
												<div class="modal fade" id="hapustestingModal<?php echo $testing['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapustestingModal<?php echo $testing['id'] ?>Label" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title fw-bolder" id="hapustestingModal<?php echo $testing['id'] ?>Label">Konfirmasi</h5>
															</div>
															<div class="modal-body">
																<h5>Yakin Menghapus Data ke <?php echo $i-1?>?</h5>
															</div>
															<div class="modal-footer justify-content">

																<button type="button" class="btn btn-secondary pe-3" data-bs-dismiss="modal" aria-label="Close">Batal</button>

																<a class="btn btn-danger px-4 text-decoration-none text-danger text-white" href="aksi_testing.php?id=<?php echo $testing['id']?>&opsi=delete">Ya</a>

															</div>
														</div>
													</div>
												</div>
											</tr>

										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--  Tambah Modal -->
				<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<form action="aksi_training.php?opsi=input" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="tambahModalLabel">Tambah Data</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="row mb-3">
										<label for="outlook" class="col-sm-4 col-form-label">Outlook</label>
										<div class="col-sm-8">
											<select id="outlook" name="outlook" class="form-select">
												<option value="sunny">Sunny</option>
												<option value="cloudy">Cloudy</option>
												<option value="rainy">Rainy</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="temperature" class="col-sm-4 col-form-label">Temperature</label>
										<div class="col-sm-8">
											<select id="temperature" name="temperature" class="form-select" >
												<option value="hot">Hot</option>
												<option value="mild">Mild</option>
												<option value="cool">Cool</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="humidity" class="col-sm-4 col-form-label">Humidity</label>
										<div class="col-sm-8">
											<select id="humidity" name="humidity" class="form-select">
												<option value="high">High</option>
												<option value="normal">Normal</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="windy" class="col-sm-4 col-form-label">Windy</label>
										<div class="col-sm-8">
											<select id="windy" name="windy" class="form-select">
												<option value="true">True</option>
												<option value="false">False</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="play" class="col-sm-4 col-form-label">Play</label>
										<div class="col-sm-8">
											<select id="play" name="play" class="form-select">
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="modal-footer justify-content-center">

									<input type="submit" name="submit" value="Simpan" class="btn btn-primary text-white col-12 col-lg-11 p-2">

								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- Tambah Modal -->
				<!--  Tambah Modal -->
				<div class="modal fade" id="testingModal" tabindex="-1" aria-labelledby="testingModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<form action="aksi_testing.php?opsi=input" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="testingModalLabel">Tambah Data</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="row mb-3">
										<label for="outlook" class="col-sm-4 col-form-label">Outlook</label>
										<div class="col-sm-8">
											<select id="outlook" name="outlook" class="form-select">
												<option value="sunny">Sunny</option>
												<option value="cloudy">Cloudy</option>
												<option value="rainy">Rainy</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="temperature" class="col-sm-4 col-form-label">Temperature</label>
										<div class="col-sm-8">
											<select id="temperature" name="temperature" class="form-select" >
												<option value="hot">Hot</option>
												<option value="mild">Mild</option>
												<option value="cool">Cool</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="humidity" class="col-sm-4 col-form-label">Humidity</label>
										<div class="col-sm-8">
											<select id="humidity" name="humidity" class="form-select">
												<option value="high">High</option>
												<option value="normal">Normal</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="windy" class="col-sm-4 col-form-label">Windy</label>
										<div class="col-sm-8">
											<select id="windy" name="windy" class="form-select">
												<option value="true">True</option>
												<option value="false">False</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="play" class="col-sm-4 col-form-label">Play</label>
										<div class="col-sm-8">
											<select id="play" name="play" class="form-select">
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="modal-footer justify-content-center">

									<input type="submit" name="submit" value="Simpan" class="btn btn-primary text-white col-12 col-lg-11 p-2">

								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- Tambah Modal -->

				<!-- batas -->
				<div class="col-12 my-4" style="border-bottom: 2px solid #8c8a8a;"></div>
				<!-- end batas -->

				<!-- Hitung -->
				<div id="hitung" class="mb-5">
					<div class="col-12">
						<div class="card mt-3 shadow">
							<div class="card-body col-12">
								<div class="head">
									<?php
									if ($count_row > 0) { ?>
										<a href="?aksi=hitung#hitung" class="btn btn-primary"> <i class="fas fa-calculator"></i> Hitung</a>
									<?php } ?>
									<a href="?#hitung" class="btn btn-danger mx-3"> <i class="fas fa-redo"></i> Reset Hitungan</a>
								</div>
								<?php
								$hitung = (isset($_GET['aksi'])) ? $_GET['aksi'] : "";
								if (!empty($hitung)) {
									require('hitung.php');
								} ?>
							</div>
							<!-- Hitung -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>
	<?php
	require('script.php');
?>