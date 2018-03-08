<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">

        <title>Laravel</title>

        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    </head>
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>


            <div class="center-input">
                <div class="row">
                    <div class="input-field col s8">
                        <input id="password" type="password" class="validate">
                        <label for="password">Geef uw in code</label>
                    </div>
                    <div class="input-field col s4">
                        <button class="btn waves-effect waves-light mybtn" type="submit" name="action">Send
                            <i class="material-icons right">send</i>
                        </button>

                    </div>
                </div>
            </div>

    </body>
</html>
