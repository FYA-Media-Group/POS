<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<script>
$(document).ready(function() {
    $("#calendar-example-1").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        defaultDate: "2014-01-12",
        editable: !0,
        events: [{
            title: "All Day Event",
            start: "2014-01-01"
        }, 
			<?php
		$DB = Connect();
	   
		$date=date('Y-m-d');
	
		$sqlst = "SELECT * FROM tblEmployeeWeekOff where EID!=''";
				
		$RSst = $DB->query($sqlst);
		if ($RSst->num_rows > 0) 
		{
			$counter = 0;

			while($rowst = $RSst->fetch_assoc())
			{
				$counter ++;
				
				$EID = $rowst["EID"];
				
				$seldataqt=select("EmployeeName","tblEmployees","EID='".$EID."'");
	            $EmployeeName=$seldataqt[0]['EmployeeName'];
				
				$WeekOffStartDate = $rowst["WeekOffStartDate"];
				$WeekOffEndDate = $rowst["WeekOffEndDate"];
	?>
					{
					    title: "<?=$EmployeeName?>",
						start: "<?=$WeekOffStartDate?>",
						end: "<?=$WeekOffEndDate?>"
					}, 
	<?php
			}
			
		}
		
		$DB->close();
	?>		
          
        ]
    }), $("#external-events div.external-event").each(function() {
        var a = {
            title: $.trim($(this).text())
        };
        $(this).data("eventObject", a), $(this).draggable({
            zIndex: 999,
            revert: !0,
            revertDuration: 0
        })
    }), $("#calendar-example-2").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        editable: !0,
        droppable: !0,
        drop: function(a) {
            var b = $(this).data("eventObject"),
                c = $.extend({}, b);
            c.start = a, $("#calendar-example-2").fullCalendar("renderEvent", c, !0), $("#drop-remove").is(":checked") && $(this).remove()
        }
    })
});
</script>