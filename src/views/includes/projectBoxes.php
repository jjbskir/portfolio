        <!-- Portfolio mini boxes -->
        <div class="row">
        {% for project in projects %}
            
            <a href="{{ path('portfolio') }}{{ project.name }}">
                <div class="span4" id="box">
                    <h2>{{ project.name }}</h2>
                    {% set location = project.name|split(' ')|join %}
                    <img src="{{ attribute(images, location) }}" />
                </div>
            </a>
        {% endfor %}  
        </div>
