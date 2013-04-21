
{% include 'includes/header.php' %}
        
    <div class="container">
        
        <div class="row">
            <h3>
                 {{ about }}
            </h3>
        </div>
        
        <div id="aboutDivide">
            <hr>
        </div>
        
        <div class="container">
        {% for key,type in skills %}

            <div class="row" >
                <ul>
                    <h3> {{ key|title }} </h3>
                
                {% for skill in type %}
                    <li>
                        {{ skill.skill }}
                        {% if loop.last %}
                            
                        {% else %}
                            ,
                        {% endif %}
                    </li>
                
            
                {% endfor %}
                 
                </ul>
            </div>
        {% endfor %} 
        
{% include 'includes/footer.php' %}