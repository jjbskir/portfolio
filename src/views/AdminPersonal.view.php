
{% include 'includes/header.php' %}

<link href="{{ app.request.basepath }}/css/adminHeader.css" rel="stylesheet">
<link href="{{ app.request.basepath }}/css/form.css" rel="stylesheet">

<link rel="stylesheet" href="{{ app.request.basepath }}/css/jquery-ui.css" />
<script src="{{ app.request.basepath }}/js/jquery.js"></script>
<script src="{{ app.request.basepath }}/js/jquery-ui.js"></script> 

<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
 </script>
 
<div class="container">
      
    {% include 'includes/adminHeader.php' with {'message' : message} %}
    
    <div class="row" id="tabs">
            <ul>
                <li><a href="#tabs-1">Personal Information</a></li>
                <li><a href="#tabs-2">Skills</a></li>
            </ul>
            <div id="tabs-1">
                <p>
                {% include 'includes/form.php' with {'form': formUpdateAbout, 'formName': 'Update About' } %}
                {% include 'includes/form.php' with {'form': formUpdateName, 'formName': 'Update Name' } %}
                {% include 'includes/form.php' with {'form': formUpdateContact, 'formName': 'Update Contact' } %}
                {% include 'includes/form.php' with {'form': formUpdateUsername, 'formName': 'Update Username' } %}
                {% include 'includes/form.php' with {'form': formUpdatePassword, 'formName': 'Update Password' } %}
                </p>
            </div>
            <div id="tabs-2">
                <p>
                {% include 'includes/form.php' with {'form': formAddSkillType, 'formName': 'Add Skill Type' } %}
                {% include 'includes/form.php' with {'form': formAddSkill, 'formName': 'Add Skill' } %}
                {% include 'includes/form.php' with {'form': formDeleteSkill, 'formName': 'Delete Skill' } %}
                </p>
            </div>
    </div>
        

{% include 'includes/footer.php' %}



