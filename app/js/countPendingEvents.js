var ajax = new XMLHttpRequest();
ajax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var sCount = this.responseText;
        var iCount = JSON.parse(sCount)
        
        if (iCount > 0) {
            // add count function
            pendingCount.insertAdjacentHTML("beforeend", '<span  class="notificationBadge">'+ iCount +'</span>');
        }
        
    }
}
ajax.open( "GET", 'http://localhost:3333/count-pending-events', true );
ajax.send();