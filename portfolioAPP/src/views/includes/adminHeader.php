

{% set current = path(app.request.attributes.get('_route'), 
app.request.attributes.get('_route_params')) %}
        
<div class="row" id="adminHeader">
    <h1>
        <a href="{{ path('admin') }}" {% if current != path('adminPersonal') %} id="current" {% endif %}> Current Projects </a>
        <a href="{{ path('adminPersonal') }}" {% if current == path('adminPersonal') %} id="current" {% endif %}> Personal Info </a>
        <a href="{{ path('admin_logout') }}"> Logout </a>
    </h1>
    <h3>
        {{ message }}
    </h3>   
</div>
