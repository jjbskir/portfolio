
{% include 'includes/header.php' %}


<!-- Main content -->
<div class="container">
    {% include 'includes/gallery.php' with {'images' : images  } %}
    <div class="row">
        <div>
            <h1 id="project">
                {{ project.name|capitalize }}
            </h1>
                <a href="{{ project.externalLocation }}">
                    <button class="btn-large btn-primary" type="button">
                        Launch Project In Browser
                    </button>
                </a>
        </div>
    </div>

    <div class="row">
        <div>
            <p>
                {{ project.description }}
            </p>
            <p>
                Created On: {{ project.dateCreatedView }}
            </p>
        </div>
    </div>


        
{% include 'includes/footer.php' %}
