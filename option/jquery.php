
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ระบบบริหารความเสี่ยง</title>
	 <link rel="stylesheet" href="jquery/development-bundle/themes/ui-lightness/jquery.ui.all.css">
  	<!--<script src="jquery/js/jquery-1.9.1.js"></script>-->

	<script src="jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
 	<script src="jquery/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jquery/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jquery/development-bundle/ui/jquery.ui.button.js"></script>
	<script src="jquery/development-bundle/ui/jquery.ui.position.js"></script>
	<script src="jquery/development-bundle/ui/jquery.ui.menu.js"></script>
	<script src="jquery/development-bundle/ui/jquery.ui.autocomplete.js"></script>
	<script src="jquery/development-bundle/ui/jquery.ui.tooltip.js"></script>

    <!-- <script src="jquery/development-bundle/ui/jquery-ui.custom.js"></script> -->
  
 	<style>
	.custom-combobox {
		position: relative;
		display: inline-block;
	}
	.custom-combobox-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
		/* support: IE7 */
		*height: 1.7em;
		*top: 0.1em;
	}
	.custom-combobox-input {
		margin: 0;
		padding: 0.3em;
	}
	</style>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " didn't match any item" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.data( "ui-autocomplete" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox1" ).combobox(); //สถานที่เกิดเหตุ
		$( "#combobox2" ).combobox(); //หน่วยงานที่เกี่ยวข้อง
		$( "#combobox3" ).combobox(); //หน่วยงานที่เกี่ยวข้อง


		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker1" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker2" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker3" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker4" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker5" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker6" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker7" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker8" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker9" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker10" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker11" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker12" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker13" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>
<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker14" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker15" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker16" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>


<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker17" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker18" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker19" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>

<script>
$(function() {
				var d=new Date(); 
				var toDay = d.getDate() + '/' 
				+ (d.getMonth()+1) + '/' 
				+ (d.getFullYear()+543);
					$( "#datepicker20" ).datepicker(
					{ dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					 isBuddhist: true, 
					// defaultDate: toDay ,
					 dayNames: ['อาทิตย์','จันทร์','อังคาร',
										'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
					 dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
					 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
										'เมษายน','พฤษภาคม','มิถุนายน',
										'กรกฎาคม','สิงหาคม','กันยายน',
										'ตุลาคม','พฤศจิกายน','ธันวาคม'],
					 monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
										 'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
										 'พ.ย.','ธ.ค.']
			});	
	});
	</script>



 <script>
  $(function() {
    $( "#hide-option1" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });
    $( "#hide-option2" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  
    $( "#hide-option3" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  
    $( "#hide-option4" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  
    $( "#hide-option5" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  
    $( "#hide-option6" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  

    $( "#hide-option7" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  
    $( "#hide-option8" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  
    $( "#hide-option9" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });  

 $( "#hide-option" ).tooltip({
      hide: {
        effect: "explode",
        delay: 250
      }
    });
    $( "#open-event" ).tooltip({
      show: null,
      position: {
        my: "left top",
        at: "left bottom"
      },
      open: function( event, ui ) {
        ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
      }
    });
  });
  </script>
   
  <script>
  $(function() {
    $( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });
  </script>



 
