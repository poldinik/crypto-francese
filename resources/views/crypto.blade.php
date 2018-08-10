<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CryptoFrancese</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <style>

        html, body{
            font-family: 'Roboto', sans-serif;
        }

        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        div {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 3px solid #ccc;
            -webkit-transition: 0.5s;
            transition: 0.5s;
            outline: none;
        }

        #spacer{
            padding: 10px;
            background-color: white;
        }

        .container {
            border-radius: 5px;
            padding: 20px;
        }

    </style>

    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
</head>
<body>

<h1 style="text-align: center">CryptoFrancese</h1>

<div class="container">
    <form id="formoid" action="api/crypto" method="POST">
        <label for="fname">Testo</label>
        <input type="text" id="text" name="text" placeholder="Your text.." required>

        <label for="country">Tipologia</label>
        <select id="dict" name="type">
            <option value="1">Chiave Alfabetica</option>
            <option value="2">Chiave 163</option>
            <option value="3">Chiave 406 rebus</option>
            <option value="4">Chiave 2327</option>
        </select>

        <input type="submit" value="Calcola">
    </form>
</div>
<div id="spacer">

</div>
<div id="result">
</div>
<script type='text/javascript'>
    /* attach a submit handler to the form */
    $("#formoid").submit(function(event) {

        /* stop form from submitting normally */
        event.preventDefault();

        /* get the action attribute from the <form action=""> element */
        var $form = $( this ),
            url = $form.attr( 'action' );

        /* Send the data using post with element id name and name2*/
        var posting = $.post( url, { text: $('#text').val(), type: $('#dict').val() } );

        /* Alerts the results */
        posting.done(function( data ) {
            document.getElementById('result').innerText = "Somma totale: "+posting.responseText;
        });
    });
</script>
</body>
</html>
