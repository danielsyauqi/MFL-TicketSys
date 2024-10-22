const horizonScroll = document.querySelector(".ticket-content");

horizonScroll.addEventListener("wheel", function(e){

        if(e.wheelDelta > 0 ){
            this.scrollLeft -= 50;
        }
        else{
            this.scrollLeft += 50;

        }
    }, {passive: true}
    
);