<!DOCTYPE html>
<html>
<head>
    <title>teste</title>
</head>
<body>
<canvas id="myChart" width="300" height="150"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="/assets/js/relatorio/grafico.js"></script>
<script>
    var data = JSON.parse('<?php print json_encode($data[1]); ?>');
    var label = JSON.parse('<?php print json_encode($data[0]); ?>');
    preencheGrafico(data, label);
</script>
</body>
</html>