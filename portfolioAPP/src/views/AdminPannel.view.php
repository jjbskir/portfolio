
{% include 'includes/header.php' %}
        
    <div class="container">
        
        <link href="{{ app.request.basepath }}/css/adminHeader.css" rel="stylesheet">
        {% include 'includes/adminHeader.php' with {'message' : message  } %}
        
        <!--
        <div class="row">
            <h1 id="projectList">
                Current Projects

                <a href="{{ path('adminPersonal') }}">Personal Info</a>
                <a href="{{ 'logout' }}"> Logout </a>
            </h1>  
            <h3>
                {{ message }}
            </h3>
            
        </div>
        -->
        
        <div class="row">
            <div id="projectList">
            {% for project in projects %}
                <a href="{{ project.name }}">{{ project.name }}</a>
            {% endfor %} 
            </div>   
        </div>

        <div class="row">
                <link href="{{ app.request.basepath }}/css/form.css" rel="stylesheet">
                {% include 'includes/form.php' with {'form': form, 'formName': 'Project' } %}
                {% include 'includes/form.php' with {'form': formType, 'formName': 'Project Type' } %}
                {% include 'includes/form.php' with {'form': formDeleteProjects, 'formName': 'Delete Projects' } %}
                {% include 'includes/form.php' with {'form': formUpdateShortAbout, 'formName': 'Update Short About' } %}
        </div>

{% include 'includes/footer.php' %}
