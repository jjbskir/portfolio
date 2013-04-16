
<!-- Portfolio mini boxes -->
<div class="container">
{% for key,type in projects %}

    <div class="row" >
        <div class="span19">
            <div class="span5 offset3" id="centered">
                <h1>
                    {{ key }}
                </h1>
            </div>
            <br>
         </div>
    </div>
        
    <div class="row" >
        {% for project in type %}
        <a href="{{ path('portfolio') }}{{ project.name }}">
        <div class="span4">
            <h3>{{ project.name }}</h3>
            {% set location = project.name|split(' ')|join %}
            <img src="{{ attribute(images, location) }}" />
           
        </div>
         </a>
        {% endfor %}
    </div>
        
<br><br><br><br>
{% endfor %} 


