<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	
	<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
	<script type="text/javascript">
		/* Datepicker bootstrap */

		$(function() {
			"use strict";
			$('.bootstrap-datepicker').bsdatepicker({
				format: 'mm-dd-yyyy'
			});
		});
	</script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
</head>


<body>
    <div id="sb-site">
        
		<?php require_once("incOpenLayout.fya"); ?>
		
		
        <?php require_once("incLoader.fya"); ?>
		
        <div id="page-wrapper">
            <div id="mobile-navigation"><button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button></div>
            
				<?php require_once("incLeftMenu.fya"); ?>
			
            <div id="page-content-wrapper">
                <div id="page-content">
                    
					<?php require_once("incHeader.fya"); ?>
					<body>
                	<div class="tab-pane pad0A fade active in" id="tab-example-4"><div class="content-box">
					<?php
					$DB = Connect();

$strID = DecodeQ(Filter($_GET['uid']));
//$sql_appointments = "SELECT * FROM tblAppointments WHERE AppointmentID='".$strID."'";
$sql_appointments = select("*","tblAppointments","AppointmentID='".$strID."'");
$sql_name = select("CustomerFullName","tblCustomers
","CustomerID='".$sql_appointments[0]['CustomerID']."'");
$sql_store = select("StoreName","tblStores","StoreID='".$sql_appointments[0]['StoreID']."'");

?>	
					
					
											<form class="form-horizontal pad15L pad15R bordered-row">
													<div class="form-group remove-border"><label class="col-sm-3 control-label">Customer Name</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_name[0]['CustomerFullName']; ?></label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Store Name:</label>
														<div class="col-sm-6">
															<label class="col-sm-3 control-label"><?php echo $sql_store[0]['StoreName']; ?>
															</label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Date:</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentDate']; ?>	</label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Offer ID:</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentOfferID']; ?>	</label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Check In Time:</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentCheckInTime']; ?></label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Check Out Time:</label>
														<div class="col-sm-6">
															<label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentCheckOutTime']; ?>
															</label>
														</div>
													</div>
												</form>
					<script type="text/javascript" src="assets/widgets/sticky/sticky.js"></script>
                    <script type="text/javascript" src="assets/widgets/tocify/tocify.js"></script>
                    <script type="text/javascript">
                        $(function() {
                            var toc = $("#tocify-menu").tocify({
                                context: ".toc-tocify",
                                showEffect: "fadeIn",
                                extendPage: false,
                                selectors: "h2, h3, h4"
                            });
                        });
                        jQuery(document).ready(function($) {

                            /* Sticky bars */

                            $(function() {
                                "use strict";

                                $('.sticky-nav').hcSticky({
                                    top: 50,
                                    innerTop: 50,
                                    stickTo: 'document'
                                });

                            });

                        });
                    </script>
					<div id="page-title">
                        <h2 class="mrg20B">Auto menu</h2>
                        <p class="mrg15B">Example navigation menu generated automatically based on headings.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sticky-nav">
                                <div id="tocify-menu"></div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="toc-tocify">
                                        <h2 class="mrg20B">Lorem ipsum dolor sit amet</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Consectetur adipiscing elit. Curabitur tempor elit metus, id tincidunt sapien molestie id. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer in porttitor enim. Aenean tortor risus, porta eu vehicula et, scelerisque quis lorem. Maecenas ultrices volutpat ex. Sed ultrices, diam ac condimentum sagittis, nisl lectus pulvinar lorem, vel commodo purus mi eu turpis. Curabitur justo sapien, facilisis ac leo et, elementum porta diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum feugiat neque at magna aliquet fringilla. Ut a varius nunc, at commodo dui. Fusce iaculis ante sem, nec accumsan massa venenatis vel. Nam pulvinar mauris quis nisi interdum finibus. Etiam enim risus, imperdiet vitae ante quis, dapibus dictum quam.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Proin tempus gravida ultricies. Integer mi nibh, eleifend id nibh eu, consequat feugiat nisl. Curabitur odio dui, faucibus ac eleifend ac, dapibus quis lacus. Nam a tortor tortor. Curabitur eu venenatis justo, at malesuada leo. Nullam fermentum interdum ante blandit tempor. Nam blandit massa tellus, eget convallis metus imperdiet a. Cras efficitur placerat nisl. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus posuere nibh nec iaculis sollicitudin. Praesent mi elit, interdum a rhoncus elementum, lacinia vitae mi. In quis feugiat purus.</p>
                                        <h2 class="mrg20B">Duis auctor in nisl quis commodo</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">In hac habitasse platea dictumst. Proin sit amet dui lorem. Mauris tempor vehicula massa a venenatis. Morbi auctor nunc leo, sed blandit urna mollis ac. Nunc sapien mi, aliquet vitae viverra in, euismod id ligula. Etiam laoreet arcu eros, vitae consectetur nulla auctor vitae. Aenean dictum venenatis lacus ac luctus. Pellentesque ac metus sed nibh lobortis sodales euismod eu mauris. Nam nec tellus nisl. Nullam faucibus, felis in convallis eleifend, tortor arcu sagittis tortor, a aliquam neque libero ut nibh. Duis venenatis faucibus lobortis. Etiam dignissim ante quis turpis egestas fringilla at consequat purus. Duis ornare congue sapien eget pharetra. Donec sit amet consectetur nulla. Morbi fermentum auctor erat, ac dignissim justo tincidunt nec.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Suspendisse fermentum mollis pellentesque. Fusce mattis rutrum mi, nec dictum libero. Fusce quis lacus purus. Donec vehicula, arcu eget viverra aliquam, tortor libero ultrices lorem, non sagittis est elit eu nulla. Vestibulum nunc erat, varius ut consequat sed, pharetra vel velit. Integer hendrerit justo ac facilisis pulvinar. Praesent luctus condimentum enim, sit amet bibendum ipsum dignissim non. Morbi nec vulputate orci. Curabitur a porttitor eros, vel pharetra diam.</p>
                                        <h2 class="mrg20B">Sed consectetur ullamcorper nibh</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Eget elementum ipsum semper in. Pellentesque vel dignissim enim. Aliquam volutpat placerat felis, vel condimentum elit ultrices at. Donec sed semper risus, tempor convallis massa. Duis lectus velit, efficitur et dolor ac, consectetur placerat lacus. Donec volutpat commodo tellus et interdum. Suspendisse urna lectus, lobortis id aliquet in, congue at felis. Suspendisse eget sollicitudin elit.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Quisque gravida, nulla ac euismod vestibulum, libero odio mollis nunc, vitae ultricies ante velit eu lectus. In hac habitasse platea dictumst. Morbi luctus nisi commodo risus tincidunt, a sagittis quam placerat. Phasellus lobortis diam non molestie gravida. Praesent gravida velit eget lacus iaculis dapibus. Nulla facilisi. Nam cursus mattis orci, in malesuada lectus. Cras laoreet suscipit pulvinar. Donec metus nulla, malesuada eu leo sit amet, tempus pretium leo. Quisque lacinia leo a mauris iaculis malesuada. Aliquam non mauris lacus. Quisque ut mauris cursus, congue metus non, tincidunt lorem. Pellentesque volutpat aliquet sem eget aliquet. Pellentesque vehicula eu est eget porttitor. Donec lorem nulla, pharetra ut molestie et, commodo vitae ipsum. Nullam dictum finibus orci ut tincidunt.</p>
                                        <h3 class="mrg20B">Aenean tincidunt dolor</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Nulla condimentum laoreet interdum. Phasellus sit amet libero tempus, convallis lectus vitae, dictum libero. Donec mauris ante, fermentum vel est eget, aliquam lacinia enim. Duis ultrices est bibendum neque condimentum, eu luctus nisl vehicula. Nam facilisis felis luctus dolor ultricies posuere. Nam nec semper dolor. Aenean vitae ante et nunc placerat venenatis. Proin est neque, volutpat ut massa id, sollicitudin rhoncus ipsum.</p>
                                        <h3 class="mrg20B">In hac habitasse platea dictumst</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Phasellus commodo, orci sit amet pharetra semper, sem neque placerat arcu, vitae interdum turpis magna at ante. In hac habitasse platea dictumst. In sed vehicula est. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus urna est, rhoncus eget nibh quis, tempus vestibulum justo. Vivamus eu ligula vel odio porttitor fermentum. Nullam iaculis porta felis, a malesuada magna porttitor eget. Ut pulvinar est at nisl commodo, blandit pulvinar ipsum porttitor. Aenean pellentesque, mi vel maximus egestas, enim massa accumsan risus, vitae ornare eros mauris vitae nunc. Etiam in placerat lacus. Sed in fringilla orci. Sed elit felis, rutrum non nisl eget, auctor pretium libero. Nullam ac massa lacinia, volutpat orci eget, elementum velit. Sed justo dolor, tempor vel tristique ut, posuere et magna. Donec volutpat purus pellentesque orci efficitur, ut egestas ligula viverra.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Vivamus quis vehicula metus, tristique facilisis nunc. Mauris sollicitudin commodo lectus, at dapibus ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas ac lacus massa. Curabitur tincidunt orci ligula, fermentum placerat mauris rhoncus vel. Curabitur felis urna, consectetur vel euismod nec, vestibulum id nisl. Suspendisse arcu nulla, elementum ac commodo id, auctor sit amet lacus. Aliquam erat volutpat. Praesent lobortis turpis a tellus vehicula molestie. Phasellus rhoncus felis elit.</p>
                                        <h2 class="mrg20B">Praesent vel sollicitudin arcu</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Nam enim est, porta at velit ac, interdum sollicitudin massa. Duis mauris turpis, dictum vitae ante sed, lobortis tincidunt velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut a nulla feugiat, pellentesque quam ac, porta magna. Donec commodo, odio in scelerisque pretium, orci risus tempor massa, vitae scelerisque nisi nisi eget dui. Donec condimentum eu odio vitae interdum. Suspendisse ut semper leo. Sed laoreet volutpat congue. Mauris dolor risus, ultricies vel malesuada in, dignissim eu quam. Sed varius iaculis urna, ac convallis tortor pellentesque eget.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Donec blandit tellus felis, et tempus odio feugiat vitae. Sed eu consectetur lacus. Nullam nibh ligula, scelerisque non convallis eu, euismod eget tellus. Integer hendrerit et turpis et porttitor. Aliquam at maximus diam. Mauris finibus efficitur consectetur. In nisl metus, pharetra ac elit non, egestas semper metus. Proin faucibus lacus nec est ultricies, at efficitur justo volutpat. Vestibulum condimentum sodales purus, pulvinar gravida lorem porttitor ac. Cras eget arcu a sapien tincidunt pretium. Maecenas a lectus dolor. Nulla non luctus ante. In vestibulum, mauris id bibendum viverra, lectus mauris eleifend felis, ac consectetur massa ante sit amet enim. Phasellus aliquam est justo, in facilisis tellus volutpat in. Fusce cursus magna ipsum, et aliquet urna pretium eget. Ut lacinia neque ut purus pulvinar, eget hendrerit massa scelerisque.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Morbi a augue at velit porttitor tempus sit amet sit amet nisl. Suspendisse neque nisl, sagittis ut vulputate sed, ullamcorper eu neque. Integer ac elementum sem, a vestibulum mauris. Fusce lacus erat, laoreet quis nibh ultrices, vulputate consequat nibh. Vestibulum nisl diam, porta quis turpis fermentum, laoreet pretium justo. Vestibulum faucibus massa lectus, pulvinar ultricies sapien varius vel. Pellentesque odio elit, tincidunt facilisis enim nec, venenatis imperdiet justo. Etiam varius sed velit at blandit.</p>
                                        <h2 class="mrg20B">Morbi at eros non risus lacinia placerat</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Nam suscipit est quis ligula venenatis, pellentesque venenatis erat porta. Nunc iaculis mauris ut quam hendrerit, eu pretium nisi tempus. Sed nec enim sem. Morbi cursus pellentesque lorem, sit amet egestas nibh tempor ut. Sed felis arcu, porttitor vel felis ut, porta venenatis neque. Aenean pharetra eleifend nisl. Nullam lacinia metus sit amet nunc varius, id aliquam neque congue.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Pellentesque cursus a tortor ut euismod. Phasellus in lacinia mauris. Aliquam accumsan dui at orci tempus, non viverra leo pellentesque. Sed at nibh posuere lacus ullamcorper pellentesque quis et nisl. Pellentesque laoreet quam id scelerisque bibendum. Phasellus viverra porta urna eu elementum. Mauris dapibus vulputate sapien, at congue ex rutrum ac. Donec ullamcorper augue non augue condimentum, non rhoncus quam viverra. Mauris feugiat convallis viverra. Curabitur non facilisis mi. Sed ullamcorper arcu sed risus dictum cursus. Sed malesuada lacus ac justo finibus cursus. Fusce pulvinar enim non mauris vehicula, sit amet rhoncus leo mollis. Pellentesque sem elit, placerat sit amet nisl non, mattis accumsan lectus. Etiam sodales risus nisi, id tempor tellus tincidunt id. Nullam enim mauris, mollis vulputate laoreet ut, aliquet a justo.</p>
                                        <h2 class="mrg20B">Curabitur tortor purus</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Sagittis a pharetra fringilla, eleifend quis est. Quisque purus dolor, eleifend et orci eu, eleifend euismod nulla. Cras hendrerit tellus eget ipsum efficitur, et faucibus augue laoreet. Sed sed sagittis ipsum. Proin et elit a sapien vestibulum accumsan. Nam sed luctus est. Aenean sed dui sodales, egestas purus vel, elementum elit. Proin iaculis magna eget ante iaculis, id dignissim mauris ullamcorper.</p>
                                        <h3 class="mrg20B">Donec sit amet nunc</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Ac ante porta tempus at eget dolor. In euismod iaculis egestas. Integer felis purus, blandit quis nisl vel, pellentesque varius enim. Ut et rutrum purus. Pellentesque suscipit ex vitae urna fermentum ornare nec non elit. Morbi vel ornare tortor. In eleifend lacus ut purus euismod, vitae cursus velit sagittis. Nam tincidunt ac neque quis eleifend. Praesent pharetra, urna laoreet rutrum sagittis, elit nulla aliquam nunc, in aliquet tortor metus nec tellus. Nullam eu justo neque.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Proin lobortis tempor arcu ut ornare. Praesent bibendum nibh sodales, congue nisi vitae, convallis enim. Sed sed mollis leo, nec malesuada eros. Praesent convallis nisl augue, et congue magna interdum a. Nunc tellus mi, dapibus nec orci sed, scelerisque maximus urna. Nulla a orci eget enim vulputate tristique dignissim quis odio. Aenean tristique fermentum sapien. Nunc non ligula convallis, aliquet mauris eu, bibendum ex. Sed id imperdiet lacus, vitae semper magna. Phasellus risus ipsum, ullamcorper vel elit nec, convallis vehicula elit.</p>
                                        <h3 class="mrg20B">Cras sed sodales nunc</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Pellentesque a risus luctus, ullamcorper magna ut, fringilla quam. Fusce lacinia ipsum sem, sed vulputate lacus molestie a. Maecenas ullamcorper interdum maximus. Integer sed maximus orci. Proin vitae nulla sed augue laoreet vulputate. Maecenas odio lectus, pretium in molestie et, facilisis nec urna. Nunc luctus mollis metus lobortis ornare. Vestibulum viverra accumsan leo in pharetra. Nulla id enim non ipsum lobortis sagittis. Vivamus ac dolor ac nisl lacinia vulputate.</p>
                                        <h3 class="mrg20B">Aliquam eget tempor mauris</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Vestibulum euismod dolor et lectus porta, maximus vestibulum velit tristique. Morbi ornare ultricies nibh in bibendum. Vestibulum laoreet porttitor libero luctus ultricies. In hac habitasse platea dictumst. Quisque blandit velit eget magna luctus mattis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse feugiat imperdiet magna, eu auctor massa facilisis in. Curabitur accumsan mi et ligula fermentum, sollicitudin fermentum lacus ullamcorper. Proin malesuada quis sapien ac auctor. Nulla facilisi. Etiam viverra dictum quam, ut sollicitudin nisl fringilla vitae.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Suspendisse mollis, sapien eget scelerisque malesuada, tortor ex pharetra elit, et elementum mauris libero a felis. In quis risus facilisis, commodo magna eleifend, varius metus. Aenean quis lorem enim. Cras aliquet, quam vehicula sodales vulputate, odio mi pretium lorem, sit amet vestibulum ipsum nisl ut massa. Vestibulum pharetra est in orci mollis, sit amet condimentum eros convallis. Sed in elit dolor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sit amet nibh et nibh vestibulum vestibulum. Curabitur maximus dignissim sem, sit amet vulputate nisl ultrices sit amet.</p>
                                        <h2 class="mrg20B">In id tempus metus</h2>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Mauris pretium dignissim pulvinar. Vivamus lectus ante, ullamcorper in turpis eu, tristique gravida dui. Nullam mattis lacus et nisl consequat, id sodales metus luctus. In placerat sed urna at tempor. Duis commodo ut mauris eget scelerisque. Nunc laoreet purus a lacus sagittis, vitae tempor lorem lobortis. Sed vitae diam arcu. Ut sit amet tellus quam. Aliquam tristique velit mauris. Mauris tempor neque eget diam laoreet volutpat. Fusce a gravida lectus, faucibus condimentum nibh. Aenean ac metus vitae nisl laoreet faucibus. Sed suscipit vel magna id sodales.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Donec congue cursus metus, eget sodales nisl gravida in. Phasellus molestie massa nec ex efficitur, mattis tempus sem luctus. Morbi cursus fringilla elementum. Phasellus bibendum turpis nec eros tristique venenatis. Ut fermentum et lacus luctus congue. Pellentesque mattis nunc sapien, bibendum malesuada nisi ultricies ut. Sed ut rhoncus metus. Nulla ultrices ut orci sit amet faucibus. Nam et ultricies tortor. Mauris ornare ultricies enim, sit amet tempus libero hendrerit a. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin vitae lorem lacus.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Vestibulum sagittis sapien eget eros commodo, in iaculis nisi tristique. Vivamus ultrices, ex id auctor semper, ante metus aliquet lacus, eget vulputate ante risus in dui. Cras id lacus ac enim efficitur aliquet. Vestibulum sed tempor odio, sed laoreet tellus. In hac habitasse platea dictumst. Mauris cursus auctor sapien, eget dictum odio ornare eget. Pellentesque vestibulum aliquet est, maximus sodales libero sodales vitae. Curabitur dictum ante nunc, vitae pharetra tellus tincidunt eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">In varius erat pharetra, cursus lorem quis, aliquam eros. Cras aliquet aliquet mattis. Duis id posuere quam, non ornare ligula. Phasellus non odio felis. Nunc quis velit et lorem euismod congue id ac nunc. Aenean ut orci in tortor pulvinar ornare at ac risus. Cras dictum, arcu eleifend semper fermentum, arcu leo ullamcorper est, at porttitor nisl dui id dolor. Vestibulum urna felis, euismod in egestas sed, hendrerit in tortor. Phasellus in tellus sapien. Integer mattis nisi orci, eu mollis risus imperdiet non. Curabitur id semper ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec lorem est, bibendum sit amet nulla quis, bibendum sagittis risus. Integer vel nisl aliquet, placerat dui vitae, pretium nisl.</p>
                                        <h3 class="mrg20B">Maecenas hendrerit rutrum feugiat</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Nullam id erat ut nibh accumsan luctus ut sit amet eros. Etiam vitae tempor odio, egestas congue ex. Donec in vestibulum tortor. Sed condimentum libero sit amet ipsum volutpat, ac mattis leo porttitor. Suspendisse cursus tempus metus at molestie. Etiam sagittis, massa nec tincidunt convallis, nunc augue ultricies magna, sit amet consectetur nisl nisi quis justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce odio felis, vestibulum nec volutpat at, iaculis in mauris.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Morbi pharetra sit amet lectus et egestas. Ut augue nibh, pellentesque nec justo vitae, ornare volutpat sem. Mauris quis posuere est, varius faucibus nisi. Praesent dignissim dolor vitae risus auctor porta eget venenatis risus. Fusce posuere metus ac magna posuere commodo. Praesent placerat purus sit amet diam euismod, non tristique urna maximus. Proin egestas, mi non scelerisque iaculis, ipsum lectus porta massa, a viverra ante urna non nisi. Nulla lorem odio, feugiat quis iaculis vel, aliquet ut felis. Praesent ultrices tortor ut ipsum molestie, sed hendrerit nunc sagittis. Etiam luctus sapien eu risus imperdiet, sit amet dapibus quam efficitur.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Donec lacinia orci urna, at mollis sem tempor at. Nulla interdum ultrices eros, et scelerisque lectus sodales at. Donec eu vehicula ex, vitae pellentesque sem. Praesent placerat ut nunc ac bibendum. In eget finibus neque. Aliquam pellentesque nisi pulvinar purus molestie, non porta ipsum blandit. Proin pretium sapien justo, id molestie nisi finibus at. Sed tempor finibus urna, eu posuere orci tincidunt dignissim. Donec eget lacus et nulla egestas auctor. Ut bibendum eget eros et efficitur. Aliquam egestas mauris non fringilla sagittis. Aliquam nec libero eu leo auctor sagittis. Aenean facilisis pretium porttitor. Vivamus mattis interdum augue nec convallis.</p>
                                        <h3 class="mrg20B">Mauris eget tincidunt nisi</h3>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Donec a lacinia lectus. Curabitur fermentum tortor quis elit varius, suscipit consequat nunc lacinia. Donec at sem augue. Mauris auctor eros non bibendum vulputate. Sed non nisi vitae lorem cursus ultrices. Donec ullamcorper congue finibus.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Etiam porttitor fringilla libero sit amet scelerisque. Maecenas maximus nunc quis odio laoreet fermentum. Nulla ultricies fermentum convallis. Ut iaculis, diam quis elementum egestas, tortor elit malesuada risus, ut fermentum tortor nisl sit amet metus. Sed risus leo, blandit et pharetra a, pretium eu risus. Vivamus porttitor varius elit quis convallis. Aliquam a libero egestas, suscipit libero sed, euismod urna. Cras dapibus ultricies dui, id congue urna vestibulum non. Phasellus maximus erat quis tellus aliquet, eu tincidunt diam laoreet. Etiam vestibulum ex ac tempor tincidunt. Phasellus vestibulum quam lacinia nibh dapibus, non facilisis quam volutpat. Nullam nec fringilla quam. Sed condimentum ut est vitae blandit. Morbi aliquam, risus sit amet sollicitudin vulputate, ante sem volutpat elit, vestibulum tristique risus lacus nec elit. Sed laoreet est sed purus congue viverra. Donec tellus dolor, ultrices a venenatis id, pellentesque quis odio.</p>
                                        <p class="mrg20B font-gray-dark" style="line-height: 2em">Donec eget consectetur diam. Etiam id dolor mollis est dictum scelerisque eu at nunc. Sed congue viverra sapien eget feugiat. Integer ut molestie eros, eget sagittis mauris. Maecenas ullamcorper sit amet quam sit amet tristique. Etiam placerat venenatis dui, eget convallis sem iaculis convallis. Quisque molestie justo et vestibulum porttitor. Suspendisse potenti. Sed et ligula nec tortor egestas cursus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	
								</div>
						</div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>