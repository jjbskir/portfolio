

{% include 'includes/header.php' %}

<div class="container">
    <div id="login">
    <h1> Login Form </h1>
    <form action="{{ path('admin_login_check') }}" method="post">
        {{ error }}
        <div class="span1" id="loginForm">
            <p> First_Name  </p>
            <input type="text" name="_username" value="{{ last_username }}" />
            <p> Password </p>
            <input type="password" name="_password" value="" />
            <input type="submit" />
        </div>
    </form>
    </div>


{% include 'includes/footer.php' %}
