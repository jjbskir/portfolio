
<link rel="stylesheet" type="text/css" href="{{ app.request.basepath }}/css/pirobox/style.css" />
<link rel="stylesheet" type="text/css" href="{{ app.request.basepath }}/css/includes/gallery.css" />

<script type="text/javascript" src="{{ app.request.basepath }}/js/pirobox/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="{{ app.request.basepath }}/js/pirobox/pirobox_extended.js"></script>

<script type="text/javascript">
    
    $(document).ready(function() {
        /* piro box */
        $().piroBox_ext({
                piro_speed : 700,
                bg_alpha : 0.5,
                piro_scroll : true // pirobox always positioned at the center of the page
        });
    });
    
</script>

<div id="container" class="clearfix" >

    <ul class="thumbnails">
    {% for image in images %}
    
        <li class="span2">
        <div class="element photos">
            <a href="{{ image.location }}" rel="gallery" class="pirobox_gall thumbnail" title="{{ image.caption }}">
                <img src="{{ image.location }}" alt="{{ image.caption }}"/>
            </a>
        </div>
        </li>
    {% endfor %} 
    </ul>	

</div> <!-- #container -->