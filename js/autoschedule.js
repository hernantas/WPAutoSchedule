"use strict";

(function( $ ) {
    var nextDate = '';
    var nextDay = '';

    function getDay( date ) {
        let dt = new Date();
        let days = ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];
        let fDate = date.split('-');
        dt.setFullYear( fDate[2], fDate[1]-1, fDate[0] );
        return days[ dt.getDay() ];
    }

    function compareDay( day, counter ) {
        return counter < autoschedule.options['day_'+day];
    }

    function getCounter( date ) {
        return (date in autoschedule.scheduledCounter) ? autoschedule.scheduledCounter[date][0] : 0;
    }

    function randomRange( min, max ) {
        return formatDate(Math.floor(Math.random() * (max - min + 1)) + min);
    }

    function formatDate( n ) {
        return ("0" + n).slice(-2);
    }

    function getTimeFrom( day ) {
        return autoschedule.options['time_from_'+day];
    }

    function getTimeTo( day ) {
        return autoschedule.options['time_to_'+day];
    }

    function compareDay( day, counter ) {
        return counter < autoschedule.options['day_'+day];
    }

    function getCounter( date ) {
        return (date in autoschedule.scheduledCounter) ? autoschedule.scheduledCounter[date][0] : 0;
    }

    function changeSelectDate() {
        let fDate = nextDate.split('-');
        $( '#mm option:eq('+formatDate( parseInt(fDate[1]) - 1 )+')' ).prop( 'selected', true );
        $( "#jj" ).val(fDate[0]);
        $( "#aa" ).val(fDate[2]);

        let tf = getTimeFrom( nextDay );
        let tt = getTimeTo( nextDay );
        let hf = parseInt(tf.substr(0, 2));
        let ht = parseInt(tt.substr(0, 2));
        $( '#hh' ).val( randomRange( hf, ht ) );
        $( '#mn' ).val( ( ht != hf ) ? randomRange( 0, 59 ) : formatDate( 0 ) );
    }
    
    $(document).ready(function() {
        let schdl = $('#misc-publishing-actions');
        let info = $('<div class="misc-pub-section autoschedule-info"></div>');
        let sub = $('<div class="misc-pub-section"></div>');
        let btn = $('<input type="button" id="autoschedule" class="button button-large" value="Schedule'
            + (autoschedule.options.only_schedule == 'true' ? '' : ' & Publish') +
            '" style="margin-right:5px; float: right;" />')
        
        let dt = new Date();
        let bAvail = false;
        for (var i = 0; i < 360 && (!bAvail || i < 5); i++) {
            dt.setDate( dt.getDate() + 1 );
            let strDate = formatDate( dt.getDate() )+"-"+formatDate( dt.getMonth()+1 )+"-"+dt.getFullYear();
            let day = getDay( strDate );
            let curAvail = compareDay( day, getCounter( strDate ) );
            if (curAvail && !bAvail) {
                bAvail = true;
                nextDate = strDate;
                nextDay = day;
            }

            info.append( $( '<div>' + ( 
                strDate + ': <span '+ ( curAvail ? 'style="color: #009900"' :  'style="color: #993333"' ) +'>' + 
                ( curAvail ? 'available' : 'full' ) + 
                " [" + getCounter( strDate ) + ' of ' + autoschedule.options['day_'+getDay( strDate )] + "]</span>"
            ) + '</div>' ) );
        }

        schdl.append(info);
        sub.append(btn);
        sub.append($('<div class="clear"></div>'));
        schdl.append(sub);

        btn.click(function() {
            $(".edit-timestamp").click();
            changeSelectDate();
        });
    });
})( jQuery );