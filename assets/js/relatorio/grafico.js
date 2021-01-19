function preencheGrafico(data,label) {
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: label,
            datasets: data
        },

        // Configuration options go here
        options: {}
    });
}

