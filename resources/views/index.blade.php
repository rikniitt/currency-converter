<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Valuuttamuunnin</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        #content {
            margin: 1em;
            padding: .5em;
        }
        #content input {
            font-size: 4em;
            line-height: 4em;
            height: 4em;
        }
        .currency-symbol {
            font-size: 4em;
        }
    </style>
</head>
<body>
    <div class="container-fluid" id="content">

        <div class="row">

            <div class="col-xs-12 col-md-4 col-md-offset-4 text-center">
                <h1>Valuuttamuunnin</h1>
            </div>
        </div>

        <hr />

        <div class="row">

            <div class="col-xs-6 col-md-4 col-md-offset-2">
                <div class="form-group">
                    <select name="currency-1" id="currency-1" class="form-control js-change">
                        @foreach ($rates as $rate)
                            <option value="{{ $rate->rate }}" data-symbol="{{ $rate->currency->symbolUTF8 }}">{{ $rate->currencyAndName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control js-keyup" id="value-1" value="1" placeholder="1.0">
                        <div id="symbol-1" class="input-group-addon currency-symbol">e</div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-4">
                <div class="form-group">
                    <select name="currency-2" id="currency-2" class="form-control js-change">
                        @foreach ($rates as $rate)
                            <option value="{{ $rate->rate }}" data-symbol="{{ $rate->currency->symbolUTF8 }}">{{ $rate->currencyAndName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" id="value-2" placeholder="0" disabled>
                        <div id="symbol-2" class="input-group-addon currency-symbol">e</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <p class="text-center">
                <button type="button" class="btn btn-default btn-lg js-click">
                    <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                </button>
            </p>

        </div>

        <hr />

        <footer class="text-center">
            <p>
                <small>Valuuttakurssit on viimeksi päivitetty {{ $latest_update->format('Y-m-d') }}.</small>
            </p>
            <p>
                <small>
                    Valuuttamuunnos on laskettu käyttäen euron kursseja, joita julkaisee 
                    <a href="http://www.ecb.europa.eu/stats/exchange/eurofxref/html/index.en.html" target="_blank">European Central Bank</a>
                    <a href="http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml" target="_blank">API</a>.
                </small>
            </p>
        </footer>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script type="text/javascript">

        (function($) {

            function toEuros(val, rate) {
                return parseFloat(val / rate);
            }

            function toCurrency(val, rate) {
                return parseFloat(val * rate).toFixed(2);
            }

            function setSelected($options, text) {
                $options.filter(function() {
                    return $(this).text() === text;
                }).prop('selected', true);
            }

            function calculateAndDisplayConversion() {
                var val1 = parseFloat($('#value-1').val());
                var rate1 = parseFloat($('#currency-1').val());
                var rate2 = parseFloat($('#currency-2').val());

                var symbol1 = $('#currency-1 option:selected').data('symbol');
                var symbol2 = $('#currency-2 option:selected').data('symbol');
                $('#symbol-1').text(symbol1);
                $('#symbol-2').text(symbol2);

                if (val1 && rate1 && rate2) {
                    var val1E = toEuros(val1, rate1);
                    var result = toCurrency(val1E, rate2);

                    $('#value-2').val(result);
                }
            }

            // Bind event handlers
            $('.js-change').on('change', function() {
                calculateAndDisplayConversion();
            });
            $('.js-keyup').on('keyup', function() {
                calculateAndDisplayConversion();
            });
            $('.js-click').on('click', function() {

                // Swap values in to and from inputs.
                var val2 = parseFloat($('#value-2').val());
                var rate1 = $('#currency-1 option:selected').text();
                var rate2 = $('#currency-2 option:selected').text();

                $('#value-1').val(val2);
                setSelected($('#currency-1 option'), rate2);
                setSelected($('#currency-2 option'), rate1);

                calculateAndDisplayConversion();
            });

            // Set default selections on load.
            setSelected($('#currency-1 option'), 'EUR Euro');
            setSelected($('#currency-2 option'), 'USD US dollar');
            $('#value-1').trigger('keyup');

        })(jQuery);

    </script>
</body>
</html>