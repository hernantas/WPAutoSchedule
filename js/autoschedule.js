(function( $ ) {
    $(document).ready(function() {
        let schdl = $('#misc-publishing-actions');
        let sub = $('<div class="misc-pub-section"></div>')
        let btn = $('<input type="button" id="autoschedule" class="button button-large" value="Schedule (Auto)" style="margin-right:5px; float: right;" />')
        sub.append(btn);
        sub.append($('<div class="clear"></div>'));
        schdl.append(sub);

        btn.click(function() {
            console.log(autoschedule);
        });
    });
})( jQuery );