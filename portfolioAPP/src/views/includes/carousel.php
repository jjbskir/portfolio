<link href="{{ app.request.basepath }}/css/includes/carousel.css" rel="stylesheet">
<!-- Carousel  ========================= -->
<div id="myCarousel" class="carousel slide">
    <div class="carousel-inner">
          
{% set count = 0 %}
{% for image in images %}
    
    {% if count == 0 %}
        <div class="active item">
    {% else %}
        <div class="item">
    {% endif %}

        <img src="{{ image.location }}" />
            <div class="container">
                <div class="carousel-caption">
                    <p class="lead">
                        {{ image.caption }}
                </div>
            </div>
        </div>

       
    {% set count = 1 %}
{% endfor %} 
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
</div>
<!-- /.carousel -->