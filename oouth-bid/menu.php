<ul style="display: block;">
            					<li><a href="home.php"><i class="icon fa fa-dashboard"></i><span class="hidden-minibar">Dashboard</span></a></li>
                                 <li><a href="upload2.php"><i class="fa fa-cloud-download"></i><span class="hidden-minibar">Upload Bid <br>Document</span></a></li>
									<li><a href="price.php"><i class="fa fa-table"></i><span class="hidden-minibar">Add Price</span></a></li>
									<?php if ($_SESSION['role'] == 'Admin'){ ?> <li><a href="evaluation.php"><i class="fa fa-print"></i><span class="hidden-minibar">Evaluation</span></a></li>
    
                                <li><a href="companyWinning.php"><i class="fa fa-print"></i><span class="hidden-minibar">Print Company<br> Winnings</span></a></li>
								<li><a href="deptWinning.php"><i class="fa fa-print"></i><span class="hidden-minibar">Bid summary<br> by Dept</span></a></li>
                                <li><a href="supplimentary.php"><i class="fa fa-print"></i><span class="hidden-minibar">Print <br>Supplimentary</span></a></li>
								<?php } ?>
				                <li>
                	<a href="index.php"><i class="fa fa-power-off"></i><span class="hidden-minibar">Logout</span></a>
                </li>
			</ul>