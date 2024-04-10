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
    <input type="text" name="name" class="searchFormElement" id="name" placeholder="Name">


    <label for="name">Search Type: </label>
    <select name="type" id="type" class="searchFormElement">
        <option value="by_name">Match By Name </option>
        <option value="by_color">Match By Color</option>
        <option value="by_brand">Match By Brand</option>
        <option value="by_all_match">Match By Everything </option>
    </select>



    <!-- count .. -->
    <label for="name">number of listings: </label>
    <input type="text" class="searchFormElement" value="40" name="counter" id="counter" placeholder="Count">

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


<script>
    $(document).on('keyup','.searchFormElement',function(){
        var name = $("#name").val();
        var type = $('#type').val();
        var counter = $('#counter').val();

        $.ajax({
            url: '/search',
            type: 'GET',
            data: {name: name, type: type, counter: counter},
            success: function(data){
                let response = JSON.parse(data);
                console.log(response);

                if(response.status){
                    let html = '';
                    response.data.forEach(function(item){
                        html += '<tr>';
                        html += '<td>'+item._source.name+'</td>';
                        html += '<td>'+item._source.color+'</td>';
                        html += '<td>'+item._source.brand+'</td>';
                        html += '<td>'+item._source.price+'</td>';
                        html += '<td>'+item._source.stock+'</td>';
                        html += '<td>'+item._source.created_at+'</td>';
                        html += '</tr>';
                    });
                    $('tbody').html(html);
                }
                else{
                    $('tbody').html('<p>'+response.message+'</p>');
                }

            }
        });
    });



</script>