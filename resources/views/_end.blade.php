<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

	<!-- BOOTSTRAP-->
	<script>
		$( '[data-popover="popover"]' ).popover({trigger: "hover"});
	</script>	
	<!-- END BOOTSTRAP -->
	
	
	<!-- PARSLEY VALIDATION -->
	<script type="text/javascript" src="{{ asset('vendor/parsley/parsley.js') }}"></script>
	<script>	
		$(".solsoForm").parsley({
			successClass: "has-success",
			errorClass: "has-error",
			classHandler: function (el) {
				return el.$element.closest(".form-group, td");
			}, 
			errorsContainer: function (el) {
				return el.$element.closest(".form-group, td");
			}
		});
	</script>	
	<!-- END PARSLEY VALIDATION -->

	
	<!-- DATA TABLES -->
	<script type='text/javascript' src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>  
	<script type='text/javascript' src="{{ asset('vendor/datatables/datatables-bootstrap.js') }}"></script>    
	<script>
		$('.solsoTable').dataTable();
	</script>
	<!-- END DATA TABLES -->	
	
	
	<!-- CKEDITOR -->
    <script type='text/javascript' src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
	<script type='text/javascript' src="{{ asset('vendor/ckeditor/adapters/jquery.js') }}"></script>
	<script>
	$(function(){
		UPLOADCARE_PUBLIC_KEY = "demopublickey";

        if ($('.solsoEditor').length) {
            $( 'textarea.solsoEditor' ).ckeditor({
                uiColor: '#9AB8F3',
                height: 400,
            });
        }

        if ($('.solsoSimplyEditor').length) {
            $( 'textarea.solsoSimplyEditor' ).ckeditor({
                uiColor: '#9AB8F3',
                height: 200,
                toolbar: 'Custom',
                toolbarStartupExpanded : false,
                toolbarCanCollapse  : false,
                toolbar_Custom: [
                                   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
                                   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', 'Smiley'],
                                ],
            });
        }
	});
	</script>
	<!-- END CKEDITOR -->	
	
	
	<!-- GOOGLE CHARTS -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
		@if ( Request::segment(1) == 'dashboard' || Request::segment(1) == 'report' || Request::segment(1) == 'admin' ) 
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart);

			function drawChart() {
				/* === INVOICES === */
				var data = google.visualization.arrayToDataTable(
					eval($('.chartInvoicesLastMonth').val())
				);
				var view = new google.visualization.DataView(data);
				view.setColumns([0, 1,
								   {
									calc: "stringify",
									sourceColumn: 1,
									type: "string",
									role: "annotation" },
								   2]);			
				var options = {
					fontName: 'Dosis',
					fontSize: 14,
					legend: { position: "none" },
					title: "{{ date('F Y') }}",
				};
				var chart = new google.visualization.ColumnChart(document.getElementById('chartInvoicesLastMonth'));
				chart.draw(view, options);
				
				var data = google.visualization.arrayToDataTable(
					eval($('.chartInvoicesLastYear').val())
				);
				var view = new google.visualization.DataView(data);
				view.setColumns([0, 1,
								   {
									calc: "stringify",
									sourceColumn: 1,
									type: "string",
									role: "annotation" },
								   2]);					
				var options = {
					fontName: 'Dosis',
					fontSize: 14,			
					title: "{{ date('Y') }}",
					legend: { position: "none" },
				};
				var chart = new google.visualization.ColumnChart(document.getElementById('chartInvoicesLastYear'));
				chart.draw(view, options);		
				/* === END INVOICES === */

				
				@if ( Request::segment(1) == 'report' )
					/* === AMOUNTS === */
					var data = google.visualization.arrayToDataTable(
						eval($('.chartAmountLastMonth').val())
					);
					var view = new google.visualization.DataView(data);
					view.setColumns([0, 1,
									   {
										calc: "stringify",
										sourceColumn: 1,
										type: "string",
										role: "annotation" },
									   2]);					
					var options = {
						fontName: 'Dosis',
						fontSize: 14,			
						title: "{{ date('F Y') }}",
						legend: { position: "none" },
					};
					var chart = new google.visualization.ColumnChart(document.getElementById('chartAmountLastMonth'));
					chart.draw(view, options);	
					
					var data = google.visualization.arrayToDataTable(
						eval($('.chartAmountLastYear').val())
					);
					var view = new google.visualization.DataView(data);
					view.setColumns([0, 1,
									   {
										calc: "stringify",
										sourceColumn: 1,
										type: "string",
										role: "annotation" },
									   2]);			
					var options = {
						fontName: 'Dosis',
						fontSize: 14,			
						title: "{{ date('Y') }}",
						legend: { position: "none" },
					};
					var chart = new google.visualization.ColumnChart(document.getElementById('chartAmountLastYear'));
					chart.draw(view, options);	
					/* === END AMOUNTS === */			
					
					/* === CLIENTS === */
					var data = google.visualization.arrayToDataTable(
						eval($('.chartClientsLastMonth').val())
					);
					var view = new google.visualization.DataView(data);
					view.setColumns([0, 1,
									   {
										calc: "stringify",
										sourceColumn: 1,
										type: "string",
										role: "annotation" },
									   2]);					
					var options = {
						fontName: 'Dosis',
						fontSize: 14,			
						title: "{{ date('F Y') }}",
						legend: { position: "none" },
					};
					var chart = new google.visualization.ColumnChart(document.getElementById('chartClientsLastMonth'));
					chart.draw(view, options);	
					
					var data = google.visualization.arrayToDataTable(
						eval($('.chartClientsLastYear').val())
					);
					var view = new google.visualization.DataView(data);
					view.setColumns([0, 1,
									   {
										calc: "stringify",
										sourceColumn: 1,
										type: "string",
										role: "annotation" },
									   2]);					
					var options = {
						fontName: 'Dosis',
						fontSize: 14,			
						title: "{{ date('Y') }}",
						legend: { position: "none" },
					};
					var chart = new google.visualization.ColumnChart(document.getElementById('chartClientsLastYear'));
					chart.draw(view, options);	
					/* === END CLIENTS === */
				@endif
				
				
				@if ( Request::segment(1) == 'admin' )
					/* === USERS === */
					var data = google.visualization.arrayToDataTable(
						eval($('.chartUsersLastMonth').val())
					);
					var view = new google.visualization.DataView(data);
					view.setColumns([0, 1,
									   {
										calc: "stringify",
										sourceColumn: 1,
										type: "string",
										role: "annotation" },
									   2]);			
					var options = {
						fontName: 'Dosis',
						fontSize: 14,
						legend: { position: "none" },
						title: "{{ date('F Y') }}",
					};
					var chart = new google.visualization.ColumnChart(document.getElementById('chartUsersLastMonth'));
					chart.draw(view, options);
					
					var data = google.visualization.arrayToDataTable(
						eval($('.chartUsersLastYear').val())
					);
					var view = new google.visualization.DataView(data);
					view.setColumns([0, 1,
									   {
										calc: "stringify",
										sourceColumn: 1,
										type: "string",
										role: "annotation" },
									   2]);					
					var options = {
						fontName: 'Dosis',
						fontSize: 14,			
						title: "{{ date('Y') }}",
						legend: { position: "none" },
					};
					var chart = new google.visualization.ColumnChart(document.getElementById('chartUsersLastYear'));
					chart.draw(view, options);		
					/* === END USERS === */	
				@endif	
			}
		@endif
    </script>
    <!-- END GOOGLE CHARTS -->	
	
	
	<!-- RENDRO EASY PIE CHART -->
	<script type="text/javascript" src="{{ asset('vendor/rendro-easy-pie-chart/dist/jquery.easing.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('vendor/rendro-easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
	<script type="text/javascript">
		$('.chart').easyPieChart({
			easing: 'easeOutBounce',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			}
		});
	</script>	
	<!-- END RENDRO EASY PIE CHART -->
	
	
	<!-- DATEPICKER -->
	<script type="text/javascript" src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.js') }}"></script>
	<script>	
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});

		$('.datepicker').on('changeDate', function() {
			$('.datepicker').datepicker('hide');
		});	
		
		var startDate 	= '';
		var endDate 	= '';
		$('#dp4').datepicker()
			.on('changeDate', function(ev){
				startDate = new Date(ev.date);
				$('#dp4').datepicker('hide');
			});
		$('#dp5').datepicker()
			.on('changeDate', function(ev){
				if (ev.date.valueOf() < startDate.valueOf()){
					$(".solsoErrorPopover").popover('show');
				} else {
					$(".solsoErrorPopover").popover('hide');
					endDate = new Date(ev.date);
				}
				$('#dp5').datepicker('hide');
			});		
	</script>		
	<!-- END DATEPICKER -->
	
	
	<!-- TIMEPICKER -->
	<script type="text/javascript" src="{{ asset('vendor/timepicker/js/bootstrap-timepicker.min.js') }}"></script>
	<script>	
		$('.timepicker').timepicker();		
	</script>		
	<!-- END TIMEPICKER -->
	

	<!-- SELECT 2 -->
	<script type="text/javascript" src="{{ asset('vendor/select2/select2.js') }}"></script>
	<script>	
		if ($('.solsoSelect2').length) {
			$( ".solsoSelect2" ).select2();
		}
	</script>	
	<!-- END SELECT 2 -->
	
	
	<!-- BOOTSTRAP FILEINPUT -->
	<script type="text/javascript" src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
	<script>	
		$(".solsoFileInput").fileinput({
			allowedFileExtensions: ['jpg', 'jpeg', 'gif', 'png', 'bmp']
		});		
	</script>		
	<!-- END BOOTSTRAP FILEINPUT -->

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': '{{ csrf_token() }}'
		}
	});
</script>
	
	<!-- === SOLUTII SOFT === -->
	<script>
		/* === PRODUCT === */
			$( document ).on('click', '.solsoShowDetails', function(){
				$.ajax({
					url: "product/" + $(this).attr('data-value'),
					type: 'get',
					dataType: 'json',
					data: { product: $(this).val() },
					success:function(data) {
						$( '.product-name' ).text(data['name']);
						$( '.product-price' ).text(data['price']);
						$( '.product-description' ).text(data['description']);
					}
				});
			});
		/* === END PRODUCT === */
	
		/* === CLONE ROW === */
		$('#createClone').on('click', function(e) {
			$( '.solsoSelect2.solsoCloneSelect2').select2('destroy');
			
			$( '.solsoParent' )
				.append( '<tr>' + $('.solsoParent tr:first').html()  + '</tr>' );
		
			$( '.crt' ).each(function( index ) {
				$( this ).text(index+1);
				
				if (index > 0) {
					$( this ).parent().find( '.removeClone' ).removeClass('disabled');
				}
			});			
			
			$( ".solsoSubTotal" ).last().text('0.000');
			
			$( '.solsoCloneSelect2' ).select2();

			return false;
		});
		
		$( document ).on('click', '.removeClone', function() {
			$(this).parents().eq(1).remove();
			
			$( '.crt' ).each(function( index ) {
				$( this ).text(index+1);
			});				
			
			if ( $(this).attr('data-id').length ) {
				$.ajax({
					url: "{{ URL::route('invoice.deleteProduct') }}",
					type: 'post',
					dataType: 'json',
					data: { id: $(this).attr('data-id') },
					success:function(data) {
					}
				});
			}
		});
		/* === END CLONE ROW === */	
		
		/* === INVOICE === */
		$( document ).on('change', '.solsoCloneSelect2', function() {
			inputPrice = $(this).closest('tr').find("[name='price[]']");
			
			$.ajax({
				url: "{{ URL::route('ajax.productPrice') }}",
				type: 'post',
				dataType: 'json',
				data: { product: $(this).val() },
				success:function(data) {
					inputPrice.val(data['price']);
					inputPrice.change();
				}
			});
		});		
		
		$( document ).on('change', '.solsoCurrencyEvent', function() {
			if ( $(this).val() != '') {
				$( '.solsoCurrency' ).text( $( "[name='currency'] option[value='" + $(this).val() + "']").text() );
			}
		});	
		
		$( document ).on("click change paste keyup", ".solsoEvent", function() {
			var qty			= $(this).closest('tr').find("[name='qty[]']").val();
			var price		= $(this).closest('tr').find("[name='price[]']").val();
			var tax			= $(this).closest('tr').find("[name='taxes[]']").val();
			var discount	= $(this).closest('tr').find("[name='discount[]']").val();
			var type		= $(this).closest('tr').find("[name='discountType[]']").val();	
			var totalDisc	= $("input[name='invoiceDiscount']").size() > 0 ? $("input[name='invoiceDiscount']").val() : $("input[name='quotationDiscount']").val();	
			var invoiceType	= $(this).closest('tr').find("[name='invoiceDiscountType']").val();	
			var revenue_stamp = $("input[name='revenue_stamp']").val();
			var subTotal	= 0;
			var total		= 0;
			
			itemQty			= parseFloat(qty)  > 0 		? parseFloat(qty).toFixed(3) 		: 0;
			itemPrice		= parseFloat(price)  > 0 	? parseFloat(price).toFixed(3) 		: 0;
			itemTax			= parseFloat(tax) > 0 		? parseFloat(tax).toFixed(3) 		: 0;
			itemDiscount	= parseFloat(discount) > 0	? parseFloat(discount).toFixed(3)	: 0;
			invoiceDiscount	= (invoiceType != '' && parseFloat(totalDisc) > 0)	? parseFloat(totalDisc).toFixed(3)	: 0;
			revenue_stamp   = parseFloat(revenue_stamp) > 0	? parseFloat(revenue_stamp).toFixed(3)	: 0;
			
			solsoValue 			= itemQty * itemPrice;
			solsoTax			= solsoValue * (itemTax / 100);
			solsoPrice			= solsoValue + solsoTax;
			solsoDiscount		= itemDiscount;
			solsoTotalDiscount	= invoiceDiscount;
			
			if ( type == 2 ) {
				solsoDiscount	= solsoPrice * (itemDiscount / 100);
			}
			
			subTotal		= solsoPrice - solsoDiscount;
			
			$(this).closest('tr').find(".solsoSubTotal").text( subTotal.toFixed(3) );
			
			$( '.solsoSubTotal' ).each(function() {
				total += parseFloat($(this).text());
			});
			
			if ( invoiceType == 2 ) {
				solsoTotalDiscount = total * (invoiceDiscount / 100);
			}
			total += parseFloat(revenue_stamp);
			
			$( '.solsoTotal' ).text( (total - solsoTotalDiscount).toFixed(3) );
		});
		/* === END INVOICE === */

		/* === SETTINGS === */
		$( document ).on('click', '.solsoCurrencySettings', function(e) {
			e.preventDefault();
			
			var id	 	= $(this).attr('data-id');
			var name 	= $(this).closest('label').find("input[type='radio']").attr('name');
			var value 	= $(this).closest('label').find("input[type='radio']").val();
			var url		= '';
		
			if ( name == 'position') {
				goToUrl = "{{ URL::route('currency.currencyPosition') }}";
			}
			
			if ( name == 'default') {
				goToUrl = "{{ URL::route('setting.defaultCurrency') }}";
			}			
		
			$.ajax({
				url: goToUrl,
				type: 'post',
				dataType: 'html',
				data: { itemID: id, itemValue: value },
				success:function(data) {
					$('#tab5').html(data);
				}
			});
			
			solsoAlerts();
		});
		/* === END SETTINGS === */
	</script>

	
	<script>
		/* === ADD TEXT EDITOR TO TEXTAREEA === */
		// uncomment next line if you want text-editor
		// $( 'textarea').addClass('solsoSimplyEditor');
		/* === END ADD TEXT EDITOR TO TEXTAREEA === */
	
		/* === CLOSE ALERTS === */
		function solsoAlerts()
		{
			window.setTimeout(function() {
				$(".solsoHideAlert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove(); 
				});
			}, 5000);		
		}
		
		solsoAlerts();
		/* === END CLOSE ALERTS === */
		
		/* === MODAL YES/NO === */
		$( document ).on('click', '.solsoConfirm', function(){
			$(" #solsoFormID ").prop('action', $(this).attr('data-url'));
		});
		/* === MODAL YES/NO === */
		
		// $(document).ready(function () { $('body').hide().fadeIn(1500).delay(6000)});
	</script>
	<!-- === END SOLUTII SOFT === -->
	
	
</body>
</html>