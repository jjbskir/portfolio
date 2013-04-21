
{% include 'includes/header.php' %}
    
<div class="container">
        
    <link href="{{ app.request.basepath }}/css/adminHeader.css" rel="stylesheet">
    {% include 'includes/adminHeader.php' with {'message' : message} %}
    
    <div class="row">
        <link href="{{ app.request.basepath }}/css/form.css" rel="stylesheet">
        {% include 'includes/form.php' with {'form': formUpdateAbout, 'formName': 'Update About' } %}
        {% include 'includes/form.php' with {'form': formUpdateName, 'formName': 'Update Name' } %}
        {% include 'includes/form.php' with {'form': formUpdateContact, 'formName': 'Update Contact' } %}
        {% include 'includes/form.php' with {'form': formUpdateUsername, 'formName': 'Update Username' } %}
        {% include 'includes/form.php' with {'form': formUpdatePassword, 'formName': 'Update Password' } %}
        {% include 'includes/form.php' with {'form': formAddSkillType, 'formName': 'Add Skill Type' } %}
        {% include 'includes/form.php' with {'form': formAddSkill, 'formName': 'Add Skill' } %}
        {% include 'includes/form.php' with {'form': formDeleteSkill, 'formName': 'Delete Skill' } %}
    </div>
        

{% include 'includes/footer.php' %}



