<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- jqeuery. -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>



<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/list-all">List All</a></li>
</ul



<!-- search.. -->
<form >
    <!-- label -->
    <label for="name">Search: </label>
    <input type="text" name="name" id="name" placeholder="Name">
</form>



<table class="table">
    <thead>
    <tr>
        <th scope="col">name</th>
        <th scope="col">color</th>
        <th scope="col">brand</th>
        <th scope="col">price</th>
        <th scope="col">stock</th>
        <th scope="col">created_at</th>
    </tr>

    </thead>


    <tbody>





    {% if data.status %}

    {% for item in data.data %}
    <tr>
        <td>{{ item._source.name }}</td>
        <td>{{ item._source.color }}</td>
        <td>{{ item._source.brand }}</td>
        <td>{{ item._source.price }}</td>
        <td>{{ item._source.stock }}</td>
        <td>{{ item._source.created_at }}</td>
    </tr>
    {% endfor %}

{% else %}
    <p>{{ data.message }}</p>
{% endif %}


    </tbody>



</table>