{% include 'includes/header.php' %}

<div class="container">

     <link href="{{ app.request.basepath }}/css/adminHeader.css" rel="stylesheet">
     {% include 'includes/adminHeader.php' with {'message' : message} %}
   
    <div class="row">
        <h1>
            {{ projectName }}
        </h1>  
    </div>
 

    <div class="row">
        <p>
            Upload Images with dimensions width: 2 to height: 1.
        </p>
        <link href="{{ app.request.basepath }}/css/form.css" rel="stylesheet">
        {% include 'includes/form.php' with {'form': formAddImage, 'formName': 'Add Image' } %}
        {% include 'includes/form.php' with {'form': formUpdateThumbnail, 'formName': 'Change Thumbnail' } %}
        {% include 'includes/form.php' with {'form': formDeleteImages, 'formName': 'Delete Images' } %}
        {% include 'includes/form.php' with {'form': formUpdateDescription, 'formName': 'Update Description' } %}
        {% include 'includes/form.php' with {'form': formUpdateExternalLocation, 'formName': 'Update External Location' } %}
    </div>

{% include 'includes/footer.php' %}

