<ul style="display: block;">
            					<li><a href="home.php"><i class="icon fa fa-dashboard"></i><span class="hidden-minibar">Dashboard</span></a></li>
                                 <?php if ($_SESSION['role'] == 'Admin'){ ?>
									<li><a href="customer.php"><i class="fa fa-group"></i><span class="hidden-minibar">Customers</span></a></li>
									<li><a href="item.php"><i class="fa fa-table"></i><span class="hidden-minibar">Items</span></a></li>
									<li><a href="supplier.php"><i class="fa fa-download"></i><span class="hidden-minibar">Suppliers</span></a></li>
                                    <li><a href="employee.php"><i class="fa fa-user"></i><span class="hidden-minibar">Employees</span></a></li>
                                <li><a href="receiving.php"><i class="fa fa-cloud-download"></i><span class="hidden-minibar">Receivings</span></a></li>
                                    <?php }?>
									<li><a href="reports.php"><i class="fa fa-bar-chart-o"></i><span class="hidden-minibar">Reports</span></a></li>
<li><a href="price_adjustment.php"><i class="fa fa-money"></i><span class="hidden-minibar">Price Adjustment</span></a></li>
									<li class="active"><a href="price.php"><i class="fa fa-shopping-cart"></i><span class="hidden-minibar">Sales</span></a></li>
                                    <li><a href="sales_receipt_list.php"><i class="fa fa-print"></i><span class="hidden-minibar">Reprint Receipt</span></a></li>
									
									<li><a href="locations.php"><i class="fa fa-home"></i><span class="hidden-minibar">Locations</span></a></li>
				                <li>
                	<a href="index.php"><i class="fa fa-power-off"></i><span class="hidden-minibar">Logout</span></a>
                </li>
			</ul>