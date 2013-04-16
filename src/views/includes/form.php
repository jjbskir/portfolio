 

<div class="span4" id="adminForm">
    {{ form_errors(form) }}
    <h3 id="formTitle">
        {{ formName }}
    </h3>            
    <form action="#" method="post"  {{ form_enctype(form) }}>
            {{ form_widget(form) }}
        <input type="submit" name="submit{{ formName|split(' ')|join }}" value="Submit" />
    </form>        
</div>
