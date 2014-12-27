$(function() {
    var uiElements = function(){
        //OWL Carousel
        var uiOwlCarousel = function(){
            
            if($(".owl-carousel").length > 0){
                $(".owl-carousel").owlCarousel({mouseDrag: false, touchDrag: true, slideSpeed: 300, paginationSpeed: 400, singleItem: true, navigation: false,autoPlay: true});
            }
            
        }//End OWL Carousel

        //TemperatureChart
        var uiSensorCharts = function(){
              nvd3Charts.init();
        }//End TemperatureChart

        $(window).resize(function(){
            if($(".owl-carousel").length > 0){
                $(".owl-carousel").data('owlCarousel').destroy();
                uiOwlCarousel();
            }
        });
        return {
            init: function(){
                uiOwlCarousel();    
                uiSensorCharts();    
            }
        }
        
    }();
    uiElements.init();
    // New selector case insensivity        
     $.expr[':'].containsi = function(a, i, m) {
         return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
     };              
});

function update(el,mode){
    mode = mode || 1;
    nvd3Charts.init(mode);
    $( ".time" ).html( $( el ).html());
}

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};